<form method="GET" role="search">
    <div class="form-group">
        <div class="input-group">
            <input type="search" name="q" autocomplete="off" class="form-control" placeholder="{{ $placeholder }}" value="{{ $q }}">
            <div class="input-group-append">
                <input type="submit" value="Wyszukaj" class="btn btn-sm btn-primary">
            </div>
        </div>
    </div>
</form>
