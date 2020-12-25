@if(session()->has('success'))
    <div class="row">
        <div class="col">
            <div class="alert alert-success">
                {{ __(session('success')) }}
                <button type="button" class="close" data-dismiss="alert" aria-label="{{__('Close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
@elseif(session()->has('error'))
    <div class="row">
        <div class="col">
            <div class="alert alert-danger">
                {{ __(session('error')) }}
                <button type="button" class="close" data-dismiss="alert" aria-label="{{__('Close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
@endif
