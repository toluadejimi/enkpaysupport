@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/libs/datatable/datatables.min.css')}}"/>
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
                <input type="hidden" id="update-country-Route" value="{{ route('admin.setting.country.update') }}">
                <div class="col-lg-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex flex-wrap justify-content-between">
                            <h2>{{ __('Ticket Configuration') }}</h2>
                        </div>
                        <form class="ajax reset" action="{{route('admin.setting.tracking-no-pre-fixed-store')}}" method="post"
                              data-handler="commonResponse">
                            @csrf
                            <input type="hidden" value="{{auth()->id()}}" name="user_id">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input__group mb-25">
                                        <label for="user_role">{{__('Tracking Number Pre Fixed')}} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="pre_fixed" value="{{isset($configData->ticket_tracking_no_pre_fixed)?$configData->ticket_tracking_no_pre_fixed:''}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="user_role">{{__('Agent Fake Name')}} <span
                                        class="text-danger">*</span></label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"  id="agentFakeName" name="agentFakeName" @if(isset($configData->agent_fake_name) && $configData->agent_fake_name == 1) checked="" @endif >
                                      </div>
                                </div>
                                <div class="justify-content-end row text-end">
                                    <div class="col-md-12">
                                        <button class="btn btn-blue float-right"
                                                type="submit">{{ __('Update') }}</button>
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
    <script src="{{asset('admin/libs/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/country.js')}}"></script>
@endpush
