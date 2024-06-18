@extends('auth.layouts.app')

@push('title')
{{ __('Verify') }}
@endpush

@section('content')
<div class="signLog-section">
    <div class="signLog-section-wrap">
        <div class="left" data-background="{{ asset('assets/images/auth-img-bg.png') }}" data-aos="fade-left"
            data-aos-duration="1000">
            <div class="wrap">
                <div class="zMain-signLog-content">
                    <div class="pb-30">
                        <h4 class="title">{{ __('Verify Your Account') }}</h4>
                        <p class="info">{{ __('Enter 4 digit code to') }}
                            <span>{{ $user->email }}</span>
                        </p>
                    </div>
                    <form action="{{ route('email.verified', $token) }}" method="POST" class="otp-form" name="otp-form">
                        @csrf
                        <div class="otp-input-fields" id="otp-block">
                            <input type="text" name="otp__field__1" id="otp__field__1" maxlength="1" required
                                   class="otp__digit otp__field__1" />
                            <input type="text" name="otp__field__2" id="otp__field__2" maxlength="1" required
                                   class="otp__digit otp__field__2" />
                            <input type="text" name="otp__field__3" id="otp__field__3" maxlength="1" required
                                   class="otp__digit otp__field__3" />
                            <input type="text" name="otp__field__4" id="otp__field__4" maxlength="1" required
                                   class="otp__digit otp__field__4" />
                        </div>
                        <p class="otp-time">{{ __('Send the code again after') }} <span
                                id="send-after-timer"></span></p>
                        <div class="d-none" id="resent-div">
                            <button type="button"
                                    onclick="event.preventDefault(); document.getElementById('resent-form').submit();"
                                    class="align-items-center bd-ra-12 border-0 d-flex fs-15 fw-500 hover-bg-one justify-content-center lh-20 bg-cdef84  mb-18 mt-30 p-2 pt-10 text-1b1c17 w-100 w-full"
                                    title="{{ __('Click here to request another') }}">{{ __('Click here to request another')
                            }}</button>
                        </div>
                        <button id="verify-btn" type="submit"
                                class="verify-btn">{{
                        __('Verify') }}</button>
                    </form>
                    <form method="POST" action="{{ route('email.verify.resend', $token) }}" class="d-none" id="resent-form">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
{{--        <div class="right" data-background="{{ getSettingImage('login_left_image') }}" data-aos="fade-right"--}}
{{--            data-aos-duration="1000">--}}
{{--            <div class="content">--}}
{{--                <h4 class="title">--}}
{{--                    {{ getOption('auth_page_title') }}<br />--}}
{{--                    <span>{{ getOption('app_name') }}</span>.--}}
{{--                </h4>--}}
{{--                <p class="info">{{ getOption('auth_page_description') }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</div>
@endsection

@push('script')
    <script>
        // Set the date we're counting down to
        var countDownDate = new Date('{{ $user->otp_expiry }}').getTime();
        var currentTime = new Date('{{ now() }}');
        var oldTime = 0;
    </script>
    <script src="{{ asset('assets/js/custom/verify_timer.js') }}"></script>
@endpush
