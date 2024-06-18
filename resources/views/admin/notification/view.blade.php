@extends('admin.layouts.app')
@push('title')
    {{ __('Notification View') }}
@endpush
@section('content')
    <!-- Right Content Start -->

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


        <!-- Create Ticket start-->

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="create-ticket d-flex align-content-center gap-4">
                            <div class="notifi-img">

                                <img src="{{asset('agent/assets/images/email.png')}}" class="rounded-circle avatar-xs"
                                     alt="user-pic">
                            </div>

                            <div>
                                <h3>{{$singleNotification->title}}</h3>
                                <p class="mt-3">{!! $singleNotification->body !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Create Ticket end-->
    </div>

@endsection

@push('script')
    <script src="{{asset('agent/assets/js/custom/notification.js')}}"></script>
@endpush
