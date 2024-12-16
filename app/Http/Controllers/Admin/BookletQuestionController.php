<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booklet;
use App\Models\BookletQuestion;
use App\Traits\AuthCode;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class BookletQuestionController extends Controller
{
    use AuthCode;
    public function index(Request $request)
    {

        if ($request->ajax()) {


            $bookletQuestions = BookletQuestion::with('booklet')->get();

            return Datatables::of($bookletQuestions)
                ->addColumn('action', function ($bookletQuestion) {
                    $btn = '<a href="/admin/booklet/question/delete/' . $bookletQuestion->id . '" class="" title="Delete"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })->editColumn('created_at', function ($bookletQuestion) {
                    return [
                        'display'   => Carbon::parse($bookletQuestion->created_at)->format('d-m-Y h:i A'),
                        'timestamp' => $bookletQuestion->created_at,
                    ];
                })->editColumn('booklet', function ($bookletQuestion) {
                    return @$bookletQuestion->booklet->name;
                })->editColumn('question_type', function ($bookletQuestion) {
                    return match ($bookletQuestion->question_type) {
                        'text' => '<span class="badge badge-info">Text</span>',
                        'mcq' => '<span class="badge badge-warning">Multiple Choice</span>',
                        default => '<span class="badge badge-danger">Image</span>'
                    };                })
                ->escapeColumns([])

                ->make(true);
        }
        return view('admin.bookletQuestions.index');
    }

    public function create()
    {

        $booklets = Booklet::whereStatus('0')->get();
        return view('admin.bookletQuestions.create', compact('booklets'));
    }

    public function store(Request $request)
    {

        $validator = $request->validate([
            'booklet_id'          => 'required',
            'question_type' => 'required|string',
            'marks'   => 'required|integer',
            'question'          => 'required',
            'option_1' => 'required_if:question_type,mcq',
            'option_2' => 'required_if:question_type,mcq',
            'option_3' => 'required_if:question_type,mcq',
            'option_4' => 'required_if:question_type,mcq',
            'image'         => 'required_if:question_type,image|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'answer' => 'nullable',

        ]);
        $file_name = null;
        if ($request->hasFile('image')) {
            $file_name = $this->uploadImg($request->image, 'bookletsQuestions');
        }
        $data = [
            'booklet_id'     => $request->booklet_id,
            'question_type'    => $request->question_type,
            'question'    => $request->question,
            'marks'   => $request->marks,
            'option_1' => $request->option_1 ?? null,
            'option_2' => $request->option_2 ?? null,
            'option_3' => $request->option_3 ?? null,
            'option_4' => $request->option_4 ?? null,
            'answer'  => $request->correct_answer,
            'image' => $file_name ?? null
        ];

        $bookletQuestion = BookletQuestion::create($data);

        if ($bookletQuestion) {

            return redirect()->route('admin.bookletQuestion.index')->with('success', 'Booklet Question created successfully.');
        }
        return redirect()->route('admin.bookletQuestion.index')->withErrors($validator)->withInput();

    }
    public function destroy(string $id)
    {
        try {
            $bookletQuestion = BookletQuestion::where('id', $id)->first();

            if ($bookletQuestion) {
                $bookletQuestion->delete();
                return redirect()->back()->with('success', 'Booklet Question deleted successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to delete booklet question!');
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'An error occurred while deleting the booklet question.');
        }
    }
}
