<form method="GET" role="search">
    <div class="form-group">
        <div class="input-group">
            <input type="search" name="q" autocomplete="off" class="form-control" placeholder="{{ __($placeholder) }}" aria-label="{{ __($placeholder) }}" value="{{ $q }}">
            <div class="input-group-append">
                <input type="submit" value="{{ __($placeholder) }}" class="btn btn-sm btn-primary">
            </div>
        </div>
    </div>
</form>
