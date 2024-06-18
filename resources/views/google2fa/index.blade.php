@extends('auth.layouts.app')
@push('title')
{{ __('Welcome') }}
@endpush
@push('style')
@endpush
@section('content')
<div class="register-area">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-6 order-last order-lg-first">
                <div class="register-left-area">
                    <div class="register-left-wrap">
                        <div class="register-left-top">
                            <a class="brand-logo" href="{{route('frontend')}}"> <img
                                    src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}"></a>
                            <h2>{{ getOption('sign_up_left_text_title') }}</h2>
                            <p>{{ getOption('sign_up_left_text_subtitle') }}</p>
                        </div>
                        <img src="{{ getSettingImage('login_left_image') }}" alt="register">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 align-self-center order-first order-lg-last">
                <div class="register-right-area">
                    <div class="register-wrap">
                        <div class="sign-up-right-content radius-10 bg-white">
                            <form action="{{ route('google2fa.authenticate.verify.action') }}" method="post">
                                @csrf
                                <div class="register-right-top">
                                    <h2>{{ __("2FA Authentication") }}</h2>
                                </div>
                                @if (session('error'))
                                <div class="alert alert-danger">
                                    <p class="msg"> {{ session('error') }}</p>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label for="google2fa_code">{{__("Enter Google Authenticator Code")}}</label>
                                    <input id="one_time_password" type="number" class="form-control"
                                        name="one_time_password" placeholder="{{__("Enter the Code to verify")}}"
                                        aria-invalid="false">
                                </div>
                                <div class="d-block mt-3 text-end">
                                    <button type="submit" class="btn secondary-btn sm-btn submit-btn">{{ __("Confirm") }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('admin') }}/js/custom/password-show.js"></script>
<script src="{{ asset('assets/js/custom/google2fa_page.js') }}"></script>
@endpush
