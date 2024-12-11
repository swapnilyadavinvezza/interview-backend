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
                        <li class="breadcrumb-item active">Edit Enrollment</li>
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
                            <h3 class="card-title">Edit Enrollment <small></small></h3>
                        </div>

                        @php
                            $isDisabled =
                                isset($examEnrollment) && $examEnrollment->status === 'completed' ? 'disabled' : '';
                        @endphp

                        <form role="form" id="quickForm" method="POST"
                            action="{{ route('admin.examEnrollments.update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type='hidden' name='id' value="{{ $examEnrollment->id }}">
                            <div class="card-body">
                                <div class="row">
                                    {{-- User Name --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id">Users<span style="color: red;">*</span></label>
                                            <input type="hidden" name="user_id"
                                                value="{{ isset($examEnrollment) ? $examEnrollment->user_id : old('user_id') }}">
                                            <select id="user_id"
                                                class="form-control @error('user_id') is-invalid @enderror" name="user_id"
                                                required disabled {{ $isDisabled }}>
                                                <option value=""
                                                    {{ old('user_id', isset($examEnrollment) ? $examEnrollment->user_id : '') == '' ? 'selected' : '' }}>
                                                    -- Select User --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('user_id', isset($examEnrollment) ? $examEnrollment->user_id : '') == $user->id ? 'selected' : '' }}>
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

                                    {{-- Booklet Name --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="booklet_id">Booklet<span style="color: red;">*</span></label>
                                            <select id="booklet_id"
                                                class="form-control @error('booklet_id') is-invalid @enderror"
                                                name="booklet_id" required {{ $isDisabled }}>
                                                <option value=""
                                                    {{ old('booklet_id', isset($examEnrollment) ? $examEnrollment->booklet_id : '') == '' ? 'selected' : '' }}>
                                                    -- Select Booklet --
                                                </option>
                                                @foreach ($booklets as $booklet)
                                                    <option value="{{ $booklet->id }}"
                                                        {{ old('booklet_id', isset($examEnrollment) ? $examEnrollment->booklet_id : '') == $booklet->id ? 'selected' : '' }}>
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
                                            <label for="exam_date">Exam Date</label>
                                            <input type="date" name="exam_date" class="form-control" id="exam_date"
                                                value="{{ $examEnrollment->exam_date ? \Carbon\Carbon::parse($examEnrollment->exam_date)->format('Y-m-d') : '' }}"
                                                required {{ $isDisabled }}>
                                            @error('exam_date')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                    {{-- Exam Status --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Exam Status</label>
                                            <select name="status" id="status" class="form-control" {{ $isDisabled }}>
                                                <!-- Default placeholder option -->
                                                <option value="" disabled
                                                    {{ old('status', $examEnrollment->status) == '' ? 'selected' : '' }}>
                                                    Select Status</option>
                                                <!-- Actual status options -->
                                                <option value="pending"
                                                    {{ old('status', $examEnrollment->status) == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="completed"
                                                    {{ old('status', $examEnrollment->status) == 'completed' ? 'selected' : '' }}>
                                                    Completed</option>
                                                <option value="failed"
                                                    {{ old('status', $examEnrollment->status) == 'failed' ? 'selected' : '' }}>
                                                    Failed</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- comments --}}
                                    <div class="col-md-6" id="comments-textarea">
                                        <div class="form-group">
                                            <label for="comments">Comments</label>
                                            <!-- Use the old() function to repopulate the field in case of validation errors -->
                                            <textarea id="comments" name="comments" class="form-control" rows="4">{{ old('comments', $examEnrollment->comments) }}</textarea>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" {{ $examEnrollment->status === 'completed' ? 'disabled' : '' }}
                                    class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.examEnrollments.index') }}" class="btn btn-info">Back</a>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>
    </section>
@endsection
