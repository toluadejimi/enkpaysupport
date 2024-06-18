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
                                <h2>{{ __('Application Settings') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __(@$pageTitle) }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('admin.setting.sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style">
                        <div class="item-top mb-30"><h2>{{ __(@$pageTitle) }}</h2></div>
                        <form action="{{route('admin.setting.application-settings.update')}}" method="post">
                            @csrf
                            <div class="custom-form-group mb-3 row">
                                <label for="banner_title" class="col-lg-3 text-lg-right text-black">{{ __('Banner Title') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="banner_title" id="banner_title" value="{{ getOption('banner_title') }}" class="form-control" placeholder="Type banner title">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="featured_gallery_title" class="col-lg-3 text-lg-right text-black">{{ __('Featured Gallery Title') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="featured_gallery_title" id="featured_gallery_title" value="{{ getOption('featured_gallery_title') }}" class="form-control" placeholder="{{__('Type featured gallery title')}}">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="featured_gallery_subtitle" class="col-lg-3 text-lg-right text-black">{{ __('Featured Gallery Subtitle') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="featured_gallery_subtitle" id="featured_gallery_subtitle" value="{{ getOption('featured_gallery_subtitle') }}" class="form-control" placeholder="{{__('Type featured gallery subtitle')}}">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="most_download_title" class="col-lg-3 text-lg-right text-black">{{ __('Most Download Title') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="most_download_title" id="most_download_title" value="{{ getOption('most_download_title') }}" class="form-control" placeholder="{{__('Type most download title')}}">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="most_download_subtitle" class="col-lg-3 text-lg-right text-black">{{ __('Most Download Subtitle') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="most_download_subtitle" id="most_download_subtitle" value="{{ getOption('most_download_subtitle') }}" class="form-control" placeholder="{{__('Type most download subtitle')}}">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="most_favourite_title" class="col-lg-3 text-lg-right text-black">{{ __('Most Favourite Title') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="most_favourite_title" id="most_favourite_title" value="{{ getOption('most_favourite_title') }}" class="form-control" placeholder="{{__('Type most favourite title')}}">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="most_favourite_subtitle" class="col-lg-3 text-lg-right text-black">{{ __('Most Favourite Subtitle') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="most_favourite_subtitle" id="most_favourite_subtitle" value="{{ getOption('most_favourite_subtitle') }}" class="form-control" placeholder="{{__('Type most favourite subtitle')}}">
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-md-2 text-end">
                                    <button type="submit" class="btn btn-blue">{{ __('Update') }}</button>
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
