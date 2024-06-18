@extends('tenant.layouts.app')
@push('title')
    {{ __($page->title) }}
@endpush
@section('content')
 <!-- breadcrumb area start here  -->
 <section class="breadcrumb-area section-bg-img">
    <div class="contaier">
        <div class="text-center">
            <h2 class="page-title">{{ __($page->title) }}</h2>
            <ul class="breadcrumb-items">
                <li><a href="{{ route('frontend') }}">{{ __("Home") }}</a></li>
                <li>{{ __($page->title) }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- breadcrumb area end here  -->
<section class="section-space">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="single-policy-info">
                    @if ($page->description)
                        {!! $page->description !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
