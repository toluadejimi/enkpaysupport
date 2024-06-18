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
                        <form class="ajax" action="{{route('admin.setting.color-settings.update')}}" method="POST"
                              enctype="multipart/form-data" data-handler="settingCommonHandler">
                            @csrf

                            <div class="item-top mb-30">
                                <h2>{{__('Site Logos')}}</h2>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">{{__('App Preloader')}}</label>
                                    <div class="upload-img-box">
                                        <img
                                            src="{{ getFileUrl(getGeneralSettingData(auth()->id(),'app_preloader')) }}">
                                        <input type="file" name="app_preloader" id="app_preloader" accept="image/*"
                                               onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{
                                    $errors->first('app_logo')
                                    }}</span>
                                    @endif
                                    <p><span class="text-black"><span
                                                class="text-black">{{__('Recommend Size')}}:</span> 140 x 40</span></p>
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label">{{__('App Logo')}}</label>
                                    <div class="upload-img-box">
                                        <img src="{{ getFileUrl(getGeneralSettingData(auth()->id(),'app_logo')) }}">
                                        <input type="file" name="app_logo" id="app_logo" accept="image/*"
                                               onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{
                                    $errors->first('app_logo')
                                    }}</span>
                                    @endif
                                    <p><span class="text-black"> <span
                                                class="text-black">{{__('Recommend Size')}}:</span> 140 x 40
                                </span></p>
                                </div>
                                @php
                                    @endphp
                                <div class="col mb-3">
                                    <label class="form-label">{{__('App Fav Icon')}} </label>
                                    <div class="upload-img-box">
                                        <img src="{{ getFileUrl(getGeneralSettingData(auth()->id(),'app_fav_icon')) }}">
                                        <input type="file" name="app_fav_icon" id="app_fav_icon" accept="image/*"
                                               onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_fav_icon'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{
                                    $errors->first('app_fav_icon')
                                    }}</span>
                                    @endif
                                    <p><span class="text-black"><span
                                                class="text-black">{{__('Recommend Size')}}:</span> 16 x 16</span></p>
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label">{{__('Admin Logo & Footer Logo')}}</label>
                                    <div class="upload-img-box">
                                        <img
                                            src="{{ getFileUrl(getGeneralSettingData(auth()->id(),'app_footer_logo')) }}">
                                        <input type="file" name="app_footer_logo" id="app_footer_logo" accept="image/*"
                                               onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{
                                    $errors->first('app_logo')
                                    }}</span>
                                    @endif
                                    <p><span class="text-black"><span
                                                class="text-black">{{__('Recommend Size')}}:</span> 140 x 40</p>
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label">{{__('Login Left Image')}}</label>
                                    <div class="upload-img-box">
                                        <img
                                            src="{{ getFileUrl(getGeneralSettingData(auth()->id(),'login_left_image')) }}">
                                        <input type="file" name="login_left_image" id="login_left_image"
                                               accept="image/*"
                                               onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('login_left_image'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{
                                    $errors->first('login_left_image')
                                    }}</span>
                                    @endif
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
@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush
@push('script')

    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
@endpush
