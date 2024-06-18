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
                                    <li class="breadcrumb-item"><a href="#">{{__('Features ')}}</a></li>
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
                            <h2>{{__('Update Cookie Settings')}}</h2>
                        </div>
                        <form class="ajax" action="{{ route('admin.setting.common.settings.update') }}" method="post"
                              class="form-horizontal" data-handler="commonResponse">
                            @csrf
                            <div class="row">

                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label>{{__('Enable Cookie')}} </label>
                                    <div class="input-group">
                                        <select name="cookie_status" id="" class="form-control">
                                            <option
                                                value="1" {{ getOption('referral_status') == 1 ? 'selected':'' }}>{{ __('Yes') }}</option>
                                            <option
                                                value="0" {{ getOption('referral_status') != 1 ? 'selected':'' }}>{{ __('No') }}</option>
                                        </select>
                                        @if ($errors->has('cookie_status'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('cookie_status') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('Cookie Header Text')}} </label>
                                    <input type="text" name="cookie_header_text"
                                           value="{{getOption('cookie_header_text')}}"
                                           class="form-control">
                                    @if ($errors->has('cookie_header_text'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('cookie_header_text') }}</span>
                                    @endif
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('Cookie Button Text')}} </label>
                                    <input type="text" name="cookie_button_text"
                                           value="{{getOption('cookie_button_text')}}"
                                           class="form-control">
                                    @if ($errors->has('cookie_button_text'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('cookie_button_text') }}</span>
                                    @endif
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label class="form-label">{{__('Cookie description')}} </label>
                                    <input type="text" name="cookie_description"
                                           value="{{getOption('cookie_description')}}"
                                           class="form-control">
                                    @if ($errors->has('cookie_description'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('cookie_description') }}</span>
                                    @endif
                                </div>
                                <div class="col-xxl-4 col-lg-6 mb-3">
                                    <label>{{__('Select page for cookie')}} </label>
                                    <div class="input-group">
                                        <select name="cookie_page" id="" class="form-control">
                                            <option
                                                value="1" {{ getOption('cookie_page') == 1 ? 'selected':'' }}>{{ __('Yes') }}</option>
                                            <option
                                                value="0" {{ getOption('cookie_page') != 1 ? 'selected':'' }}>{{ __('No') }}</option>
                                        </select>
                                        @if ($errors->has('cookie_page'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('cookie_page') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-3 col-lg-6 mb-3">
                                    <label class="form-label">{{__('Cookie Image')}}</label>
                                    <div class="upload-img-box">
                                        <img src="{{ getSettingImage('cookie_image') }}">
                                        <input type="file" name="cookie_image" id="app_footer_logo" accept="image/*"
                                               onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    @if ($errors->has('cookie_image'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{
                                    $errors->first('cookie_image')
                                    }}</span>
                                    @endif
                                    <p><span class="text-black"><span
                                                class="text-black">{{__('Recommend Size')}}:</span> 140 x 40</span></p>
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
@endpush
@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
@endpush
