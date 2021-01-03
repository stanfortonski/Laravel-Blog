@if (auth()->user()->two_factor_secret)
    <div class="mb-3">
        {{ __('Two factor authentication has been enabled.') }}
    </div>
    <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">{{ __('Disable') }}</button>
    </form>

    @if(session('status') == 'two-factor-authentication-enabled')
        <div class="row mt-3">
            <div class="col-lg-6">
                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                <p class="text-muted mt-3">{{ __('Please copy the following QR code into your phones authenticatior application.') }}</p>
            </div>

            <div class="col-lg-6">
                @php $codes = json_decode(decrypt(auth()->user()->two_factor_recovery_codes)); @endphp
                <h5>{{ __('Recovery Codes') }}:</h5>
                <ol>
                    @foreach($codes as $code)
                        <li>{{ $code }}</li>
                    @endforeach
                </ol>
                <p class="text-muted">{{ __('Please save your recovery codes.') }}</p>
            </div>
        </div>
    @endif
@else
    <div class="mb-3">
        {{ __('Two factor authentication is disabled.') }}
    </div>
    <form method="POST" action="{{url('/user/two-factor-authentication')}}">
        @csrf
        <button type="submit" class="btn btn-success">{{ __('Enable') }}</button>
    </form>
@endif
