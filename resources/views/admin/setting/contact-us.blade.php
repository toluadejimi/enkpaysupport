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
                                <label for="contact_us_location" class="col-lg-3 text-lg-right text-black">{{ __('Location') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="contact_us_location" id="contact_us_location" value="{{ getOption('contact_us_location') }}" class="form-control" placeholder="{{__('Type location')}}">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="contact_us_first_email" class="col-lg-3 text-lg-right text-black">{{ __('Email One') }} </label>
                                <div class="col-lg-9">
                                    <input type="email" name="contact_us_first_email" id="contact_us_first_email" value="{{ getOption('contact_us_first_email') }}" class="form-control" placeholder="{{__('Type email')}}">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="contact_us_second_email" class="col-lg-3 text-lg-right text-black">{{ __('Email Two') }} </label>
                                <div class="col-lg-9">
                                    <input type="email" name="contact_us_second_email" id="contact_us_second_email" value="{{ getOption('contact_us_second_email') }}" class="form-control" placeholder="{{__('Type email')}}">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="contact_us_first_contact_number" class="col-lg-3 text-lg-right text-black">{{ __('Contact Number One') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="contact_us_first_contact_number" id="contact_us_first_contact_number" value="{{ getOption('contact_us_first_contact_number') }}" class="form-control"
                                           placeholder="{{__('Type phone one')}}">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="contact_us_second_contact_number" class="col-lg-3 text-lg-right text-black">{{ __('Contact Number Two') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="contact_us_second_contact_number" id="contact_us_second_contact_number" value="{{ getOption('contact_us_second_contact_number') }}" class="form-control"
                                           placeholder="{{__('Type phone two')}}">
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="contact_us_description" class="col-lg-3 text-lg-right text-black">{{ __('Description') }} </label>
                                <div class="col-lg-9">
                                    <textarea name="contact_us_description" id="contact_us_description" rows="5" class="form-control">{{ getOption('contact_us_description') }}</textarea>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-md-2 text-end">
                                    <button type="submit" class="btn btn-blue">{{__('Update')}}</button>
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
