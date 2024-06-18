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
                <div class="col-xxl-2 col-lg-3 col-md-4 pr-0">
                    @include('admin.setting.partials.general-sidebar')
                </div>
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                        <div class="item-top mb-30">
                            <h2>{{ $pageTitle }}</h2>
                        </div>
                        <form class="ajax" action="{{route('admin.setting.application-settings.update')}}" method="POST"
                              enctype="multipart/form-data" data-handler="settingCommonHandler">
                            @csrf
                            <div class="row">
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('App Name')}} <span
                                            class="text-danger">*</span></label>
                                    <div class="">

                                        <input type="text" name="app_name"
                                               value="{{isset($general_setting_data->app_name)?$general_setting_data->app_name:''}}"
                                               class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('App Email')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="app_email"
                                           value="{{isset($general_setting_data->app_email)?$general_setting_data->app_email:''}}"
                                           class="form-control" required>
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('App Contact Number')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="app_contact_number"
                                           value="{{isset($general_setting_data->app_contact_number)?$general_setting_data->app_contact_number:''}}"
                                           class="form-control" required>
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('App Location')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="app_location"
                                           value="{{isset($general_setting_data->app_location)?$general_setting_data->app_location:''}}"
                                           class="form-control" required>
                                </div>

                                @if(auth()->user()->role == USER_ROLE_SUPER_ADMIN)
                                    <div class="col-xxl-4 col-lg-6 mb-3">
                                        <label class="form-label">{{__('App Copyright')}} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="app_copyright"
                                               value="{{isset($general_setting_data->app_copyright)?$general_setting_data->app_copyright:''}}"
                                               class="form-control" required>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6 mb-3">
                                        <label class="form-label">{{__('Developed By')}} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="app_developed"
                                               value="{{isset($general_setting_data->app_developed)?$general_setting_data->app_developed:''}}"
                                               class="form-control" required>
                                    </div>
                                @endif


                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label for="app_timezone" class="form-label">{{__('Timezone')}} <span
                                            class="text-danger">*</span></label>
                                    <select name="app_timezone" class="form-control">
                                        @foreach($timezones as $timezone)
                                            <option
                                                value="{{ $timezone }}" {{isset($general_setting_data->app_timezone) && $timezone == $general_setting_data->app_timezone ? 'selected' : ''}} > {{ $timezone }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if(getOption('ZAIDESKTENANCY_build_version') !=null && getOption('ZAIDESKTENANCY_build_version') > 0)
                                    @if(auth()->user()->role == USER_ROLE_SUPER_ADMIN)
                                        <div class="col-xxl-4 col-lg-6 mb-3">
                                            <label for="APP_DEBUG" class="form-label">{{__('App Debug')}}</label>
                                            <select name="app_debug" class="form-control select2">
                                                <option
                                                    value="true" {{isset($general_setting_data->app_debug) && $general_setting_data->app_debug == true ? 'selected' : ''}} >{{ __('True') }}</option>
                                                <option
                                                    value="false" {{isset($general_setting_data->app_debug) && $general_setting_data->app_debug == false ? 'selected' : ''}} > {{ __('False') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-xxl-4 col-lg-6 mb-3">
                                            <label for="app_date_format"
                                                   class="form-label">{{__('App Date Format')}}</label>
                                            <select name="app_date_format" class="form-control select2">
                                                @foreach(getDateFormatList() as $dateFormat)
                                                    <option
                                                        value="{{ $dateFormat }}" {{isset($general_setting_data->app_date_format) && $general_setting_data->app_date_format = $dateFormat ? 'selected' : ''}} > {{ $dateFormat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xxl-4 col-lg-6 mb-3">
                                            <label for="app_time_format"
                                                   class="form-label">{{__('App Time Format')}}</label>
                                            <select name="app_time_format" class="form-control select2">
                                                @foreach(getTimeList() as $timeFormat)
                                                    <option
                                                        value="{{ $timeFormat }}" {{isset($general_setting_data->app_time_format) && $general_setting_data->app_time_format == $timeFormat ? 'selected' : ''}} > {{ $timeFormat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                @endif
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
@endpush
