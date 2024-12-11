<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamEnrollment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

//use DataTables;
use PhpParser\Node\Stmt\TryCatch;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Booklet;

class ExamEnrollmentController extends Controller
{
    /**
     * Display a list of exam enrollments with options for viewing, editing, deleting, and restoring (soft-deleted).
     *
     * If the request is AJAX, it fetches either active or deleted exam enrollments and formats the data for Datatables, 
     * including actions like edit, delete, and restore. The status is displayed as a badge, and timestamps are formatted.
     * For non-AJAX requests, it returns the regular index view.
     *
     * @param Request $request The incoming request.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            if ($request->deleted == 'true') {
                // Fetch the deleted exam enrollments
                //$examEnrollments = ExamEnrollment::latest(); // Assumes soft delete

                // Fetch the soft-deleted exam enrollments
                $examEnrollments = ExamEnrollment::onlyTrashed()->latest();

                return Datatables::of($examEnrollments)
                    ->addColumn('action', function ($examEnrollment) {
                        // Button to restore soft-deleted exam enrollment
                        $btn = '<a href="/admin/examEnrollment/restore/' . $examEnrollment->id . '" class="" title="Restore"><i class="fa fa-trash-restore"></i></a>';
                        return $btn;
                    })
                    ->editColumn('user_id', function ($examEnrollment) {

                        return $examEnrollment->user ? $examEnrollment->user->username : 'No User';

                    })
                    ->editColumn('booklet_id', function ($examEnrollment) {

                        return $examEnrollment->booklet ? $examEnrollment->booklet->name : 'No Booklet';

                    })
                    ->editColumn('exam_date', function ($examEnrollment) {
                        return '<span data-timestamp="' . $examEnrollment->created_at->timestamp . '">' .
                            ($examEnrollment->created_at
                                ? $examEnrollment->created_at->format('d-m-Y')
                                : '') .
                            '</span>';
                    })
                    ->rawColumns(['exam_date'])  // Enables rendering HTML in the column
                    ->editColumn('status', function ($examEnrollment) {
                        switch ($examEnrollment->status) {
                            case 'pending':
                                return '<span class="badge badge-warning">Pending</span>';
                            case 'completed':
                                return '<span class="badge badge-success">Completed</span>';
                            case 'failed':
                                return '<span class="badge badge-danger">Failed</span>';
                            default:
                                return '<span class="badge badge-secondary">Unknown</span>';
                        }
                    })
                    ->escapeColumns([])
                    ->make(true);
            } else {
                // Fetch only non-deleted (active) exam enrollments
                $examEnrollments = ExamEnrollment::latest();

                return Datatables::of($examEnrollments)
                    ->addColumn('action', function ($examEnrollment) {

                        // Buttons for edit and delete
                        $btn = '<a href="/admin/examEnrollment/edit/' . $examEnrollment->id . '" class="" title="Edit" style="margin-right:10px"><i class="fa fa-edit"></i></a>';
                        //$btn .= '<a href="/admin/examEnrollment/delete/' . $examEnrollment->id . '" class="" title="Delete"><i class="far fa-trash-alt" style="color:red"></i></a>';
    
                        if ($examEnrollment->status == 'completed') {
                            // If status is 'completed', disable the button
                            $btn .= '<span class="disabled" title="Cannot delete as the exam is completed"><i class="far fa-trash-alt" style="color:gray"></i></span>';
                        } else {
                            // If status is not 'completed', show the delete button
                            $btn .= '<a href="/admin/examEnrollment/delete/' . $examEnrollment->id . '" class="" title="Delete"><i class="far fa-trash-alt" style="color:red"></i></a>';
                        }
                        return $btn;
                    })
                    ->editColumn('user_id', function ($examEnrollment) {

                        return $examEnrollment->user ? $examEnrollment->user->username : 'No User';

                    })
                    ->editColumn('booklet_id', function ($examEnrollment) {

                        return $examEnrollment->booklet ? $examEnrollment->booklet->name : 'No Booklet';
                    })
                    ->editColumn('exam_date', function ($examEnrollment) {
                        return '<span data-timestamp="' . $examEnrollment->created_at->timestamp . '">' .
                            ($examEnrollment->created_at
                                ? $examEnrollment->created_at->format('d-m-Y')
                                : '') .
                            '</span>';
                    })
                    ->rawColumns(['exam_date'])  // Enables rendering HTML in the column
                    ->editColumn('status', function ($examEnrollment) {
                        switch ($examEnrollment->status) {
                            case 'pending':
                                return '<span class="badge badge-warning">Pending</span>';
                            case 'completed':
                                return '<span class="badge badge-success">Completed</span>';
                            case 'failed':
                                return '<span class="badge badge-danger">Failed</span>';
                            default:
                                return '<span class="badge badge-secondary">Unknown</span>';
                        }
                    })
                    ->escapeColumns([])
                    ->make(true);
            }
        }

        // For non-AJAX request, return the regular view
        return view('admin.examEnrollments.index');

    }

    /**
     * Show the form for creating a new exam enrollment.
     *
     * This function fetches the necessary data to populate the form for creating a new exam enrollment:
     * - It retrieves all users from the `user` table to populate the user dropdown.
     * - It fetches all booklets with a status of '0' from the `booklet` table to populate the booklet dropdown.
     * 
     * The function then returns the `create` view, passing the fetched `users` and `booklets` to the view so they can be displayed in the form.
     *
     * @return \Illuminate\View\View The view for creating a new exam enrollment, with populated dropdown options for users and booklets.
     */
    public function create()
    {
        // Fetch all Users except the admin from the user table for the dropdown
        $users = User::where('role_id', 3)
            //->whereStatus('0')
            ->get();
        //dd($users);
        // Fetch all Booklets from the Booklet table for the dropdown
        $booklets = Booklet::whereStatus('0')->get();

        //$exams = ExamEnrollment::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.examEnrollments.create', compact('users', 'booklets'));
    }

