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
                    <div class="email-inbox__area bg-style">
                        <div class="item-top mb-30"><h2>{{ $pageTitle }}</h2></div>
                        <div class="bg-dark-primary-soft-varient p-4 border-1">
                            <h2>{{ __('Instructions') }}: </h2>
                            <p>{{ __("You need to follow some instruction after maintenance mode changes. Instruction list given below-") }}</p>
                            <div class="text-black">
                                <li>{{ __("If you select maintenance mode") }} <b>{{ __("Maintenance O") }}n</b>,
                                    {{__("you need to input secret key for maintenance work. Otherwise you can't work this website. And your created secret key helps you to work under
                                    maintenance.")}}
                                </li>
                                <li>{{ __("After created maintenance key, you can use this website secretly through this ur") }}
                                    l <span class="iconify"
                                            data-icon="arcticons:url-forwarder"></span> <span
                                        class="text-primary">{{ url('/') }}/(Your created secret key)</span></li>
                                <li>{{__("Only one time url is browsing with secret key, and you can browse your site in maintenance mode. When maintenance mode on, any user can see
                                    maintenance mode error message.")}}
                                </li>
                                <li>{{ __("Unfortunately you forget your secret key and try to connect with your website.") }}
                                    <br> {{ __("Then you go to your project folder location") }}
                                    <b>{{ __("Main Files") }}</b>{{ __("(where your file in cpanel or your hosting)") }}
                                    <span class="iconify"
                                          data-icon="arcticons:url-forwarder"></span><b>{{ __("storage") }}</b>
                                    <span class="iconify"
                                          data-icon="arcticons:url-forwarder"></span><b>{{ __("framework") }}</b>. {{ __("You can see 2 files and need to delete 2 files. Files are:") }}
                                    <br>
                                    {{ __("1. down") }} <br>
                                    {{ __("2. maintenance.php") }}
                                </li>
                            </div>
                        </div>
                        <br>
                        <form class="ajax" action="{{route('admin.setting.maintenance.change')}}" method="POST"
                              enctype="multipart/form-data" data-handler="settingCommonHandler">
                            @csrf
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Maintenance Mode') }} <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="maintenance_mode" id="" class="form-control maintenance_mode">
                                        <option value="">--{{ __('Select Option') }}--</option>
                                        <option value="1"
                                                @if(getOption('maintenance_mode') == 1) selected @endif>{{ __('Maintenance On') }}</option>
                                        <option value="2"
                                                @if(getOption('maintenance_mode') != 1) selected @endif>{{ __('Live') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Maintenance Mode Secret Key') }}</label>
                                <div class="col-lg-9">
                                    <input type="text" name="maintenance_secret_key"
                                           value="{{ getOption('maintenance_secret_key') }}" minlength="6"
                                           class="form-control maintenance_secret_key">
                                </div>
                            </div>

                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Maintenance Mode Url') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="" value="" class="form-control maintenance_mode_url"
                                           disabled>
                                </div>
                            </div>

                            <div class="justify-content-end row text-end">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-blue float-right">{{ __('Update') }}</button>
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
        let getUrl = "{{ url('') }}";
        const maintenanceSecretKey = "{{ getOption('maintenance_secret_key') }}";
        const maintenanceModeConst = "{{ getOption('maintenance_mode') }}";
    </script>
    <script src="{{ asset('admin/js/custom/maintenance-mode.js') }}"></script>
@endpush
