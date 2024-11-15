<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\CmsPage;
use App\Models\Role;
use App\Models\User;
use App\Traits\AuthCode;
use App\Traits\CommonCode;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Laravel\Passport\HasApiTokens;

class UserController extends Controller
{
    use HasApiTokens,AuthCode, CommonCode;
    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->update([
            'status'             => 0,
            'email_verified_at'  => true,
            'verification_token' => null,
        ]);
        return $this->result(true, [], [], 'Email Verified successfully please login');

    }
    public function changePassword(Request $request)
    {
        return view('profile.changepassword');
    }
    public function dashboard()
    {
        $count         = [];
        $count['user'] = User::count();

        return view('dashboard', compact('count'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->deleted == 'true') {
                $users = User::onlyTrashed()->latest();
                return Datatables::of($users)
                    ->addColumn('action', function ($user) {
                        $btn = '<a href="/admin/user/restore/' . $user->id . '" class="" title="Restore"><i class="fa fa-trash-restore"></i></a>';
                        return $btn;
                    })->editColumn('created_at', function ($user) {
                    return [
                        'display'   => Carbon::parse($user->created_at)->format('d-m-Y h:i A'),
                        'timestamp' => $user->created_at,
                    ];
                })->editColumn('status', function ($user) {
                    return $user->status == 0
                    ? '<a href="/admin/user/status/' . $user->id . '" data-toggle="tooltip" data-placement="top" title="Unblock"><span class="badge badge-success">Unblock</span></a>'
                    : '<a href="/admin/user/status/' . $user->id . '" data-toggle="tooltip" data-placement="top" title="Blocked"><span class="badge badge-danger">Blocked</span></a>';
                })
                    ->escapeColumns([])

                    ->make(true);
            } else {
                $users = User::latest();
                return Datatables::of($users)
                    ->addColumn('action', function ($user) {
                        $btn = '<a href="/admin/user/edit/' . $user->id . '" class="" title="Edit"><i class="fa fa-edit"></i></a><a href="/admin/user/delete/' . $user->id . '" class="" title="Delete"><i class="fa fa-trash"></i></a>';
                        return $btn;
                    })->editColumn('created_at', function ($user) {
                    return [
                        'display'   => Carbon::parse($user->created_at)->format('d-m-Y h:i A'),
                        'timestamp' => $user->created_at,
                    ];
                })->editColumn('status', function ($user) {
                    return $user->status == 0
                    ? '<a href="/admin/user/status/' . $user->id . '" data-toggle="tooltip" data-placement="top" title="Unblock"><span class="badge badge-success">Unblock</span></a>'
                    : '<a href="/admin/user/status/' . $user->id . '" data-toggle="tooltip" data-placement="top" title="Blocked"><span class="badge badge-danger">Blocked</span></a>';
                })
                    ->escapeColumns([])

                    ->make(true);
            }
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
       
            $request->validate([
                'username'          => 'required|regex:/^[\pL\s]+$/u',
                'email'         => 'required|email|unique:users,email',
                'password'       => [
                    'required',
                    'min:8',
                    'confirmed',
                    'regex:/[A-Z]/',      // At least one uppercase letter
                    'regex:/[a-z]/',      // At least one lowercase letter
                    'regex:/[0-9]/', 
                ],              
                'role'          => 'required',
            ]);
            $password = $request->password;

            $data = [
                'username'     => $request->username,
                'email'    => trim($request->email),
                'status'   => isset($request->status) ? $request->status : 1,
                'password' => bcrypt($request->password),
                'role_id'  => $request->role,
                'first_name'  => $request->first_name,
                'last_name'  => $request->last_name,

            ];
           
            $user = User::create($data);

            if ($user) {
                $user['email']        = $user->email;
                $user['password_new'] = $password;

                return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
            }

        
    }

    public function edit(string $id)
    {
        $user = User::with('roles')->where('id', $id)->first();

        if ($user) {
            $roles    = Role::pluck('name', 'id')->toArray();
            $old_role = Role::where('id', $user->role_id)->first();
            return view('admin.users.edit', compact('user', 'roles', 'old_role'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
            $request->validate([
                'id' => 'required',
                'username'    => 'required|regex:/^[\pL\s]+$/u',
                'email'   => 'nullable',
                'password'=> 'nullable|confirmed',
                'role'    => 'required',
                'status'  => 'required|boolean',
            ]);
            $user      = User::findOrFail($request->id);
            if ($user) {
                $user->username    = $request['username'];
                $user->email   = trim($request['email']);
                $user->status  = $request['status'];
                $user->role_id = $request['role'];

                if (!empty($request['password_confirmation'])) {
                    $user->password = Hash::make($request['password_confirmation']);
                }
                $user->save();
                // delete old role and new attach
                DB::table('role_user')->where('user_id', $user->id)->delete();
                $user->attachRole($request->role);
                return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
            }

       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->first();

        if ($user) {
            $user->status = 1;
            $user->save();

            $status = $this->deleteUserData($user);
            if ($status) {
                return redirect()->back()->with('success', 'User deleted successfully !');
            } else {
                return redirect()->back()->with('error', 'Failed to delete user!');
            }
        } else {
            abort(404);
        }
    }
    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->first();
        if ($user) {
            $user->status            = 0;
            $user->email_verified_at = now();

            $user->save();
            $status = $user->restore();
            if ($status) {
                return redirect()->back()->with('success', 'User restore successfully !');
            } else {
                return redirect()->back()->with('error', 'Failed to restore user!');
            }
        } else {
            abort(404);
        }
    }

    public function status(Request $request, $id)
    {
        $user = User::find($id);
     
        if (isset($user->status) && $user->status == 1) {
            $user->status = 0;
            $user->update();
            $request->session()->flash('success', ' User Blocked');
        } else {
            $user->status = 1;
            $user->update();
            $request->session()->flash('success', ' User Unblock');
        }
        return redirect()->route('admin.users.index');

    }

    public function export(Request $request)
    {
        $query   = User::select("id", "username", "email", "status", "created_at")->get();
        $heading = array("id", "name", "email", "status", "created_at");
        return $this->exportModule($model = null, $query, $heading);
    }
    public function resetPassword(Request $request, $id)
    {
        $user = User::find($id);
        return view('profile.resetPassword', compact('user'));
    }
    public function sendResetUpdate(Request $request, $id)
    {
        $request->validate([
            'password'              => [
                'required',
                'min:8'
            ],
            'password_confirmation' => 'required|same:password', // Add any other validation rules you need
        ]);

        $user           = User::find($id);
        $userEmail      = $user->email;
        $user->password = Hash::make($request->password_confirmation);
        $user->save();
        $data['userEmail']      = $userEmail;
        $data['randomPassword'] = $request->input('password_confirmation');

        Mail::to($userEmail)->send(new ResetPasswordMail($data));
        return redirect()->route('admin.users.index')->with('success', 'User reset password successfully !');

    }
}
