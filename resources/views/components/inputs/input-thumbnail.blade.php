<label for="thumbnail">{{ __($label) }}</label><div class="input-group">
    <span class="input-group-btn">
      <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-secondary">
        <i class="fas fa-image mr-2"></i> {{ __('Choose') }}
      </a>
    </span>
    <input id="thumbnail" class="form-control" type="text" name="thumbnail_path">
</div>
@error('thumbnail_path')
    <small class="text-danger">{{ $message }}</small>
@enderror
