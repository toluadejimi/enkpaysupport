@extends('tenant.layouts.app')
@push('title')
    {{ __($page?->title) }}
@endpush
@section('content')

    <div class="breadcrumb-bg-area hero-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text-bg">
                        <h2>{{__("Terms Of Use")}}</h2>
                        <div class="breadcrumb-items">
                            <li><a href="{{ route('frontend') }}">{{__("Home")}}</a></li>
                            <li>/</li>
                            <li><a href="">{{__("Terms Of Use")}}</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area start here  -->
    <!-- breadcrumb area end here  -->
    <section class="section-space">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="single-policy-info">
                        @if ($page?->description)
                            {!! $page?->description !!}
                        @else
                            <p class="text-center">{{__("No Data Found!")}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
