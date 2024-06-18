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
                            <h2>{{__('Custom CSS')}}</h2>
                        </div>
                        <form class="ajax" action="{{ route('admin.setting.common.settings.update') }}" method="post"
                              class="form-horizontal" data-handler="commonResponse">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-12">
                                    <textarea name="custom_css" class="summernote" placeholder="{{ __("Custom CSS") }}">{{$custom_css??" "}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 text-start">
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
<link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote-lite.min.css') }}"/>
@endpush
@push('script')
    <script src="{{ asset('admin/js/custom/pages.js') }}"></script>
    <script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom/summernote-init.js') }}"></script>
@endpush

