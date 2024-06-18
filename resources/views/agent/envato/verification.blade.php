@extends('agent.layouts.app')
@push('title')
    {{ __('Profile') }}
@endpush

@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
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


            <!-- profile information start-->

            <section>
                <div class="container-fluid">
                    <div class="profile-info">
                        <div class="row">
                                    <form class="form-horizontal ajax" action="{{route('agent.envato.license-verification-action')}}" method="POST"
                                          enctype="multipart/form-data" data-handler="licenseVerificationHandler">
                                        @csrf
                                    <div class="row align-items-end row-gap-4">
                                            <div class="col-md-8 col-lg-10 mb-25">
                                                <div class="user-info-from mb-0">
                                                    <label class="label-text-title">{{__('Envato License')}}
                                                        <span>*</span></label>
                                                    <input type="text" name="envato_license" class="formControl" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-2 mb-25">
                                                <button type="submit"
                                                        class="py-13 submit-btu">{{__("Verify")}}</button>
                                            </div>
                                        </div>
                                </form>
                        </div>
                        <div class="row">
                            <div class="col-xxl-8 col-lg-8 mb-8" >
                                <div id="envatoData">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>


        <!-- profile information end-->
    </div>
    </div>

@endsection
@push('script')
    <script src="{{ asset('agent/assets/js/custom/envato_configuration.js') }}"></script>
@endpush
