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
            <div class="row">
                <input type="hidden" id="user-route" value="{{ route('admin.user.list') }}">
                <div class="col-lg-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex flex-wrap justify-content-between">
                            <h2>{{ __($pageTitle) }}</h2>
                            <div>
                                <a href="{{route('admin.user.list')}}" class="btn btn-grey btn-sm">{{ __('Back') }}</a>
                                @isset($user->id)
                                    <a href="{{route('admin.user.edit',$user->id)}}"
                                       class="btn btn-success btn-sm">{{ __('Edit') }}</a>
                                @endisset
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xxl-2 col-lg-3 col-md-4">
                                <img src="{{ getFileUrl(isset($user->image)?$user->image:'') }}"
                                     class="width-100 img-thumbnail mb-3" alt="{{__('Profile Picture')}}">
                                <table class="table table-bordered font-12">
                                    <tr>
                                        <td>{{ __("Name") }}</td>
                                        <td>{{ __(isset($user->name)?$user->name:'') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __("Email") }}</td>
                                        <td>{{ __(isset($user->email)?$user->email:'') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __("Type") }}</td>
                                        @if(isset($user->role) && $user->role == USER_ROLE_ADMIN)
                                            <td>{{ __("Admin") }}</td>
                                        @elseif(isset($user->role) && $user->role == USER_ROLE_AGENT)
                                            <td>{{ __("Agent") }}</td>
                                        @elseif(isset($user->role) && $user->role == USER_ROLE_CUSTOMER)
                                            <td>{{ __("Customer") }}</td>
                                        @endif

                                    </tr>
                                    <tr>
                                        <td>{{ __("Mobile") }}</td>
                                        <td>{{ __(isset($user->mobile)?$user->mobile:'') }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __("Gender") }}</td>
                                        <td>{{ __(isset($user->gender)?ucfirst($user->gender):'') }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __("Date of Birth") }}</td>
                                        <td>{{ __(isset($user->dob)?$user->dob:'') }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __("Address") }}</td>
                                        <td>{{ __(isset($user->address)?$user->address:'') }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __("Email Verify") }}</td>
                                        <td>{{ __(isset($user->email_verification_status) && $user->email_verification_status == 1 ?'Yes':'NO') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __("Mobile Verify") }}</td>
                                        <td>{{ __(isset($user->phone_verification_status) && $user->phone_verification_status == 1 ?'Yes':'NO') }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __("Join Date") }}</td>
                                        <td>{{ __(isset($user->created_at)?date('d-m-Y H:i:s', strtotime($user->created_at)):'') }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __("Last Update") }}</td>
                                        <td>{{ __(isset($user->updated_at)?date('d-m-Y H:i:s', strtotime($user->updated_at)):'') }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __("Status") }}</td>
                                        @if($user->status == USER_STATUS_ACTIVE)
                                            <td>{{ __("Active") }}</td>
                                        @elseif($user->status == STATUS_SUSPENDED)
                                            <td>{{ __("Suspended") }}</td>
                                        @else
                                            <td>{{ __("Inactive") }}</td>
                                        @endif
                                    </tr>

                                </table>
                            </div>
                            <div class="col-xxl-10 col-lg-9 col-md-8">
                                @if(isAddonInstalled('DESKSAAS') > 0)
                                    @if(auth()->user()->role == USER_ROLE_SUPER_ADMIN)
                                        <!--start-->
                                        <div class="customers__area bg-style mb-30">
                                            <h6 class="mb-20">{{__("Domain Information")}}</h6>
                                            <div class="customers__table table-responsive">
                                                <table
                                                    class="row-border table-style common-datatable responsive  no-footer dtr-inline width-100"
                                                    id="">
                                                    <thead>
                                                    <tr>
                                                        <th class="desktop ">{{__('Current Domain')}}</th>
                                                        <th class="all">{{__('Requested Domain')}}</th>
                                                        {{-- <th class="all">{{__('Action')}}</th> --}}
                                                    </tr>
                                                    <tr>
                                                        <td class="datatable-td">{{isset($domainInfo->domain)?$domainInfo->domain:'N/A'}}</td>
                                                        {{-- <td class="datatable-td">N\A</td> --}}
                                                        <td class="datatable-td">{{isset($domainInfo->user_domain)?$domainInfo->user_domain:'N/A'}}</td>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <!--end-->
                                    @endif
                                @endif
                                <!--start-->
                                <div class="customers__area bg-style mb-30">
                                    <h6 class="mb-20">Activity Log</h6>
                                    <div class="customers__table table-responsive">
                                        <input type="hidden" id="user-activity-route"
                                               value="{{ route('admin.user.activity',$user->id )}}">
                                        <table
                                            class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline width-100"
                                            id="activityDataTable">
                                            <thead>
                                            <tr>
                                                <th class="desktop ">{{__('Action')}}</th>
                                                <th class="all">{{__('Source')}}</th>
                                                <th class="all">{{__('IP Address')}}</th>
                                                <th class="all">{{__('Location')}}</th>
                                                <th class="desktop ">{{__('When')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <!--end-->

                            </div>
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
    <script src="{{asset('admin/js/custom/user.js')}}"></script>
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>

@endpush
