<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\AuthCode;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use AuthCode;
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255'],
          
        ]);
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $file_name = null;
        if ($request->hasFile('photo')) {
            $file_name             = $this->uploadImg($request->photo, 'users');
        }
        $user = auth()->user();
        // dd($user);
        $request->user()->profile_photo = !empty($file_name) ? $file_name : $user->profile_photo;

        // $request->user()->profile_photo = $file_name;
        $request->user()->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function sendResetLink(Request $request)
    {
        $userEmail = $request->input('email');

        $data['userEmail'] = $request->input('email');
        $data['randomPassword'] = $request->input('password');

        Mail::to($userEmail)->send(new ResetPasswordMail($data));
        return redirect()->route('admin.users.index')->with('success', 'Password reset link sent successfully.');

    }


    public function changePasswordUpdate(Request $request){

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }
    
        $user->password = Hash::make($request->password);

        $user->save();
    
        return redirect()->route('admin.user.changePassword')->with('success', 'Password changed successfully');
    

    }
   
}
