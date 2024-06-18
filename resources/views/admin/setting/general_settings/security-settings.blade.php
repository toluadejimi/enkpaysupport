@extends('admin.layouts.app')
@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{__(@$pageTitle)}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item"><a href="#">{{__('General Settings ')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-2 col-lg-3 col-md-4 mb-3 pr-0">
                    @include('admin.setting.partials.general-sidebar')
                </div>
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-top mb-30">
                            <h2>{{__('Security Setting')}}</h2>
                        </div>
                        <form class="ajax" action="{{ route('admin.setting.common.settings.update') }}" method="post"
                              class="form-horizontal" data-handler="commonResponse">
                            @csrf
                            <div class="row">
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label
                                        class="label-text-title color-heading font-medium mb-2">{{ __('Email Verification') }}</label>
                                    <select name="email_verification_status"
                                            class="form-control flex-shrink-0">
                                        <option value="1"
                                            {{ getOption('email_verification_status', 0) == 1 ? 'selected' : '' }}>
                                            {{ __('Active') }}</option>
                                        <option value="0"
                                            {{ getOption('email_verification_status', 0) != 1 ? 'selected' : '' }}>
                                            {{ __('Deactivate') }}</option>
                                    </select>
                                </div>
                                <small>{{ __('If you enable Email Verification, new user have to verify the email to access this system.') }}</small>
                            </div>
                            <hr>
                            <div class="item-top mb-30">
                                <h2>{{__('Two Factor Method (enable / disable)')}}</h2>
                            </div>
                            <div class="row">
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label>{{__('Email ')}} </label>
                                    <div class="input-group">
                                        <select name="two_factor_email_status" id="" class="form-control">
                                            <option
                                                value="1" {{ getOption('two_factor_email_status') == 1 ? 'selected':'' }}>{{ __('Yes') }}</option>
                                            <option
                                                value="0" {{ getOption('two_factor_email_status') != 1 ? 'selected':'' }}>{{ __('No') }}</option>
                                        </select>
                                        @if ($errors->has('two_factor_email_status'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('two_factor_email_status') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label>{{__('Google Auth')}} </label>
                                    <div class="input-group">
                                        <select name="two_factor_googleauth_status" id="" class="form-control">
                                            <option
                                                value="1" {{ getOption('two_factor_googleauth_status') == 1 ? 'selected':'' }}>{{ __('Yes') }}</option>
                                            <option
                                                value="0" {{ getOption('two_factor_googleauth_status') != 1 ? 'selected':'' }}>{{ __('No') }}</option>
                                        </select>
                                        @if ($errors->has('two_factor_googleauth_status'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('two_factor_googleauth_status') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label>{{__('Phone Number')}} </label>
                                    <div class="input-group">
                                        <select name="two_factor_phone_status" id="" class="form-control">
                                            <option
                                                value="1" {{ getOption('two_factor_phone_status') == 1 ? 'selected':'' }}>{{ __('Yes') }}</option>
                                            <option
                                                value="0" {{ getOption('two_factor_phone_status') != 1 ? 'selected':'' }}>{{ __('No') }}</option>
                                        </select>
                                        @if ($errors->has('two_factor_phone_status'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('two_factor_phone_status') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    <button class="btn btn-blue" type="submit">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Page content area end -->
@endsection
@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/libs/datatable/datatables.min.css')}}"/>
@endpush
@push('script')
    <script src="{{asset('admin/libs/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
@endpush
