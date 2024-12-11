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
                        <li class="breadcrumb-item active">Add Enrollment</li>
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
                            <h3 class="card-title">Add Enrollment<small></small></h3>
                        </div>
                        <form role="form" id="quickForm" method="POST"
                            action="{{ route('admin.examEnrollments.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    {{-- @if ($errors->any())
                                    <div class="col-md-8">
                                        <div class="form-group">
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        </div>
                                    </div>
                                    @endif --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id">Users<span style="color: red;">*</span></label>
                                            <select id="user_id"
                                                class="form-control @error('user_id') is-invalid @enderror" name="user_id"
                                                required>
                                                <option value="" disabled
                                                    {{ old('user_id') == '' ? 'selected' : '' }}>-- Select User --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="booklet_id">Booklet<span style="color: red;">*</span></label>
                                            <select id="booklet_id"
                                                class="form-control @error('booklet_id') is-invalid @enderror"
                                                name="booklet_id" required>
                                                <option value="" disabled
                                                    {{ old('booklet_id') == '' ? 'selected' : '' }}>-- Select Booklet --
                                                </option>
                                                {{-- <option value="">-- Select Booklet --</option> --}}
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


                                    <!-- Date field for Exam Date -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exam_date">Exam Date<span style="color: red;">*</span></label>
                                            <input type="date" name="exam_date" class="form-control" id="exam_date"
                                                required>
                                            {{-- <br> --}}
                                            @error('exam_date')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Dropdown for status -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Exam Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <!-- Default placeholder option -->
                                                <option value="" disabled
                                                    {{ old('status') == '' ? 'selected' : '' }}>-- Select Status --
                                                </option>
                                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="completed"
                                                    {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>
                                                    Failed</option>
                                            </select>
                                            @error('status')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Comment field -->
                                    <div class="col-md-6" id="comments-textarea">
                                        <div class="form-group">
                                            <label for="comments">Comments</label>
                                            <textarea id="comments" name="comments" class="form-control" rows="4">{{ old('comments') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="/admin/examEnrollments"><button type="button"
                                        class="btn btn-info">Back</button></a>
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
    <script></script>
@endsection
