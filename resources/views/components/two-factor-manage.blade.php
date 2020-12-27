@if (auth()->user()->two_factor_secret)
    <div class="mb-4">
        {{ __('Two factor authentication has been enabled.') }}
    </div>
    <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">{{ __('Disable') }}</button>
    </form>

    @if(session('status') == 'two-factor-authentication-enabled')
        <p>{{ __('Please copy the following QR code int your phones authenticatior application.') }}</p>
        {!! auth()->user()->twoFactorQrCodeSvg() !!}
    @endif
@else
    <div class="mb-4">
        {{ __('Two factor authentication is disabled.') }}
    </div>
    <form method="POST" action="{{url('/user/two-factor-authentication')}}">
        @csrf
        <button type="submit" class="btn btn-success">{{ __('Enable') }}</button>
    </form>
@endif
