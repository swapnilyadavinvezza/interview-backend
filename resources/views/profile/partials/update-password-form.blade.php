<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('admin.user.changePasswordUpdate') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Current Password</label>
                        <div class="input-group">
                            <input id="password-current" type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                name="current_password" autocomplete="current_password">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <a href="#" class="toggle_hide_password">
                                        <i class="fas fa-eye-slash" aria-hidden="true"></i>
                                    </a>
                                </span>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary"
                                        id="generatePassword">Generate</button>
                                </div>
                                @error('current_password')
                                    <span class="error invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>New Password</label>
                        <div class="input-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="new-password">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <a href="#" class="toggle_hide_password">
                                        <i class="fas fa-eye-slash" aria-hidden="true"></i>
                                    </a>
                                </span>

                                @error('password')
                                    <span class="error invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="input-group">
                            <input id="password-confirm" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" autocomplete="password_confirmation">
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
                        </div>
                    </div>
                </div>
                {{--  <div>
            <x-input-label for="current_password" :value="__('Current Password')" />
            <x-text-input id="current_password" name="current_password" type="password" class="form-control"
                autocomplete="current-password" />
            <div class="input-group-append">

                <span class="input-group-text">
                    <a href="#" class="toggle_hide_password">
                        <i class="fas fa-eye-slash" aria-hidden="true"></i>
                    </a>
                </span>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" autocomplete="new-password">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <a href="#" class="toggle_hide_password">
                                <i class="fas fa-eye-slash" aria-hidden="true"></i>
                            </a>
                        </span>

                        @error('password')
                            <span class="error invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>  --}}
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                    @endif
                </div>

            </div>
        </div>
    </form>
</section>
@section('pagejs')
    <script src="{{ asset('js/admin/users/password-show.js') }}"></script>
        <script src="{{ asset('js/admin/users/password-generate.js') }}"></script>

@endsection
