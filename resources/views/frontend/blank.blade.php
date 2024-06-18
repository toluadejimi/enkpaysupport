@extends('tenant.layouts.app')
@push('title')
    @if (isset($pageData->title))
        {{ $pageData->title }}
    @else
        {{ __("Blank Page") }}
    @endif
@endpush
@section('content')

    <div class="breadcrumb-bg-area hero-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text-bg">
                        <h2>{{ isset($pageData->title)?$pageData->title:'' }}</h2>
                        <div class="breadcrumb-items">
                            <li><a href="{{ route('frontend') }}">{{__("Home")}}</a></li>
                            <li>/</li>
                            <li>{{ isset($pageData->title)?$pageData->title:'' }}</li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- faq start -->

    <!-- Frequently Asked Questions are start -->
    <section class="section-space blank-page-section" >
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="single-policy-info">
                        @if (isset($pageData->desc))
                            {!! $pageData->desc !!}
                        @else
                            {{__("No Data Found!")}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Frequently Asked Questions are end -->
    <!-- faq area end -->
@endsection
