@extends('customer.layouts.app')
@push('title')
    {{ __('Dashboard') }}
@endpush
@push('style')
    <link rel="stylesheet" href="{{asset('admin/libs/datatable/user-tables.min.css')}}"/>
@endpush
@section('content')
<div class="main-content">
    <div class="page-content">
        <!-- dashboard area start -->
        <section class="dashboard-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dashboard-box">
                            <div class="title-area">
                                <div class="dashboard-text">
                                    <h2>{{__("Dashboard")}}</h2>
                                    <p>{{__("Welcome back")}}, {{auth()->user()->name}}</p>
                                    <img src="{{asset('customer')}}/assets/images/waving-hand 1.png" alt="">
                                </div>
                                <div class="ticket-btu">
                                    <a class="ticket-btu-com" href="{{route('customer.ticket.create-ticket')}}"> {{__("Create Ticket")}}</a>
                                </div>
                            </div>
                            <!-- all ticket count start -->

                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <div class="single-ticket-count">
                                        <div class="right-box-ticket">
                                            <div class="ticket-img-box rectangle">
                                                <svg width="20" height="12" viewBox="0 0 20 12" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                          d="M0.6668 11.9993H13.338C13.4093 11.9993 13.48 11.9879 13.548 11.9653C13.7007 11.9146 13.8328 11.8072 13.9141 11.6679C13.9455 11.6138 13.9695 11.5558 13.9848 11.4952L13.9895 11.4738L13.9941 11.4505L13.9975 11.4298L14.0001 11.4091L14.0021 11.3878L14.0041 11.3665L14.0048 11.3451V11.3325C14.0048 10.5983 14.6003 10.0029 15.3344 10.0029C16.0685 10.0029 16.664 10.5983 16.664 11.3325L16.6647 11.3558L16.6653 11.3771L16.6673 11.3978L16.67 11.4185L16.6727 11.4398L16.6767 11.4598L16.6813 11.4845L16.6873 11.5072L16.694 11.5305L16.702 11.5538L16.7087 11.5732L16.7167 11.5919L16.7247 11.6105L16.7333 11.6285L16.7427 11.6465L16.7527 11.6645L16.7627 11.6819L16.7734 11.6985L16.7847 11.7152L16.7967 11.7312L16.8087 11.7472L16.824 11.7659L16.84 11.7839L16.8567 11.8012L16.874 11.8179L16.8927 11.8352L16.9114 11.8506L16.93 11.8652L16.9494 11.8792L16.9661 11.8906L16.9827 11.9012L17.0001 11.9113L17.0181 11.9212L17.0361 11.9306L17.0541 11.9393L17.0767 11.9492L17.0994 11.9579L17.1208 11.9653L17.1448 11.9726L17.1641 11.9779L17.1848 11.9833L17.2048 11.9873L17.2254 11.9913L17.2461 11.9939L17.2668 11.9959L17.2881 11.9979L17.3095 11.9986L17.3308 11.9993H19.3332C19.7013 11.9993 20 11.7005 20 11.3325V0.66767C20 0.299596 19.7013 0.000869751 19.3332 0.000869751H17.3308C17.2595 0.000869751 17.1888 0.0121972 17.1208 0.0342016C16.9681 0.0855452 16.836 0.192894 16.7547 0.332255C16.7233 0.386266 16.6993 0.444279 16.684 0.504958L16.6793 0.526304L16.6747 0.549645L16.6713 0.570299L16.6687 0.590974L16.6667 0.61232L16.6647 0.632995L16.664 0.654321V0.66767C16.664 1.40115 16.0685 1.99726 15.3344 1.99726C14.6003 1.99726 14.0048 1.40115 14.0048 0.66767L14.0041 0.644329L14.0035 0.622983L14.0015 0.602308L13.9988 0.580982L13.9961 0.560308L13.9921 0.539633L13.9875 0.515641L13.9815 0.492952L13.9748 0.469632L13.9668 0.446292L13.9601 0.42694L13.9521 0.408279L13.9441 0.389599L13.9355 0.37161L13.9261 0.353601L13.9161 0.335592L13.9061 0.318255L13.8954 0.301589L13.8841 0.284923L13.8721 0.268908L13.8574 0.249577L13.8421 0.231568L13.8261 0.213579L13.8094 0.196242L13.7921 0.179555L13.7728 0.162218L13.7547 0.146895L13.7354 0.132223L13.7194 0.120889L13.6994 0.10754L13.6827 0.0968769L13.6654 0.0868855L13.6474 0.0768737L13.6294 0.0675335L13.6074 0.057542L13.5847 0.0475303L13.5614 0.0395331L13.54 0.0322074L13.5167 0.0248614L13.4967 0.0195299L13.476 0.0148699L13.456 0.0108612L13.4354 0.00752391L13.4147 0.00485818L13.3933 0.00286396L13.372 0.00152092L13.3507 0.000869751H13.338H0.6668C0.298726 0.000869751 0 0.299596 0 0.66767V11.3325C0 11.7005 0.298726 11.9993 0.6668 11.9993ZM17.9116 1.34047C17.8489 1.57919 17.7542 1.80856 17.6282 2.0206C17.4788 2.27332 17.2875 2.50068 17.0647 2.69139C16.8487 2.87609 16.604 3.02612 16.3406 3.13415C16.1139 3.22683 15.8752 3.28752 15.6318 3.31419C15.3457 3.3462 15.055 3.3322 14.7736 3.27152C14.4796 3.20818 14.1962 3.09481 13.9401 2.93678C13.6561 2.76141 13.406 2.53337 13.2053 2.26731C13.0713 2.08928 12.9599 1.89457 12.8739 1.68852C12.8272 1.57583 12.7879 1.45916 12.7572 1.34047L12.7552 1.33447H1.3336V10.6657H12.7552L12.7572 10.659C12.8199 10.4209 12.9146 10.1916 13.0406 9.97953C13.19 9.72681 13.3813 9.49942 13.6041 9.30872C13.8201 9.12402 14.0648 8.97332 14.3282 8.86596C14.5549 8.77328 14.7936 8.7126 15.037 8.68526C15.3231 8.65392 15.6138 8.66793 15.8952 8.72861C16.1892 8.79129 16.4726 8.9053 16.7287 9.06333C17.0127 9.23803 17.2628 9.46676 17.4635 9.73282C17.5975 9.91085 17.7089 10.1055 17.7949 10.3109C17.8416 10.4243 17.8809 10.541 17.9116 10.659L17.9136 10.6657H18.6664V1.33447H17.9136L17.9116 1.34047ZM3.332 8.66526H10C10.3681 8.66526 10.6668 8.36653 10.6668 7.99846C10.6668 7.63039 10.3681 7.33166 10 7.33166H3.332C2.96393 7.33166 2.6652 7.63039 2.6652 7.99846C2.6652 8.36653 2.96393 8.66526 3.332 8.66526ZM14.6676 5.33126V6.66486C14.6676 7.03293 14.9663 7.33166 15.3344 7.33166C15.7025 7.33166 16.0012 7.03293 16.0012 6.66486V5.33126C16.0012 4.96319 15.7025 4.66446 15.3344 4.66446C14.9663 4.66446 14.6676 4.96319 14.6676 5.33126ZM3.332 4.66446H10C10.3681 4.66446 10.6668 4.36573 10.6668 3.99766C10.6668 3.62959 10.3681 3.33086 10 3.33086H3.332C2.96393 3.33086 2.6652 3.62959 2.6652 3.99766C2.6652 4.36573 2.96393 4.66446 3.332 4.66446Z"
                                                          fill="#0066D9" />
                                                </svg>
                                            </div>
                                            <p>{{__("Total Tickets")}}</p>
                                            <h1>{{$totalTicketCount}}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <div class="single-ticket-count">
                                        <div class="right-box-ticket">
                                            <div class="ticket-img-box mediumPurple">
                                                <img src="{{asset('customer')}}/assets/images/greenline.png" alt="" />
                                            </div>
                                            <p>{{__("Active Tickets")}}</p>
                                            <h1>{{$activeTicketCount}}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <div class="single-ticket-count">
                                        <div class="right-box-ticket">
                                            <div class="ticket-img-box mediumSlateBlue">
                                                <img src="{{asset('customer')}}/assets/images/yel.png" alt="" />
                                            </div>
                                            <p>{{__("Resolved Tickets")}}</p>
                                            <h1>{{$onHoldTicketCount}}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <div class="single-ticket-count">
                                        <div class="right-box-ticket">
                                            <div class="ticket-img-box orangeBg">
                                                <img src="{{asset('customer')}}/assets/images/orange.png" alt="" />
                                            </div>
                                            <p>{{__("Closed Tickets")}}</p>
                                            <h1>{{$closedTicketCount}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- all ticket count end -->
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
                            <h2 class="title">{{__("Ticket Summery")}}</h2>
                        </div>
                        <div class="table-responsive">

                            <input type="hidden" value="{{route('customer.dashboard')}}" id="ticket-url">

                            <form action="{{route('customer.ticket.ticket-multi-delete')}}" method="post" class="form-horizontal"
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
    </div>
</div>
@endsection
@push('script')
    <script src="{{asset('admin/libs/datatable/user-tables.min.js')}}"></script>
    <script src="{{asset('customer/assets/js/custom/tickets.js') }}"></script>

@endpush


