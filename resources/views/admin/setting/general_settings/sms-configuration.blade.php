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
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
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
                        <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
                            <h2>{{ $pageTitle }}</h2>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#sendTestMail" class="btn btn-success btn-sm"> <i class="fa fa-envelope"></i> {{ __('Send Test SMS') }} </a>
                        </div>
                        <form class="ajax" action="{{route('admin.setting.sms-configuration')}}" method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('APP SMS STATUS')}} <span class="text-danger">*</span></label>
                                        <select name="app_sms_status" class="form-control" required>
                                            <option value="1" {{getOption('app_sms_status') == 1 ? 'selected' : '' }} > {{__('Enable')}} </option>
                                            <option value="0" {{getOption('app_sms_status') != 1 ? 'selected' : '' }} > {{__('Disable')}} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('TWILIO ACCOUNT SID')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="TWILIO_ACCOUNT_SID" value="{{getOption('TWILIO_ACCOUNT_SID')}}" required class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('TWILIO AUTH TOKEN')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="TWILIO_AUTH_TOKEN" value="{{getOption('TWILIO_AUTH_TOKEN')}}" required class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('TWILIO PHONE NUMBER')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="TWILIO_PHONE_NUMBER" value="{{getOption('TWILIO_PHONE_NUMBER')}}" required class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input__group general-settings-btn">
                                        <button type="submit" class="btn btn-blue float-right">{{__('Save')}}</button>
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

    <div class="modal fade" id="sendTestMail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Test SMS')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <form class="ajax reset" action="{{ route('admin.setting.sms.test') }}" method="post"
                          data-handler="commonResponse">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3 text-black">
                            <label for="to" class="col-form-label">{{__('Recipient Number')}}:</label>
                            <input type="text" name="to" class="form-control" id="to" placeholder="{{__('Recipient Number')}}" required>
                        </div>
                        <div class="mb-3 text-black">
                            <label for="message" class="col-form-label">{{ __('Your Message') }}:</label>
                            <textarea name="message" class="form-control" id="message-text">{{ __('Hi, This is a test sms') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer button__list">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-blue mx-2">{{ __('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

