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
                            @if(getTenantId() ==null)
                                <img
                                    src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'login_left_image')) }}"
                                    alt="{{ getGeneralSettingData(getUserIdByTenant(),'login_left_image') }}">
                            @else
                                <img
                                    src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'login_left_image')) }}"
                                    alt="{{ getGeneralSettingData(getUserIdByTenant(),'login_left_image') }}">
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 signup-right-area">
                    <div class="header-logo">
                        <a href="{{route('frontend')}}">
                            <img src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_logo')) }}"
                                 alt="{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }}">
                        </a>
                    </div>
                    <h2>{{ __("Forget Your Password") }}</h2><br>
                    <h4>{{ __("Don’t have an account?") }}<a href="{{route('register')}}">{{ __("Sign up") }}</a></h4>
                    <div class="signup-from">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="col-md-12 mb-3">
                                @if (session('status'))
                                    <strong class="text-success">{{ session('status') }}</strong>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">{{ __("Email Address")}}<span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control email" id="email" name="email"
                                       value="{{ old("email") }}"
                                       placeholder="{{ __('Enter your email address') }}">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="submit-btu" type="submit"
                                            title="{{ __('Continue') }}">{{ __('Continue') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
