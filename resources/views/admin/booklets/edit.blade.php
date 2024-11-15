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
                        <li class="breadcrumb-item active">Edit Booklet</li>
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
                            <h3 class="card-title">Edit Booklet <small></small></h3>
                        </div>
                        <form role="form" id="quickForm" method="POST" action="{{ route('admin.booklet.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type='hidden' name='id' value="{{ $booklet->id }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name', $booklet['name']) }}" autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <input id="description" type="text"
                                                class="form-control @error('description') is-invalid @enderror" name="description"
                                                value="{{ old('description', $booklet['description']) }}" autocomplete="description" autofocus>
                                            @error('description')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duration">Duration</label>
                                            <input id="duration" type="number"
                                                class="form-control @error('duration') is-invalid @enderror" name="duration"
                                                value="{{ old('duration', $booklet['duration']) }}" autocomplete="duration" autofocus>
                                            @error('duration')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="level">Level</label>
                                            <select id="level" class="form-control @error('level') is-invalid @enderror" name="level">
                                                <option value="1" {{ old('level', $booklet->level) == 1 ? 'selected' : '' }}>Level 1</option>
                                                <option value="2" {{ old('level', $booklet->level) == 2 ? 'selected' : '' }}>Level 2</option>
                                                <option value="3" {{ old('level', $booklet->level) == 3 ? 'selected' : '' }}>Level 3</option>
                                            </select>
                                            @error('level')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Total Weightage</label>
                                            <input id="total_weightage" type="number"
                                                class="form-control @error('total_weightage') is-invalid @enderror" name="total_weightage"
                                                value="{{ old('total_weightage', $booklet['total_weightage']) }}" autocomplete="total_weightage" autofocus
                                                >
                                            @error('total_weightage')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Status</label><br />
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" name="status" class="form-check-input"
                                                        value="0"
                                                        @if ($booklet->status == 0) checked @endif>Active
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" name="status" class="form-check-input"
                                                        value="1"
                                                        @if ($booklet->status == 1) checked @endif>Deactive
                                                </label>
                                            </div>
                                            @error('status')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.booklets.index') }}" class="btn btn-info">Back</a>

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

