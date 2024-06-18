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
                    <form action="{{ route('password.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-25 sign-up-top-logo">
                            <a href="{{ route('frontend') }}">
                                <span class="logo-lg">
                                                            <img src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_logo')) }}"
                                                                 alt="{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }}">
                                                        </span>
                            </a>
                        </div>
                        <h2>{{ __('Reset Password') }}</h2>
                        <div class="signup-from">
                            <!-- Email -->
                            <div class="form-group">
                                <label for="rEmail">{{ __('Email') }}<span
                                        class="theme-link">*</span></label>
                                <div class="password-login">
                                    <input id="rEmail" type="email" name="email" class="form-control"
                                           value="{{ $email ?? old('email') }}" placeholder="{{ __('Email') }}">
                                </div>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- password -->
                            <div class="form-group">
                                <label for="rPassword">{{ __('Password') }}<span
                                        class="theme-link">*</span></label>
                                <div class="password-login">
                                    <input id="rPassword" class="form-control password"
                                           placeholder="{{ __('Password') }}"
                                           type="password" name="password">
                                    <i id="showPassword" class="fa-solid fa-eye"></i>
                                </div>
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Confirm password -->
                            <div class="form-group">
                                <label for="crPassword">{{ __('Confirm Password') }}
                                    <span class="theme-link">*</span></label>
                                <div class="password-login">
                                    <input id="crPassword" class="mdi-eye-outline password" name="password_confirmation"
                                           placeholder="{{ __('Confirm Password') }}" type="password">
                                    <i id="showPassword2" class="fa-solid fa-eye"></i>
                                </div>
                            </div>
                            <!-- Button -->
                            <button type="submit"
                                    class="submit-btu"
                                    title="{{ __('Reset Password') }}">{{ __('Reset Password') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
