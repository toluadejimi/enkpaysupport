@extends('admin.layouts.app')
@push('style')

    <link rel="stylesheet" type="text/css" href="{{asset('admin/libs/datatable/datatables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/custom/image-preview.css')}}">

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
                                <h2>{{__('User')}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item">{{ __("User") }}</li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            @if(isAddonInstalled('DESKSAAS') > 0)
                @if(auth()->user()->role == USER_ROLE_SUPER_ADMIN)
                    <div class="row">
                        <input type="hidden" id="user-route" value="{{ route('admin.user.list') }}">
                        <div class="col-lg-12">
                            <div class="customers__area bg-style mb-30">
                                <div class="item-title d-flex flex-wrap justify-content-between">
                                    <h2>{{ __($pageTitle) }}</h2>
                                    <a href="{{route('admin.user.add-new')}}" class="btn btn-primary">Add User</a>
                                </div>
                                <div class="customers__table">
                                    <table
                                        class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                                        id="commonDataTable">
                                        <thead>
                                        <tr>
                                            <th>{{ __("picture") }}</th>
                                            <th>{{ __("Name") }}</th>
                                            <th>{{ __("Email") }}</th>
                                            <th>{{ __("Status") }}</th>
                                            <th class="action__buttons d-flex justify-content-end">{{ __("Action") }}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <input type="hidden" id="user-route" value="{{ route('admin.user.list') }}">
                        <div class="col-lg-12">
                            <div class="customers__area bg-style mb-30">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                                aria-selected="true">Agent
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#profile" type="button" role="tab"
                                                aria-controls="profile" aria-selected="false">Customer
                                        </button>
                                    </li>
                                </ul>
                                <hr>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                         aria-labelledby="home-tab">
                                        <div class="item-title d-flex flex-wrap justify-content-between">
                                            <h2></h2>
                                            <a href="{{route('admin.user.add-new')}}" class="btn btn-primary">Add
                                                User</a>
                                        </div>

                                        <div class="customers__table">
                                            <table
                                                class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                                                id="commonDataTable">
                                                <thead>
                                                <tr>
                                                    <th>{{ __("picture ") }}</th>
                                                    <th>{{ __("Name") }}</th>
                                                    <th>{{ __("Email") }}</th>
                                                    <th>{{ __("Status") }}</th>
                                                    <th class="action__buttons d-flex justify-content-end">{{ __("Action") }}</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel"
                                         aria-labelledby="profile-tab">
                                        <div class="item-title d-flex flex-wrap justify-content-between">
                                            <h2></h2>
                                            <a href="{{route('admin.user.add-new')}}" class="btn btn-primary">Add
                                                User</a>
                                        </div>

                                        <div class="customers__table">
                                            <input type="hidden" id="user-route-for-customer"
                                                   value="{{ route('admin.user.customer.list') }}">
                                            <table
                                                class="w-100 row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                                                id="commonDataTableForCustomer">
                                                <thead>
                                                <tr>
                                                    <th>{{ __("picture") }}</th>
                                                    <th>{{ __("Name") }}</th>
                                                    <th>{{ __("Email") }}</th>
                                                    <th>{{ __("Status") }}</th>
                                                    <th class="ms-5">{{ __("Action") }}</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="row">
                    <input type="hidden" id="user-route" value="{{ route('admin.user.list') }}">
                    <div class="col-lg-12">
                        <div class="customers__area bg-style mb-30">

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                            data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                            aria-selected="true">Agent
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                            aria-selected="false">Customer
                                    </button>
                                </li>
                            </ul>
                            <hr>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                     aria-labelledby="home-tab">
                                    <div class="item-title d-flex flex-wrap justify-content-between">
                                        <h2></h2>
                                        <a href="{{route('admin.user.add-new')}}" class="btn btn-primary">Add User</a>
                                    </div>

                                    <div class="customers__table">
                                        <table
                                            class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                                            id="commonDataTable">
                                            <thead>
                                            <tr>
                                                <th>{{ __("picture ") }}</th>
                                                <th>{{ __("Name") }}</th>
                                                <th>{{ __("Email") }}</th>
                                                <th>{{ __("Status") }}</th>
                                                <th class="action__buttons d-flex justify-content-end">{{ __("Action") }}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="item-title d-flex flex-wrap justify-content-between">
                                        <h2></h2>
                                        <a href="{{route('admin.user.add-new')}}" class="btn btn-primary">Add User</a>
                                    </div>

                                    <div class="customers__table">
                                        <input type="hidden" id="user-route-for-customer"
                                               value="{{ route('admin.user.customer.list') }}">
                                        <table
                                            class="w-100 row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                                            id="commonDataTableForCustomer">
                                            <thead>
                                            <tr>
                                                <th>{{ __("picture") }}</th>
                                                <th>{{ __("Name") }}</th>
                                                <th>{{ __("Email") }}</th>
                                                <th>{{ __("Status") }}</th>
                                                <th class="ms-5">{{ __("Action") }}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('script')

    <script src="{{asset('admin/libs/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/user.js')}}"></script>
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>

@endpush
