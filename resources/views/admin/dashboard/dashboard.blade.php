@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/libs/datatable/datatables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/custom/frontend.css') }}" />
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __($pageTitle) }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
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
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="status__box status__box__v3 bg-style">
                                <div class="status__box__img">
                                    <img src="{{ asset('admin/images/status-icon/expense.png') }}" alt="icon">
                                </div>
                                <div class="status__box__text">
                                    <h2 class="color-blue">{{$newUser}}</h2>
                                    <h3>{{__("New User")}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="status__box status__box__v3 bg-style">
                                <div class="status__box__img">
                                    <img src="{{ asset('admin/images/status-icon/revenue.png') }}" alt="icon">
                                </div>
                                <div class="status__box__text">
                                    <h2 class="color-red">{{$suspendedUser}}</h2>
                                    <h3>{{__("Suspended User")}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="status__box status__box__v3 bg-style">
                                <div class="status__box__img">
                                    <img src="{{ asset('admin/images/status-icon/expense.png') }}" alt="icon">
                                </div>
                                <div class="status__box__text">
                                    <h2 class="color-blue">{{$deletedUser}}</h2>
                                    <h3>{{__("Deleted User")}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="status__box status__box__v3 bg-style">
                                <div class="status__box__img">
                                    <img src="{{ asset('admin/images/status-icon/revenue.png') }}" alt="icon">
                                </div>
                                <div class="status__box__text">
                                    <h2 class="color-red">{{$pendingOrder}}</h2>
                                    <h3>{{__("Pending Order")}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chart start -->
                    <div class="">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <div class="content-wrap">
                                    <div class="section-top-title">
                                        <h2 class="title">{{__("Monthly  Order Summery")}}</h2>
                                    </div>
                                    <div class="single-ticket-count justify-content-center">
                                        <div id="container"></div>
                                    </div>
                                </div>
                            </div>

{{--                            <div class="col-lg-4 col-xl-4">--}}
{{--                                <div class="content-wrap">--}}
{{--                                    <div class="section-top-title">--}}
{{--                                        <h2 class="title">{{__("Summery by Categories")}}</h2>--}}
{{--                                    </div>--}}
{{--                                    <div class="single-ticket-count justify-content-center">--}}
{{--                                        <canvas id="myChart"></canvas>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <!-- chart end -->
                @else
                    <div class="row">
                        <div class="col-lg-2 col-md-6 mb-4">
                            <div class="status__box status__box__v3 bg-style">
                                <div class="right-box-ticket">
                                    <div class="ticket-img-box rectangle">
                                        <img src="{{asset('agent')}}/assets/images/green.png" alt="" />
                                    </div>
                                    <p>{{__("Total Tickets")}}</p>
                                    <h1>{{$totalTicketCount}}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-4">
                            <div class="status__box status__box__v3 bg-style">
                                <div class="right-box-ticket">
                                    <div class="ticket-img-box indianRed">
                                        <img src="{{asset('agent')}}/assets/images/red.png" alt="" />
                                    </div>
                                    <p>{{__("Active Tickets")}}</p>
                                    <h1>{{$activeTicketCount}}</h1>
                                </div>
                            </div>
                        </div>
                       <div class="col-lg-2 col-md-6 mb-4">
                            <div class="status__box status__box__v3 bg-style">
                                <div class="right-box-ticket">
                                    <div class="ticket-img-box mediumSlateBlue">
                                        <img src="{{asset('agent')}}/assets/images/yel.png" alt="" />
                                    </div>
                                    <p>{{__("Recent Tickets")}}</p>
                                    <h1>{{$recentTicketCount}}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-4">
                            <div class="status__box status__box__v3 bg-style">
                                <div class="right-box-ticket">
                                    <div class="ticket-img-box mediumPurple">
                                        <img src="{{asset('agent')}}/assets/images/greenline.png" alt="" />
                                    </div>
                                    <p>{{__("My Assigned Tickets")}}</p>
                                    <h1>{{$myAssignTicketCount}}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-4">
                            <div class="status__box status__box__v3 bg-style">
                                <div class="right-box-ticket">
                                    <div class="ticket-img-box orangeBg">
                                        <img src="{{asset('agent')}}/assets/images/orange.png" alt="" />
                                    </div>
                                    <p>{{__("Resolved Tickets")}}</p>
                                    <h1>{{$onHoldTicketCount}}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-4">
                            <div class="status__box status__box__v3 bg-style">
                                <div class="right-box-ticket">
                                    <div class="ticket-img-box lightYellow">
                                        <img src="{{asset('agent')}}/assets/images/yellow.png" alt="" />
                                    </div>
                                    <p>{{__("Closed Tickets")}}</p>
                                    <h1>{{$closedTicketCount}}</h1>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- chart start -->
                    <div class="">
                        <div class="row">
                            <div class="col-lg-8 col-xl-8">
                                <div class="content-wrap">
                                    <div class="section-top-title">
                                        <h2 class="title">{{__("Monthly Summery")}}</h2>
                                    </div>
                                    <div class="single-ticket-count justify-content-center">
                                        <div id="container"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-xl-4">
                                <div class="content-wrap">
                                    <div class="section-top-title">
                                        <h2 class="title">{{__("Summery by Categories")}}</h2>
                                    </div>
                                    <div class="single-ticket-count justify-content-center">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chart end -->
                    <div class="">
                        <div class="row">

                            <!-- ticket summery area start -->

                            <div class="col-lg-12 col-xl-12">
                                <div class="content-wrap">
                                    <div class="section-top-title">
                                        <h2 class="title">{{__("Active Tickets")}}</h2>
                                    </div>
                                    <div class="table-responsive">
                                        <input type="hidden" id="ticket-list-route" value="{{ $targetDataUrl }}">
                                        <div class="customers__table">
                                            <table class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline ZaideskTable"
                                                   id="ticketManagementDataTable">
                                                <thead>
                                                <tr>
                                                    <th>{{ __("Ticket Id") }}</th>
                                                    <th>{{ __('Ticket Details') }}</th>
                                                    <th>{{ __('Created By') }}</th>
                                                    <th>{{ __('Updated') }}</th>
                                                    <th>{{ __('Assigned') }}</th>
                                                    <th class="action__buttons d-flex justify-content-end">{{ __('Action') }}</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- ticket summery area end -->

                        </div>
                    </div>
                @endif
            @else
                <div class="row">
                    <div class="col-lg-2 col-md-6">
                        <div class="status__box status__box__v3 bg-style">
                            <div class="right-box-ticket">
                                <div class="ticket-img-box rectangle">
                                    <img src="{{asset('agent')}}/assets/images/green.png" alt="" />
                                </div>
                                <p>{{__("Total Tickets")}}</p>
                                <h1>{{$totalTicketCount}}</h1>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="status__box status__box__v3 bg-style">
                            <div class="right-box-ticket">
                                <div class="ticket-img-box indianRed">
                                    <img src="{{asset('agent')}}/assets/images/red.png" alt="" />
                                </div>
                                <p>{{__("Active Tickets")}}</p>
                                <h1>{{$activeTicketCount}}</h1>
                            </div>

                        </div>
                    </div>
                   <div class="col-lg-2 col-md-6">
                        <div class="status__box status__box__v3 bg-style">
                            <div class="right-box-ticket">
                                <div class="ticket-img-box mediumSlateBlue">
                                    <img src="{{asset('agent')}}/assets/images/yel.png" alt="" />
                                </div>
                                <p>{{__("Recent Tickets")}}</p>
                                <h1>{{$recentTicketCount}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="status__box status__box__v3 bg-style">
                            <div class="right-box-ticket">
                                <div class="ticket-img-box mediumPurple">
                                    <img src="{{asset('agent')}}/assets/images/greenline.png" alt="" />
                                </div>
                                <p>{{__("My Assigned Tickets")}}</p>
                                <h1>{{$myAssignTicketCount}}</h1>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="status__box status__box__v3 bg-style">
                            <div class="right-box-ticket">
                                <div class="ticket-img-box orangeBg">
                                    <img src="{{asset('agent')}}/assets/images/orange.png" alt="" />
                                </div>
                                <p>{{__("Resolved Tickets")}}</p>
                                <h1>{{$onHoldTicketCount}}</h1>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="status__box status__box__v3 bg-style">
                            <div class="right-box-ticket">
                                <div class="ticket-img-box lightYellow">
                                    <img src="{{asset('agent')}}/assets/images/yellow.png" alt="" />
                                </div>
                                <p>{{__("Closed Tickets")}}</p>
                                <h1>{{$closedTicketCount}}</h1>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- chart start -->
                <div class="">
                    <div class="row">
                        <div class="col-lg-8 col-xl-8 ">
                            <div class="content-wrap pb-0 m-0 h-100">
                                <div class="section-top-title">
                                    <h2 class="title">{{__("Monthly Summery")}}</h2>
                                </div>
                                <div class="single-ticket-count justify-content-center">
                                    <div id="container"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 ">
                            <div class="content-wrap pb-0 m-0 h-100">
                                <div class="section-top-title">
                                    <h2 class="title">{{__("Summery by Categories")}}</h2>
                                </div>
                                <div class="single-ticket-count justify-content-center ad-pie-chart" >
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- chart end -->
{{--                <div class="">--}}
{{--                    <div class="row">--}}

                        <!-- ticket summery area start -->
                        <div class="col-lg-12 col-xl-12">
                            <div class="content-wrap">
                                <div class="section-top-title">
                                    <h2 class="title">{{__("Active Tickets")}}</h2>
                                </div>
                                <div class="table-responsive">
                                    <input type="hidden" id="ticket-list-route" value="{{ $targetDataUrl }}">
                                    <div class="customers__table">
                                        <table class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline ZaideskTable"
                                               id="ticketManagementDataTable">
                                            <thead>
                                            <tr>
                                                <th>{{ __("Ticket Id") }}</th>
                                                <th>{{ __('Ticket Details') }}</th>
                                                <th>{{ __('Created By') }}</th>
                                                <th>{{ __('Updated') }}</th>
                                                <th>{{ __('Assigned') }}</th>
                                                <th class="action__buttons d-flex justify-content-end">{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- ticket summery area end -->--}}

{{--                    </div>--}}
{{--                </div>--}}
            @endif

        </div>
    </div>

    <!-- Ticket View Modal section start -->
    <div class="modal fade" id="ticket-view-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!-- Ticket View section end -->
    <input type="hidden" id="ticketAssignToUrl" value="{{ route('admin.tickets.ticketAssignTo') }}">
    <!-- Ticket Assign section start -->
    <div class="modal fade" id="ticketAssignModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!-- Ticket Assign section end -->
@endsection
@push('script')
    <script src="{{ asset('admin/libs/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom/tickets.js') }}"></script>
    <script src="{{config('app.chart_link')}}"></script>
    <script src="{{asset('assets/js/plugin/anychart.min.js')}}"></script>
    <script>
        var options = {
            series: [
                    @foreach($chart as $key=>$chartData)
                {
                    name: '{{$key}}',
                    data: [@foreach($chartData as $item) {{$item}},@endforeach]
                },
                @endforeach
            ],

            colors: ['#6659FF', '#17d1dc', '#ffb82a','#1EBD53','#FF794D','#B20FB4'],
            dataLabels: {
                enabled: false,
                textAnchor: "left",
                formatter: function (_val, opt) {
                    let series = opt.w.config.series
                    let idx = opt.dataPointIndex
                    const total = series.reduce((total, self) => total + self.data[idx], 0)
                    return total;
                },
                style: {
                    colors: ["#596680"]
                }
            },
            chart: {
                type: 'bar',
                height: '500px',
                stacked: true,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        position: 'bottom',
                        offsetX: -10,
                        offsetY: 0
                    }
                }
            }],
            plotOptions: {
                bar: {
                    horizontal: false,
                    borderRadius: 10,
                    dataLabels: {
                        total: {
                            enabled: true,
                            style: {
                                fontSize: '13px',
                                fontWeight: 900
                            }
                        }
                    }
                },
            },
            xaxis: {
                categories: [@foreach($day as $item) '{{$item}}',@endforeach],
            },
            legend: {
                position: 'right',
                offsetY: 40
            },
            fill: {
                opacity: 1
            }
        };

        var chart = new ApexCharts(document.querySelector("#container"), options);
        chart.render();
    </script>
    <script>

        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'pie',
            responsive: true,
            maintainAspectRatio: false,
            data: {
                labels: [@foreach($categoryChart as $key=>$item) '{{$item['category_name']}}', @endforeach],
                datasets: [{
                    label: 'Chart',
                    data: [@foreach($categoryChart as $key=>$item) '{{$item['total']}}', @endforeach],
                    backgroundColor: [
                        '#6659FF', '#17d1dc', '#ffb82a','#1EBD53','#FF794D'
                    ],
                    hoverOffset: 4
                }],
            }

        });
    </script>
@endpush
