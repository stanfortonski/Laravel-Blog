@if(!empty($label))
    <label for="{{ $name }}">{{ __($label) }}</label>
@endif
<div class="input-group">
    @foreach($options as $key => $val)
        @php $find = false; @endphp
        @if(is_array($value))
            @foreach($value as $checked)
                @if($checked == $key)
                    @php $find = true; @endphp
                @endif
            @endforeach
        @endif
        <div class="custom-control custom-checkbox d-inline m-1">
            <input type="checkbox" class="custom-control-input" id="{{ $name.'_'.$key }}" name="{{ $name }}[]" value="{{ $key }}" @if($find) checked @endif>
            <label class="custom-control-label" for="{{ $name.'_'.$key }}">{{ $val }}</label>
        </div>
    @endforeach
    @error($name)
        <small class="text-danger form-text">{{ $message }}</small>
    @enderror
</div>
