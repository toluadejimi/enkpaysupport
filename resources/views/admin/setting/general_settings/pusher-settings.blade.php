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
                                <h2>{{ $pageTitle }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
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
                    <div class="email-inbox__area bg-style">
                        <form class="ajax" action="{{route('admin.setting.settings_env.update')}}" method="post"
                              class="form-horizontal" data-handler="settingCommonHandler">
                            @csrf
                            <div class="item-top mb-30"><h6>{{ __('Google Recaptcha Credentials (V2)') }}</h6></div>
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Google Recaptcha Status') }}</label>
                                <div class="col-lg-9">
                                    <select name="google_recaptcha_status" id="google_recaptcha_status"
                                            class="form-control">
                                        <option value="">--{{ __('Select option') }}--</option>
                                        <option value="1"
                                                @if(getOption('pusher_status') == STATUS_ACTIVE) selected @endif>{{ getStatus(STATUS_ACTIVE) }}</option>
                                        <option value="0"
                                                @if(getOption('pusher_status') != STATUS_ACTIVE) selected @endif>{{ getStatus(STATUS_DISABLE) }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Pusher App Id') }}</label>
                                <div class="col-lg-9">
                                    <input type="text" name="pusher_app_id" id="pusher_app_id"
                                           value="{{getOption('pusher_app_id')}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Pusher App Key') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="pusher_app_key"
                                           id="pusher_app_key"
                                           value="{{getOption('pusher_app_key')}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Pusher App Secret') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="pusher_app_secret"
                                           id="pusher_app_secret"
                                           value="{{getOption('pusher_app_secret')}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Pusher Cluster') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="pusher_cluster"
                                           id="pusher_cluster"
                                           value="{{getOption('pusher_cluster')}}" class="form-control">
                                </div>
                            </div>
                            <div class="justify-content-end row text-end">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-blue float-right">{{__('Update')}}</button>
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
@push('script')
    <script>
        'use strict'
        var google_recaptcha_status = "{{ getOption('google_recaptcha_status') }}"
    </script>
    <script src="{{ asset('admin/js/custom/recaptcha-setting.js') }}"></script>
@endpush

