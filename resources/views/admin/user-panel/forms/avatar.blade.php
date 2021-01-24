<div class="col-lg-10">
    <div class="card">
        <div class="card-header">
            <span class="card-title h5">{{ __('Avatar') }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user-panel.image.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <div class="form-row">
                        <div class="col-8">
                            <x-input-thumbnail label="Avatar"></x-input-thumbnail>
                        </div>
                        @if(!empty($user->thumbnail_path))
                            <div class="col-4">
                                <span>{{ __('Current') }}</span>
                                <img class="img-fluid my-1" src="{{ $user->thumbnail }}" alt="{{ __('Avatar') }}">
                                <button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-thumbnail-form').submit();">{{ __('Delete exists thumbnail') }}</button>
                            </div>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Upload new thumbnail') }}</button>
            </form>

            @if(!empty($user->thumbnail_path))
                <form action="{{ route('admin.user-panel.image.destroy', $user->id) }}" method="POST" id="delete-thumbnail-form">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
</div>
