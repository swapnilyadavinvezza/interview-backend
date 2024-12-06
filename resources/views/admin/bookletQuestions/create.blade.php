@extends('admin.layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Add Booklet Question</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Booklet Question<small></small></h3>
                    </div>
                    <form role="form" id="quickForm" method="POST" action="{{ route('admin.bookletQuestion.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="booklet_id">Booklet</label>
                                        <select id="booklet_id" class="form-control @error('booklet_id') is-invalid @enderror" name="booklet_id" required>
                                            @foreach ($booklets as $booklet)
                                            <option value="{{ $booklet->id }}"
                                                {{ old('booklet_id') == $booklet->id ? 'selected' : '' }}>
                                                {{ $booklet->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('booklet_id')
                                        <span class="error invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="question_type">Question Type</label>
                                        <select id="question_type" class="form-control @error('question_type') is-invalid @enderror" name="question_type">
                                            <option value="">Select Question Type</option>

                                            <option value="mcq" {{ old('question_type') == 'mcq' ? 'selected' : '' }}>MCQ</option>
                                            <option value="text" {{ old('question_type') == 'text' ? 'selected' : '' }}>Text</option>
                                            <option value="image" {{ old('question_type') == 'image' ? 'selected' : '' }}>Image</option>

                                        </select>
                                        @error('question_type')
                                        <span class="error invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="question">Question</label>
                                        <input id="question" type="text"
                                            class="form-control @error('descrquestioniption') is-invalid @enderror" name="question"
                                            value="{{ old('question') }}" autocomplete="question" autofocus>
                                        @error('question')
                                        <span class="error invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="marks">Marks</label>
                                        <input id="marks" type="number"
                                            class="form-control @error('marks') is-invalid @enderror" name="marks"
                                            value="{{ old('marks') }}" autocomplete="marks" autofocus>
                                        @error('marks')
                                        <span class="error invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="mcq-options" style="display: none;">
                                    <div class="form-group">
                                        <label for="option_1">Option 1</label>
                                        <input type="text" id="option_1" name="option_1" class="form-control" value="{{ old('option_1') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="option_2">Option 2</label>
                                        <input type="text" id="option_2" name="option_2" class="form-control" value="{{ old('option_2') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="option_3">Option 3</label>
                                        <input type="text" id="option_3" name="option_3" class="form-control" value="{{ old('option_3') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="option_4">Option 4</label>
                                        <input type="text" id="option_4" name="option_4" class="form-control" value="{{ old('option_4') }}">
                                    </div>
                                </div>
                                <div class="col-md-6" id="correct_answer">
                                    <div class="form-group">
                                        <label for="correct_answer">Correct Answer</label>
                                        <select  class="form-control @error('correct_answer') is-invalid @enderror" name="correct_answer">
                                            <option value="">Select Correct Answer</option>
                                            <option value="question_1" {{ old('question_1') == 'question_1' ? 'selected' : '' }}>Option 1</option>
                                            <option value="question_2" {{ old('question_2') == 'question_2' ? 'selected' : '' }}>Option 2</option>
                                            <option value="question_3" {{ old('question_3') == 'question_3' ? 'selected' : '' }}>Option 3</option>
                                            <option value="question_4" {{ old('question_4') == 'question_4' ? 'selected' : '' }}>Option 4</option>
                                        </select>
                                        @error('correct_answer')
                                        <span class="error invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="answer-textarea" style="display: none;">
                                    <div class="form-group">
                                        <label for="answer">Answer</label>
                                        <textarea id="answer" name="answer" class="form-control" rows="4">{{ old('answer') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6" id="image-uploader" style="display: none;">
                                    <div class="form-group">
                                        <label for="image">Upload Image</label>
                                        <input type="file" id="image" name="image" class="form-control">
                                    </div>
                                </div>
                             

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="/admin/bookletQuestion"><button type="button" class="btn btn-info">Back</button></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                </form>
                <form id="emailForm" method="post" action="/admin/send-reset-link">
                    @csrf
                    <input type="hidden" name="password" id="generatedPassword" value="">
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('pagejs')
<script>
    const questionType = document.getElementById('question_type');
    const mcqOptions = document.getElementById('mcq-options');
    const answerTextarea = document.getElementById('answer-textarea');
    const imageUploader = document.getElementById('image-uploader');
    const correctAnswer = document.getElementById('correct_answer');

    // Show or hide MCQ options based on the selected type
    questionType.addEventListener('change', function() {
        if (questionType.value === 'mcq') {
            mcqOptions.style.display = 'block';
            correctAnswer.style.display = 'block';
            answerTextarea.style.display = 'none';
            imageUploader.style.display = 'none';
        } else if (questionType.value === 'text') {
            mcqOptions.style.display = 'none';
            answerTextarea.style.display = 'block';
            imageUploader.style.display = 'none';
        } else if (questionType.value === 'image') {
            mcqOptions.style.display = 'none';
            answerTextarea.style.display = 'none';
            imageUploader.style.display = 'block';
        } else {
            mcqOptions.style.display = 'none';
            correctAnswer.style.display = 'none';
            answerTextarea.style.display = 'none';
            imageUploader.style.display = 'none';
        }
    });

    // Check the initial value of question_type in case of a validation error or page reload
    if (questionType.value === 'mcq') {
        mcqOptions.style.display = 'block';
        correctAnswer.style.display = 'block';
        answerTextarea.style.display = 'none';
        imageUploader.style.display = 'none';
    } else if (questionType.value === 'short_answer' || questionType.value === 'long_answer') {
        mcqOptions.style.display = 'none';
        answerTextarea.style.display = 'block';
        imageUploader.style.display = 'none';
    } else if (questionType.value === 'image') {
        mcqOptions.style.display = 'none';
        answerTextarea.style.display = 'none';
        imageUploader.style.display = 'block';
    }else{
        correctAnswer.style.display = 'none';

    }
</script>
@endsection