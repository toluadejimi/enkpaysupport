@extends('customer.layouts.app')
@push('title')
    {{ __('Active Ticket') }}
@endpush
@push('style')
    <link rel="stylesheet" href="{{asset('admin/libs/datatable/user-tables.min.css')}}"/>
@endpush
@section('content')
    <!-- Right Content Start -->
    <div class="main-content">
        <div class="page-content">
            <!-- dashboard area start -->
            <section class="dashboard-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dashboard-box">
                                <div class="title-area mb-0">
                                    <div class="dashboard-text">
                                        <h2>{{$pageTitle}}</h2>
                                    </div>
                                    <div class="ticket-btu">
                                        <a class="ticket-btu-com" href="{{route('customer.ticket.create-ticket')}}"> {{__("Create Ticket")}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- dashboard area end -->
            <div class="container-fluid">
                <div class="row">
                    <!-- ticket summery area start -->
                    <div class="col-lg-12 col-xl-12">
                        <div class="content-wrap">
                            <div class="section-top-title">
                                <h2 class="title">{{$pageTitle}}</h2>
                            </div>
                            <div class="table-responsive">
                                <input type="hidden" value="{{route('customer.ticket.active-ticket')}}" id="ticket-url">

                                <form action="{{route('customer.ticket.ticket-multi-delete')}}" method="post"
                                      class="form-horizontal"
                                      enctype="multipart/form-data" id="deleteForm">
                                    @csrf
                                    <table class="table ZaideskTable" id="ticketsDataTable">
                                        <thead>
                                        <tr>
                                            <th>{{ __('Ticket Id') }}</th>
                                            <th>{{ __('Ticket Title') }}</th>
                                            <th>{{ __('Updated') }}</th>
                                            <th>{{ __('Assigned') }}</th>
                                            <th >{{ __('Action') }}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ticket summery area end -->
                </div>
            </div>
            <!-- modal area start -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="delete-modal-box">
                            <div>
                                <img src="../assets/images/carbon_warning.png" alt="">
                            </div>
                            <h4>{{__('You are about delete this ticket?')}}</h4>
                            <p>{{__('You’re about to delete a tickets on this page. this operation is irreversible.are you
                                sure?')}}</p>
                            <div class="delete-modal">
                                <button type="button" class="submit-btu mx-3" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                                <button type="button" data-bs-dismiss="modal" class="delete-btu submit-btu mx-3">
                                    {{__('Delete')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal area end -->
            @endsection

    @push('script')
                <script src="{{asset('admin/libs/datatable/user-tables.min.js')}}"></script>
                <script src="{{asset('customer/assets/js/custom/tickets.js') }}"></script>
    @endpush
