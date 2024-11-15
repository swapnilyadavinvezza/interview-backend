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
                        <li class="breadcrumb-item active">Edit User</li>
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
                            <h3 class="card-title">Edit User <small></small></h3>
                        </div>
                        <form role="form" id="quickForm" method="POST" action="{{ route('admin.user.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type='hidden' name='id' value="{{ $user->id }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">User Name</label>
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                value="{{ old('username', $user['username']) }}" autocomplete="username" autofocus>
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
                                                value="{{ old('first_name', $user['first_name']) }}" autocomplete="first_name" autofocus>
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
                                                value="{{ old('last_name', $user['last_name']) }}" autocomplete="last_name" autofocus>
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
                                                value="{{ old('email', $user['email']) }}" autocomplete="email" autofocus
                                                readonly>
                                            @error('email')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{--  <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Mobile</label>
                                            <input id="mobile" type="number"
                                                class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                                value="{{ old('mobile', $user['mobile']) }}" autocomplete="email" autofocus>
                                            @error('mobile')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>  --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Profile Picture
                                                @if (!empty($user->profile_photo_url))
                                                    <a href="{{ $user->profile_photo_url }}">| Download</a>
                                                @endif
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" name="profile_photo"
                                                    class="custom-file-input @error('profile_photo') is-invalid @enderror"
                                                    id="profile_photo" onchange="updateFileName()">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            @error('profile_photo')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{--  <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Password</label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                autocomplete="new-password">
                                            @error('password')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Confirm Password</label>
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" autocomplete="new-password">
                                            @error('password_confirmation')
                                                <span class="error invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>  --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for "name">Role</label>
                                            <select id="role" class="form-control @error('role') is-invalid @enderror"
                                                name="role">
                                                <option value='' selected>Select</option>

                                                @foreach ($roles as $roleId => $role)
                                                    <option value="{{ $roleId }}"
                                                        {{ old('role', $old_role->id) == $roleId ? 'selected' : '' }}>
                                                        {{ $role }}
                                                    </option>
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
                                                        value="0"
                                                        @if ($user->status == 0) checked @endif>Active
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" name="status" class="form-check-input"
                                                        value="1"
                                                        @if ($user->status == 1) checked @endif>Deactive
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
                                <a href="{{ route('admin.users.index') }}" class="btn btn-info">Back</a>

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
<script>
    function updateFileName() {
        const fileInput = document.getElementById('profile_photo');
        const customFileLabel = document.querySelector('.custom-file-label');
        if (fileInput.files.length > 0) {
            customFileLabel.textContent = fileInput.files[0].name;
        } else {
            customFileLabel.textContent = 'Choose file';
        }
    }
</script>
