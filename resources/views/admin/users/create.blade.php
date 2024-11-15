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
                        <li class="breadcrumb-item active">Add User</li>
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
                            <h3 class="card-title">Add User <small></small></h3>
                        </div>
                        <form role="form" id="quickForm" method="POST" action="{{ route('admin.users.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">User Name</label>
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                value="{{ old('username') }}" autocomplete="username" autofocus>
                                            @error('username')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input id="first_name" type="text"
                                                class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                                value="{{ old('first_name') }}" autocomplete="first_name" autofocus>
                                            @error('first_name')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input id="last_name" type="text"
                                                class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                                value="{{ old('last_name') }}" autocomplete="last_name" autofocus>
                                            @error('last_name')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Email</label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="input-group">
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <a href="#" class="toggle_hide_password">
                                                            <i class="fas fa-eye-slash" aria-hidden="true"></i>
                                                        </a>
                                                    </span>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-secondary"
                                                            id="generatePassword">Generate</button>
                                                    </div>
                                                    @error('password')
                                                        <span class="error invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <div class="input-group">
                                                <input id="password-confirm" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password_confirmation" autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <a href="#" class="toggle_hide_password">
                                                            <i class="fas fa-eye-slash" aria-hidden="true"></i>
                                                        </a>
                                                    </span>
                                                    @error('password_confirmation')
                                                        <span class="error invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <button class="btn btn-secondary" id="copyPassword" type="button"
                                                    style="display: none;">
                                                    <i class="fa fa-copy"></i>
                                                </button>
                                                <div id="copyStatus" style="display: none; margin-top: 5px; color: green;">
                                                    Copied!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">User Type</label>
                                            <select id="role" class="form-control @error('role') is-invalid @enderror"
                                                name="role">
                                                <option value='' selected>Select</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role') == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
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
                                                        value="0" {{ old('status') == 0 ? 'checked' : '' }}>Active
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" name="status" class="form-check-input"
                                                        value="1" {{ old('status') == 1 ? 'checked' : '' }}>Deactive
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
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="/admin/users"><button type="button" class="btn btn-info">Back</button></a>
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
    <script src="{{ asset('js/admin/users/password-show.js') }}"></script>
    <script src="{{ asset('js/admin/users/file.js') }}"></script>
    <script src="{{ asset('js/admin/users/password-generate.js') }}"></script>
@endsection
