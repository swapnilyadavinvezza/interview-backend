<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booklet;
use Illuminate\Http\Request;
use DataTables;
use Exception;
use Carbon\Carbon;

class BookletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            if ($request->deleted == 'true') {
                $booklets = Booklet::latest();

                return Datatables::of($booklets)
                    ->addColumn('action', function ($booklet) {
                        $btn = '<a href="/admin/booklet/restore/' . $booklet->id . '" class="" title="Restore"><i class="fa fa-trash-restore"></i></a>';
                        return $btn;
                    })->editColumn('created_at', function ($booklet) {
                        return [
                            'display'   => Carbon::parse($booklet->created_at)->format('d-m-Y h:i A'),
                            'timestamp' => $booklet->created_at,
                        ];
                    })->editColumn('status', function ($booklet) {
                        return $booklet->status == 0
                            ? '<span class="badge badge-success">Unblock</span>'
                            : '<span class="badge badge-danger">Blocked</span>';
                    })
                    ->escapeColumns([])

                    ->make(true);
            } else {

                $booklets = Booklet::latest();

                return Datatables::of($booklets)
                    ->addColumn('action', function ($booklet) {
                        $btn = '<a href="/admin/booklet/edit/' . $booklet->id . '" class="" title="Edit"><i class="fa fa-edit"></i></a><a href="/admin/booklet/delete/' . $booklet->id . '" class="" title="Delete"><i class="fa fa-trash"></i></a>';
                        return $btn;
                    })->editColumn('created_at', function ($booklet) {
                        return [
                            'display'   => Carbon::parse($booklet->created_at)->format('d-m-Y h:i A'),
                            'timestamp' => $booklet->created_at,
                        ];
                    })->editColumn('status', function ($booklet) {
                        return $booklet->status == 0
                            ? '<span class="badge badge-success">Unblock</span>'
                            : '<span class="badge badge-danger">Blocked</span>';
                    })
                    ->escapeColumns([])

                    ->make(true);
            }
        }
        return view('admin.booklets.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.booklets.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'          => 'required',
            'level'         => 'required',
            'duration'   => 'required|integer',
            'description'   => 'required',
            'status'         => 'required',
            'total_weightage'          => 'required|integer',
        ]);
        $data = [
            'name'     => $request->name,
            'level'    => $request->level,
            'status'   => isset($request->status) ? $request->status : 1,
            'description' => $request->description,
            'total_weightage'  => $request->total_weightage,
            'duration'  => $request->duration,
            'created_by'  => auth()->user()->id

        ];

        $booklet = Booklet::create($data);

        if ($booklet) {

            return redirect()->route('admin.booklets.index')->with('success', 'Booklet created successfully.');
        }
    }

    public function edit(string $id)
    {
        $booklet = Booklet::where('id', $id)->first();

        if ($booklet) {
            return view('admin.booklets.edit', compact('booklet'));
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
            'name'          => 'required',
            'level'         => 'required',
            'duration'   => 'required|integer',
            'description'   => 'required',
            'status'         => 'required',
            'total_weightage'          => 'required|integer',
        ]);
        $booklet      = Booklet::findOrFail($request->id);
        if ($booklet) {
            $booklet->name    = $request['name'];
            $booklet->level   = $request['level'];
            $booklet->description  = $request['description'];
            $booklet->status = $request['status'];
            $booklet->total_weightage = $request['total_weightage'];
            $booklet->duration = $request['duration'];
            $booklet->save();
            return redirect()->route('admin.booklets.index')->with('success', 'Booklet updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $booklet = Booklet::where('id', $id)->first();

            if ($booklet) {
                $booklet->delete();
                return redirect()->back()->with('success', 'Booklet deleted successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to delete booklet!');
            }
        } catch (Exception $e) {
           
            return redirect()->back()->with('error', 'An error occurred while deleting the booklet.');
        }
    }
}
