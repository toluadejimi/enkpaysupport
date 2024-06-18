@extends('customer.layouts.app_guest')
@push('title')
    {{ __('View Tickets') }}
@endpush
@push('style')
    <link rel="stylesheet" href="{{asset('admin/libs/datatable/user-tables.min.css')}}"/>
@endpush
@section('content')
    <!-- Right Content Start -->
    <div class="guest-main-content">
        <div class="page-content">

            <!-- dashboard area start -->
            <section class="dashboard-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dashboard-box">
                                <div class="title-area">
                                    <div class="dashboard-text">
                                        <h2>{{$pageTitle}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- dashboard area end -->
            <!-- View Ticket start-->
            <section class="view-ticket-area">
                <div class="container-fluid">
                    <div class="row position-relative">
                        <div class="col-lg-8">
                            <div class="allPostUser">
                                <!-- Ticket Assign Tags Start -->
                                @include('customer.tickets.ticket_details_guest.assign-tag')
                                <!-- Ticket Assign Tags End -->
                                <!-- Ticket Conversation Start -->
                                @include('customer.tickets.ticket_details_guest.conversation')
                                <!-- Ticket Conversation End -->
                            </div>
                            <!-- Conversation List Start -->
                            @include('customer.tickets.ticket_details_guest.conversation-list')
                            <!-- Conversation List End -->
                        </div>
                        <div class="col-lg-4">
                            <!-- Ticket Info Start -->
                            @include('customer.tickets.ticket_details_guest.ticket-info')
                            <!-- Ticket Info end -->
                            <!-- Customer Details Start -->
                            @include('customer.tickets.ticket_details_guest.agent-details')
                            <!-- Customer Details end -->
                        </div>
                        <span id="instantnoneClick"></span>
                    </div>
                </div>
            </section>
            <!-- View Ticket end-->
        </div>
    </div>
    <!--ticketReview modal area start -->
    @if(getOption('agent_rating_status') == 1)
        @include('customer.tickets.ticket_details_guest.rating-modal')
    @endif
    <!--ticketReview modal area end -->
@endsection

@push('script')
    <script src="{{asset('admin/libs/datatable/user-tables.min.js')}}"></script>
    <script src="{{asset('customer/assets/js/custom/tickets.js') }}"></script>
    <script type="text/javascript" src="{{ asset('agent/assets/js/custom.js')}}"></script>
    <script src="{{ asset('admin/js/custom/ticket-details.js') }}"></script>
@endpush
