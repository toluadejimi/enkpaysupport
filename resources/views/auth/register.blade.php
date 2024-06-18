@extends('auth.layouts.app')
@push('title')
    {{ __('Login') }}
@endpush
@push('style')
@endpush
@section('content')
    <div class="register-area">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-6 order-last order-lg-first">
                    <div class="register-left-area">
                        @if(getTenantId() == null)
                            <div class="register-left-wrap signup-left-area">
                                <div class="signup-login">
                                    <a href="{{route('frontend')}}">
                                        <a href="{{route('frontend')}}"><img
                                                src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_footer_logo')) }}"
                                                alt="{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }}"></a>
                                    </a>
                                </div>
                                <h2>{{strip_tags(getCmsSetting(1,'auth_page_title')) }}</h2>
                                <p>{{strip_tags(getCmsSetting(1,'auth_page_sub_title')) }}</p>

                                <div class="signup-cover-img">
                                    <img
                                        src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'login_left_image')) }}"
                                        alt="{{ getGeneralSettingData(getUserIdByTenant(),'login_left_image') }}">
                                </div>
                            </div>
                        @else
                            <div class="register-left-wrap signup-left-area">
                                <div class="signup-login">
                                    <a href="{{route('frontend')}}">

                                        <a href=""><img
                                                src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_footer_logo')) }}"
                                                alt="{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }}"></a>
                                    </a>
                                </div>
                                <h2>{{strip_tags(getCmsSetting(getUserIdByTenant(),'auth_page_title')) }}</h2>
                                <p>{{strip_tags(getCmsSetting(getUserIdByTenant(),'auth_page_sub_title')) }}</p>

                                <div class="signup-cover-img">
                                    <img
                                        src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'login_left_image')) }}"
                                        alt="{{ getGeneralSettingData(getUserIdByTenant(),'login_left_image') }}">
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
                <div class="col-lg-6 align-self-center order-first order-lg-last">
                    <div class="signup-right-area">
                        <h2>{{__('Sign up')}}</h2>
                        <p class="have-account">{{ __('Already have an account?') }} <a
                                href="{{ route('login') }}">{{ __('Sign in') }}</a></p>

                        <div class="signup-from">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <p class="m-0 msg"> {{ session('error') }}</p>
                                </div>
                            @endif
                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="YourName">{{ __('Your Name') }} <span>*</span></label>
                                    <input type="text" id="YourName" placeholder="{{ __('Your Name') }}" required=""
                                           name="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('Your Email') }} <span>*</span></label>
                                    <input type="email" id="email" placeholder="{{ __('Email') }}" required=""
                                           name="email">
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('Your Password') }} <span>*</span></label>
                                    <div class="password-login">
                                        <input type="password" class="mdi-eye-outline" id="password"
                                               placeholder="*********" required=""
                                               name="password">
                                        <i id="showPassword" class="fa-solid fa-eye"></i>
                                    </div>

                                </div>
                                <div class="form-group conditions">
                                    <input type="checkbox" name="terms_and_condition" id="iAgreeToTermsAndConditions">
                                    <label for="iAgreeToTermsAndConditions">{{ __('I agree to the all') }} <a
                                            href="{{ route('terms.of.use.index') }}" target="__blank"
                                            class="text-decoration-underline mx-1"
                                            title="{{ __('Click to Terms & Conditions') }}">{{ __('Terms & Conditions') }}</a>
                                    </label>
                                </div>
                                @if(getOption('google_recaptcha_status') == 1)
                                    <div class="g-recaptcha mb-5" id="feedback-recaptcha"
                                         data-sitekey="{{ getOption('google_recaptcha_site_key') }}">
                                    </div>
                                @endif
                                <button class="submit-btu" type="submit">{{ __('Sign Up') }}</button>
                            </form>
                        </div>
                        @if (getOption('google_login_status') == 1 || getOption('facebook_login_status') == 1)
                            <div class="signup-border">
                                <p>{{ __('Or continue with') }}</p>
                            </div>
                            <div class="social-signup-area">
                                @if (getOption('google_login_status') == 1)
                                    <a href="{{ url('auth/google') }}" class="social-media-btn"> <img
                                            src="{{ asset('frontend/assets/images/googlelogin.png') }}"
                                            alt="{{ __('google') }}"> {{ __('Sign in with Google') }} </a>
                                @endif
                                @if (getOption('facebook_login_status') == 1)
                                    <a href="{{ url('auth/facebook') }}" class="social-media-btn"> <img
                                            src="{{ asset('frontend/assets/images/facebooklogin.png') }}"
                                            alt="{{ __('facebook') }}"> {{ __('Sign in with Facebook') }} </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('assets/js/custom/auth.js') }}"></script>
@endpush