    /**
     * Store a new exam enrollment record.
     *
     * This function validates the incoming request data, processes it to create an enrollment record for the exam, 
     * and stores it in the database. It assigns default values where necessary and uses the authenticated user's ID 
     * for the `user_id` field. After saving the record, the user is redirected to the exam enrollment index page 
     * with a success message. If the enrollment creation fails, the user is redirected back with validation errors 
     * and the previously input data.
     *
     * @param Request $request The incoming HTTP request containing the form data.
     */
    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure user_id exists in the users table (if applicable)
            //'booklet_id' => 'required',
            'booklet_id' => [
                'required',
                'exists:booklets,id',
                Rule::unique('exam_enrollments')->where('user_id', $request->user_id),
            ],
            'exam_date' => 'required|date',
            'status' => 'required',
            'marks_obtained' => 'nullable',
            'comments' => 'nullable|string',
        ]);

        $data = [
            'booklet_id' => $request->booklet_id,
            'exam_date' => $request->exam_date,
            'status' => $request->status,
            'marks_obtained' => $request->marks_obtained,
            'comments' => $request->comments,
            'user_id' => $request->user_id,
        ];

        $ExamEnrollment = ExamEnrollment::create($data);

        if ($ExamEnrollment) {

            return redirect()->route('admin.examEnrollments.index')->with('success', 'Exam Enrollment created successfully.');
        }
        //return redirect()->route('admin.examEnrollments.index')->withErrors($enrollmentValidator)->withInput();

    }

    /**
     * Display the form for editing an existing exam enrollment.
     *
     * This function retrieves the exam enrollment record based on the provided ID. If the record exists, it returns 
     * a view for editing the enrollment, passing the record data to the view. If no record is found for the given 
     * ID, it triggers a 404 error to indicate that the resource was not found.
     *
     * @param string $id The ID of the exam enrollment to edit.
     * @return \Illuminate\View\View|\Illuminate\Http\Response A view for editing the exam enrollment or a 404 error response.
     */
    public function edit(string $id)
    {

        $examEnrollment = ExamEnrollment::where('id', $id)->first();

        //$selectedUser= $examEnrollment->user ? $examEnrollment->user->username : 'No User';

        // Fetch all Users except the admin from the user table for the dropdown
        //$users = User::where('role_id', 3)->get();
        $users = User::where('role_id', 3)
            ->whereStatus('0')
            ->get();

        //$examEnrollment = ExamEnrollment::find($examEnrollment->booklet_id);

        // Fetch all Booklets from the Booklet table for the dropdown
        $booklets = Booklet::whereStatus('0')->get();

        if ($examEnrollment) {

            return view('admin.examEnrollments.edit', compact('examEnrollment', 'users', 'booklets'));
        } else {
            abort(404);
        }
    }

    /**
     * Update an existing exam enrollment record.
     *
     * This function validates the incoming request data to ensure that required fields are provided. It then retrieves 
     * the existing exam enrollment record by its ID using `findOrFail()`. If the record exists, it updates the fields 
     * with the new data from the request and saves the changes to the database. After successfully updating the record, 
     * the user is redirected to the exam enrollment index page with a success message. 
     * If the record is not found, the function does nothing (implicitly returns).
     *
     * @param Request $request The incoming HTTP request containing the updated data.
     */
    public function update(Request $request)
    {

        $request->validate([
            'booklet_id' => 'required',
            'exam_date' => 'required|date',
            'status' => 'required',
            'marks_obtained' => 'nullable',
            'comments' => 'nullable|string',
            'user_id' => 'required',
        ]);

        $examEnrollment = ExamEnrollment::findOrFail($request->id);
        if ($examEnrollment) {
            $examEnrollment->booklet_id = $request['booklet_id'];
            $examEnrollment->exam_date = $request['exam_date'];
            $examEnrollment->status = $request['status'];
            $examEnrollment->marks_obtained = $request['mark_obtained'];
            $examEnrollment->comments = $request['comments'];
            $examEnrollment->user_id = $request['user_id'];

            $examEnrollment->save();

            return redirect()->route('admin.examEnrollments.index')->with('success', 'Exam Enrollment updated successfully.');
        }

    }

    /**
     * Delete an existing exam enrollment record.
     *
     * This function attempts to find the exam enrollment record by its ID. If the record is found, it deletes the 
     * enrollment from the database and redirects the user back with a success message. If the record is not found, 
     * it redirects back with an error message indicating that the deletion failed. If an exception occurs during 
     * the deletion process, it catches the error and redirects back with a generic error message indicating that 
     * an issue occurred while attempting to delete the record.
     *
     * @param string $id The ID of the exam enrollment to delete.
     * @return \Illuminate\Http\RedirectResponse A redirect response with either a success or error message.
     */
    public function destroy(string $id)
    {
        try {
            $examEnrollment = ExamEnrollment::where('id', $id)->first();

            if ($examEnrollment) {
                $examEnrollment->delete();
                return redirect()->back()->with('success', 'Exam Enrollment deleted successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to delete exam enrollment');
            }

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the exam enrollment ');
        }
    }

    /**
     * Restore a soft-deleted exam enrollment record.
     *
     * This function attempts to restore a soft-deleted exam enrollment by its ID. 
     * It first checks if the enrollment exists in the trashed records using the 
     * `onlyTrashed()` method. If found, it attempts to restore the record.
     * 
     * On successful restoration, the user is redirected back with a success message.
     * If restoration fails, an error message is displayed. If no record is found 
     * in the trashed entries, a 404 error is triggered.
     *
     * @param int $id The ID of the exam enrollment to restore.
     * @return \Illuminate\Http\RedirectResponse Redirects back with a success or error message.
     */
    public function restoreExamEnrollment($id)
    {
        $examEnrollment = ExamEnrollment::onlyTrashed()->findOrFail($id);
        if ($examEnrollment) {
            $examEnrollment->restore(); // Restores the soft-deleted record

            if ($examEnrollment->restore()) {
                return redirect()->back()->with('success', 'Exam enrollment restored successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to restore enrollment!');
            }
        } else {
            abort(404);
        }
    }

}
