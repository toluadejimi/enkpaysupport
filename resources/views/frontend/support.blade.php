@extends('tenant.layouts.app')
@push('title')
    {{ __('Support') }}
@endpush
@section('content')
    <!-- Page Banner Area Start -->

    <!-- Inner Page Details Area Start -->
    <section class="inner-page-details contact-us-page section-t-space section-b-115-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h2 class="section-heading">{{__('Support')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="inner-page-content contact-us-page-content bg-white theme-border">
                        @if ($support)
                        <a href="{{ $support }}" target="_blank">{{__("Click Here - ")}}{{ $support }}</a>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layouts.footer')
    <!-- Inner Page Details Area End -->
@endsection
@push('script')
@endpush
