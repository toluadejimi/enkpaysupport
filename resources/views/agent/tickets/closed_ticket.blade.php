@extends('agent.layouts.app')
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
                                        <a class="ticket-btu-com" href="{{route('agent.ticket.create-ticket')}}"> {{__("Create Ticket")}}</a>
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
                                <button class="deleteData" id="deleteData"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2 4H3.33333H14" stroke="#737C90" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.33203 4.00004V2.66671C5.33203 2.31309 5.47251 1.97395 5.72256 1.7239C5.9726 1.47385 6.31174 1.33337 6.66536 1.33337H9.33203C9.68565 1.33337 10.0248 1.47385 10.2748 1.7239C10.5249 1.97395 10.6654 2.31309 10.6654 2.66671V4.00004M12.6654 4.00004V13.3334C12.6654 13.687 12.5249 14.0261 12.2748 14.2762C12.0248 14.5262 11.6857 14.6667 11.332 14.6667H4.66536C4.31174 14.6667 3.9726 14.5262 3.72256 14.2762C3.47251 14.0261 3.33203 13.687 3.33203 13.3334V4.00004H12.6654Z" stroke="#737C90" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.66797 7.33337V11.3334" stroke="#737C90" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.33203 7.33337V11.3334" stroke="#737C90" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> {{__("Delete")}}</button>
                                <input type="hidden" value="{{route('agent.ticket.closed-tickets')}}" id="ticket-url">
                                <form action="{{route('agent.ticket.ticket-multi-delete')}}" method="post" class="form-horizontal"
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
            @endsection

            @push('script')
                <script src="{{asset('admin/libs/datatable/user-tables.min.js')}}"></script>
                <script src="{{asset('agent/assets/js/custom/tickets.js') }}"></script>
            @endpush
