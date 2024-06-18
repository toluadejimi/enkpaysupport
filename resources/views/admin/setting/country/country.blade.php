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
                <input type="hidden" id="country-route" value="{{ route('admin.setting.country.list') }}">
                <input type="hidden" id="update-country-Route" value="{{ route('admin.setting.country.update') }}">
                <div class="col-lg-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex flex-wrap justify-content-between">
                            <h2>{{ __('Country Settings') }}</h2>
                        </div>
                        <div class="customers__table">
                            <table
                                class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                                id="commonDataTable">
                                <thead>
                                <tr>
                                    <th>{{ __("SL#") }}</th>
                                    <th>{{ __("Name") }}</th>
                                    <th class="action__buttons d-flex justify-content-start">{{ __("Action") }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
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
