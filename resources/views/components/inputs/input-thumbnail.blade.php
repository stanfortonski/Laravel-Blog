<label for="thumbnail">{{ __($label) }}</label>
<div class="custom-file">
    <input type="file" id="thumbnail" id="name" class="custom-file-input form-control @error('thumbnail') is-invalid @enderror" lang="{{ app()->getLocale() }}" accept="image/x-png,image/gif,image/jpeg,image/webp">
    <label for="thumbnail" class="custom-file-label">{{ __('Choose file') }}</label>
</div>
@error('thumbnail')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
