<div class="col-lg-10">
    <div class="card">
        <div class="card-header">
            <span class="card-title h5">{{ __('Change Password') }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.password', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Change') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
