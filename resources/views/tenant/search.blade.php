@extends('tenant.layouts.app')
@push('title')
    {{ __('FAQ') }}
@endpush
@section('content')

    <div class="breadcrumb-bg-area hero-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text-bg">
                        <h2>{{__($pageTitle)}}</h2>
                        <div class="breadcrumb-items">
                            <li><a href="{{ route('frontend') }}">{{__("Home")}}</a></li>
                            <li>/</li>
                            <li>{{__($pageTitle)}}</li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Frequently Asked Questions are start -->

    <section class="frequent-question-area">
        <!-- title area start -->
        <div class="title-area">
            <div class="container">
                <div class="row">
                    <div class="title-text">

                    </div>
                </div>
            </div>
        </div>
        <!-- title area end -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 ">
                    @if(count($faqs)>0)
                    <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                 aria-labelledby="nav-home-tab">

                                <div class="frequent-accordion">
                                    <div class="accordion" id="accordionExample1">
                                        @foreach($faqs as $key2 => $faq)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse{{$key2}}"
                                                                aria-expanded="{{$key2==0?'true':'false'}}"
                                                                aria-controls="collapse{{$key2}}">
                                                            {{$faq->question}}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{$key2}}" class="accordion-collapse collapse {{ ($key2 === 0) ? 'show' : '' }}"
                                                         data-bs-parent="#accordionExample1">
                                                        <div class="accordion-body">
                                                            {{$faq->answer}}
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>




                    </div>
                    @else
                        <h3 class="text-center"><i class="fa fa-meh text-dark"></i> No Data Found!</h3>
                    @endif
                </div>
            </div>
        </div>

    </section>

    <!-- Frequently Asked Questions are end -->
@endsection
