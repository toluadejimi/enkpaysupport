@extends('agent.layouts.app')
@push('title')
    {{ __('Dashboard') }}
@endpush
@push('style')
    <link rel="stylesheet" href="{{asset('admin/libs/datatable/user-tables.min.css')}}"/>

    <style>
        #container {
            width: 100%;
            height: 450px;
        }
    </style>
@endpush
@section('content')
    <input type="hidden" id="get-daily-chart-data" value="{{route('agent.dashboard-daily-ticket-chart')}}">
    <input type="hidden" id="get-category-chart-data" value="{{route('agent.dashboard-category-chart')}}">
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
                                        <h2>{{__("Analytics2")}}</h2>
                                        <p>{{__("Welcome back")}}, {{auth()->user()->name}}</p>
                                        <img src="{{asset('agent')}}/assets/images/waving-hand 1.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- dashboard area end -->

            <!-- all ticket count start -->

            <div class="row">
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="single-ticket-count">
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
                    <div class="single-ticket-count">
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
                    <div class="single-ticket-count">
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
                    <div class="single-ticket-count">
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
                    <div class="single-ticket-count">
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
                    <div class="single-ticket-count">
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

            <!-- all ticket count end -->

            <!-- chart start -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 col-xl-8  mt-1">
                        <div class="content-wrap h-100 mb-0 pb-0 mt-2">
                            <div class="section-top-title">
                                <h2 class="title">{{__("Monthly Summery")}}</h2>
                            </div>
                            <div class="single-ticket-count justify-content-center pb-0">
                                <div id="container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-xl-4  mt-1">
                        <div class="content-wrap sf-content-wrap mb-0 mt-2">
                            <div class="section-top-title">
                                <h2 class="title">{{__("Summery by Categories")}}</h2>
                            </div>
                            <div class="single-ticket-count justify-content-center pb-0">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- chart end -->

            <div class="container-fluid">
                <div class="row">

                    <!-- ticket summery area start -->

                    <div class="col-lg-12 col-xl-12">
                        <div class="content-wrap">
                            <div class="section-top-title">
                                <h2 class="title">Active Tickets</h2>
                            </div>
                            <div class="table-responsive">
                                <button class="deleteData" id="deleteData">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                         fill="none">
                                        <path d="M2 4H3.33333H14" stroke="#737C90" stroke-width="1.4"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                        <path
                                            d="M5.33203 4.00004V2.66671C5.33203 2.31309 5.47251 1.97395 5.72256 1.7239C5.9726 1.47385 6.31174 1.33337 6.66536 1.33337H9.33203C9.68565 1.33337 10.0248 1.47385 10.2748 1.7239C10.5249 1.97395 10.6654 2.31309 10.6654 2.66671V4.00004M12.6654 4.00004V13.3334C12.6654 13.687 12.5249 14.0261 12.2748 14.2762C12.0248 14.5262 11.6857 14.6667 11.332 14.6667H4.66536C4.31174 14.6667 3.9726 14.5262 3.72256 14.2762C3.47251 14.0261 3.33203 13.687 3.33203 13.3334V4.00004H12.6654Z"
                                            stroke="#737C90" stroke-width="1.4" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <path d="M6.66797 7.33337V11.3334" stroke="#737C90" stroke-width="1.4"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.33203 7.33337V11.3334" stroke="#737C90" stroke-width="1.4"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    {{__("Delete")}}
                                </button>
                                <input type="hidden" value="{{route('agent.dashboard')}}" id="ticket-url">

                                <form action="{{route('agent.ticket.ticket-multi-delete')}}" method="post"
                                      class="form-horizontal"
                                      enctype="multipart/form-data" id="deleteForm">
                                    @csrf
                                    <table class="table ZaideskTable" id="ticketsDataTable">
                                        <thead>
                                        <tr>
                                            <th>
                                                <div class="round">
                                                    <input type="checkbox" id="allCheck"/>
                                                    <label for="allCheck" class="top-0"></label>
                                                </div>
                                            </th>
                                            <th>{{ __('Ticket Id') }}</th>
                                            <th>{{ __('Ticket Title') }}</th>
                                            <th>{{ __('Created By') }}</th>
                                            <th>{{ __('Created By Email') }}</th>
                                            <th>{{ __('Category') }}</th>
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
    <script src="{{config('app.chart_link')}}"></script>
    <script src="{{asset('assets/js/plugin/anychart.min.js')}}"></script>
    <script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{asset('agent/assets/js/custom/tickets.js') }}"></script>
    <script>
        (function($){
            "use strict";

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
        })(jQuery);
    </script>
@endpush
