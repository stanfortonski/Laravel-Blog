<div class="col-lg-10">
    <div class="card">
        <div class="card-header">
            <span class="card-title h5">{{ __('Avatar') }}</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('admin.user-panel.image.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <x-input-thumbnail label="Avatar"></x-input-thumbnail>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('Set thumbnail') }}</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <div id="holder">
                        @if(!empty($user->thumbnail_path))
                            <img class="img-fluid my-1" src="{{ $user->thumbnail }}" alt="{{ __('Avatar') }}">
                        @endif

                        @if(!empty($user->thumbnail_path))
                            <form action="{{ route('admin.user-panel.image.destroy', $user->id) }}" method="POST" id="delete-thumbnail-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger" >{{ __('Delete exists thumbnail') }}</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
