@extends('auth.layouts.app')
@push('title')
    {{ __('Login') }}
@endpush
@push('style')
@endpush
@section('content')
    <!-- signup area start -->
    <div class="register-area">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-6 order-last order-lg-first">
                    <div class="register-left-area">

                        @if(getTenantId() ==null)
                            <div class="register-left-wrap signup-left-area">
                                <div class="signup-login">
                                    <a href="{{route('frontend')}}">

                                        <a href=""><img src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_footer_logo')) }}"
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

                                        <a href="{{route('frontend')}}"><img
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
                        <h2>{{__('Sign in')}}</h2>
                        <p class="have-account">{{ __('Create new account') }}? <a
                                href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                        </p>


                        <div class="signup-from">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <p class="m-0 msg"> {{ session('error') }}</p>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">{{ __('Your Email') }} <span>*</span></label>
                                    <input type="email" id="email" placeholder="example@gmail.com" name="email"
                                           class="email"
                                           required="">
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('Your Password') }} <span>*</span></label>
                                    <div class="password-login">
                                        <input type="password" id="password" class="mdi-eye-outline password"
                                               placeholder="*********" required="" name="password">
                                        <i id="showPassword" class="fa-solid fa-eye"></i>
                                    </div>
                                </div>
                                <div class="remember-area">
                                    <div class="remember-text">
                                        <div class="form-check">
                                            <input type="checkbox" name="remember" class="form-check-input"
                                                   id="Remember">
                                            <label class="form-check-label"
                                                   for="Remember">{{ __('Remember me') }}</label>
                                        </div>
                                    </div>
                                    <a href="{{ route('password.request') }}"
                                       class="forgot-password">{{ __("Forgot password?") }}</a>
                                </div>

                                @if(getOption('google_recaptcha_status') == 1)
                                    <div class="g-recaptcha mb-5" id="feedback-recaptcha"
                                         data-sitekey="{{ getOption('google_recaptcha_site_key') }}">
                                    </div>
                                @endif

                                <button class="submit-btu" type="submit">{{ __('submit now') }}</button>
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
                                            alt="{{ __('google') }}">
                                        {{ __('Sign in with Google') }} </a>
                                @endif
                                @if (getOption('facebook_login_status') == 1)
                                    <a href="{{ url('auth/facebook') }}" class="social-media-btn"> <img
                                            src="{{ asset('frontend/assets/images/facebooklogin.png') }}"
                                            alt="{{ __('facebook') }}">
                                        {{ __('Sign in with Facebook') }} </a>
                                @endif
                            </div>

                        @endif


                        @if (env('LOGIN_HELP') == 'active')
                            <div class="row">
                                <div class="col-md-12 mb-25">
                                    <div class="table-responsive login-info-table mt-3">
                                        <table class="table table-bordered">
                                            <tbody>
                                            @if(isAddonInstalled('DESKSAAS') > 0)
                                                    @if(getHostFromURL(env('APP_URL')) == request()->getHost())
                                                        <tr>
                                                            <td colspan="2" id="adminCredentialShow"
                                                                class="fs-4 login-info p-3">
                                                                <b>Super Admin :</b> sadmin@gmail.com | 123456
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" id="userCredentialShow"
                                                                class="fs-4 login-info p-3">
                                                                <b>Admin :</b> admin@gmail.com | 123456
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="2" id="agentCredentialShow"
                                                                class="fs-4 login-info p-3">
                                                                <b>Agent :</b> agent@gmail.com | 123456
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" id="customerCredentialShow"
                                                                class="fs-4 login-info p-3">
                                                                <b>Customer :</b> customer@gmail.com | 123456
                                                            </td>
                                                        </tr>
                                                    @endif
                                            @else
                                                <tr>
                                                    <td colspan="2" id="userCredentialShow"
                                                        class="fs-4 login-info p-3">
                                                        <b>Admin :</b> admin@gmail.com | 123456
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" id="agentCredentialShow"
                                                        class="fs-4 login-info p-3">
                                                        <b>Agent :</b> agent@gmail.com | 123456
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" id="customerCredentialShow"
                                                        class="fs-4 login-info p-3">
                                                        <b>Customer :</b> customer@gmail.com | 123456
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- signup area end -->

@endsection

@push('script')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('assets/js/custom/auth.js') }}"></script>
@endpush
