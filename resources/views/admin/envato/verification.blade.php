@extends('admin.layouts.app')
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
                <div class="col-12">
                    <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                        <div class="item-top mb-30">
                            <h2>{{ $pageTitle }}</h2>
                        </div>

                        <form class="ajax" action="{{route('admin.envato.license-verification-action')}}" method="POST"
                              enctype="multipart/form-data" data-handler="licenseVerificationHandler">
                            @csrf
                            <div class="row">
                                <label class="form-label">{{__('Envato License')}} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <div class="col-xxl-10 col-lg-10 mb-10">
                                        <input type="text" name="envato_license" class="form-control" required>
                                    </div>
                                    <div class="col-xxl-2 col-lg-2 mb-2">
                                        <div class="input-group-append">
                                            <button type="submit"
                                                    class="btn btn-primary btn-large ml-10">{{__('Verify')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-xxl-8 col-lg-8 mb-8" >
                                <div id="envatoData">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
    <!-- Configuration section start -->
    <div class="modal fade main-modal" id="configureModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- Configuration section end -->
    <!-- Help section start -->
    <div class="modal fade main-modal" id="helpModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- Help section end -->

@endsection
@push('script')
    <script src="{{ asset('admin/js/custom/envato_configuration.js') }}"></script>
@endpush
