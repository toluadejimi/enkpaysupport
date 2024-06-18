@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote-lite.min.css') }}"/>
@endpush

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
                    @include('admin.setting.partials.frontend-sidebar')
                </div>
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                        <div class="item-top mb-30">
                            <h2>{{ $pageTitle }}</h2>
                        </div>
                        <form class="ajax" action="{{route('admin.setting.application-settings.store')}}" method="POST"
                              enctype="multipart/form-data" data-handler="settingCommonHandler">

                            @csrf
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label class="form-label">{{__('Auth Page Title')}} </label>
                                    <textarea name="auth_page_title" class="summernote"
                                              placeholder="{{ __("Auth Page Title") }}">{{ isset($settings_data->auth_page_title) ? $settings_data->auth_page_title : '' }} </textarea>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label">{{__('Auth Page Subtitle')}} </label>
                                    <textarea name="auth_page_sub_title" class="summernote"
                                              placeholder="{{ __("Auth Page Subtitle") }}">{{ isset($settings_data->auth_page_sub_title) ? $settings_data->auth_page_sub_title : '' }}</textarea>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label">{{ __('Footer Left Text') }} </label>
                                    <textarea name="app_footer_text" class="summernote"
                                              placeholder="{{ __("Footer Left Text") }}">{{ isset($settings_data->app_footer_text) ? $settings_data->app_footer_text : '' }}</textarea>
                                </div>
                            </div>
                            <hr>
                            <div class="item-top mb-30">
                                <h2>{{__('Social Media Profile Link (Footer)')}}</h2>
                            </div>
                            <div class="row">
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('Facebook URL')}} </label>
                                    <input type="text" name="facebook_url"
                                           value="{{ isset($settings_data->facebook_url) ? $settings_data->facebook_url : '' }}"
                                           class="form-control">
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('Instagram URL')}} </label>
                                    <input type="text" name="instagram_url"
                                           value="{{ isset($settings_data->instagram_url) ? $settings_data->instagram_url : '' }}"
                                           class="form-control">
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('LinkedIn URL')}}</label>
                                    <input type="text" name="linkedin_url"
                                           value="{{ isset($settings_data->linkedin_url) ? $settings_data->linkedin_url : '' }}"
                                           class="form-control">
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('Twitter URL')}}</label>
                                    <input type="text" name="twitter_url"
                                           value="{{ isset($settings_data->twitter_url) ? $settings_data->twitter_url : '' }}"
                                           class="form-control">
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label
                                        class="label-text-title color-heading font-medium mb-2">{{ __('Skype Url') }}</label>
                                    <input type="text" class="form-control"
                                           name="skype_url"
                                           value="{{ isset($settings_data->skype_url) ? $settings_data->skype_url : '' }}"
                                           placeholder="{{ __('Skype') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input__group general-settings-btn">
                                        <button type="submit" class="btn btn-blue float-right">{{__('Update')}}</button>
                                    </div>
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
    <script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom/summernote-init.js') }}"></script>
    @endpush
