<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <span class="card-title h5">{{ __('Change Account Data') }}</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.user-panel.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-2 text-right">
                        <x-choose-lang-admin />
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label for="first_name">{{ __('First Name') }}*</label>
                                <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ $user->first_name }}" required>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="last_name">{{ __('Last Name') }}*</label>
                                <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ $user->last_name }}" required>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('E-Mail Address') }}*</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="website">{{ __('website') }}</label>
                        <input type="text" id="website" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ $user->website }}">
                        @error('website')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">{{ __('content') }}</label>
                        <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror">{{ $content->content ?? '' }}</textarea>
                        @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ __('Change') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
