@extends('frontend.layouts.app')

@push('title')
    {{ __('Welcome') }}
@endpush
@section('content')
    <!-- hero area start -->
    @if($section['hero_banner'] != null && $section['hero_banner']->status==STATUS_ACTIVE)
        <section class="hero-area all-top">
            <div class="coustom-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="hero-text">
                            <h2>{{__($section['hero_banner']->title)}}</h2>
                            <p>{{__($section['hero_banner']->description)}}</p>
                            <div class="d-flex justify-content-center align-items-center column-gap-3 row-gap-3">
                                @if (isAddonInstalled('DESKSAAS') > 0)
                                    <a href="{{route('pricing')}}" class="down-btu-2 ">Pricing</a>
                                @endif
                                <a href="{{route('login')}}" class="down-btu-3 ">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- hero area end -->

    <!-- logical area start -->
    @if($section['features_area'] != null && $section['features_area']->status == STATUS_ACTIVE)
        <section class="logical-area">
            <div class="container">
                <div class="row">
                    <div class="offset-lg-1 col-lg-10">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="logical-text">
                                    <h2>{{__($section['features_area']->title)}}</h2>
                                    <p>{{__($section['features_area']->description)}}</p>
                                    <div class="logical-single-box">
                                        <div class="logical-icon">
                                            <img
                                                src="{{ asset(getFileUrl(count($featureObj)>0?$featureObj[0]->icon:null)) }}"
                                                alt="">
                                        </div>
                                        <h3>{{__(count($featureObj)>0?$featureObj[0]->title:null)}}</h3>
                                        <p>{{__(count($featureObj)>0?$featureObj[0]->description:null)}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="logical-single-box">
                                    <div class="logical-icon">
                                        <img src="{{asset(getFileUrl(count($featureObj)>1?$featureObj[1]->icon:null))}}"
                                             alt="">
                                    </div>
                                    <h3>{{__(count($featureObj)>1?$featureObj[1]->title:null)}}</h3>
                                    <p>{{__(count($featureObj)>1?$featureObj[1]->description:null)}}</p>
                                </div>
                                <div class="logical-single-box">
                                    <div class="logical-icon">
                                        <img src="{{asset(getFileUrl(count($featureObj)>2?$featureObj[2]->icon:null))}}"
                                             alt="">
                                    </div>
                                    <h3>{{__(count($featureObj)>2?$featureObj[2]->title:null)}}</h3>
                                    <p>{{__(count($featureObj)>2?$featureObj[2]->description:null)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if($section['testimonial_area'] != null && $section['testimonial_area']->status==STATUS_ACTIVE)
        <section class="user-area">
            <!-- title area start -->
            <div class="title-area">
                <div class="container">
                    <div class="row">
                        <div class="title-text">
                            <h2>{{__($section['testimonial_area']->title)}}</h2>
                            <p>{{__($section['testimonial_area']->description)}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- title area end -->
            <!--  user slider start -->
            <div class="user-review">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="user-box owl-carousel">
                                @foreach($testimonial as $testimonials)
                                    <div class="single-slider">
                                        <div class="review">
                                            @for ($i = 0; $i < $testimonials->star; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor
                                            @for ($i = 0; $i < (5 - $testimonials->star); $i++)
                                                <i class="fa-regular fa-star"></i>
                                            @endfor
                                        </div>
                                        <p>{{__($testimonials->comment)}}</p>
                                        <div class="user-info">
                                            <h2>{{__($testimonials->name)}}</h2>
                                            <p>{{__($testimonials->designation)}}</p>

                                            <div class="user-logo">
                                                <img src="{{ asset(getFileUrl($testimonials->logo)) }}" alt="">
                                            </div>
                                        </div>
                                        <div class="user-img">
                                            <img src="{{ asset(getFileUrl($testimonials->image)) }}" alt="">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  user slider end -->
        </section>
    @endif
    <!-- logical area end -->
    <!-- Frequently Asked Questions are start -->
    @if($section['faq_area'] != null && $section['faq_area']->status==STATUS_ACTIVE)
        <section class="frequent-question-area">
            <!-- title area start -->
            <div class="title-area">
                <div class="container">
                    <div class="row">
                        <div class="title-text">
                            <h2>{{__($section['faq_area']->title)}}</h2>
                            <p>{{__($section['faq_area']->description)}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- title area end -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="navigation-part">
                            @if (count($faqCategories) > 0)
                                <h3>{{__('Quick Navigation')}}</h3>
                            @endif
                            <div class="navigation-button">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        @foreach($faqCategories as $key => $faqCategory)
                                            <button class="nav-link {{$key==0?'active':''}}" id="nav-{{$key}}-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#nav-{{$key}}" type="button" role="tab"
                                                    aria-controls="nav-home"
                                                    aria-selected="true">{{$faqCategory->title}}
                                            </button>
                                        @endforeach
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="tab-content" id="nav-tabContent">
                            @foreach($faqCategories as $key => $faqCategory)
                                <div class="tab-pane fade {{ ($key === 0) ? 'show active' : '' }}" id="nav-{{$key}}"
                                     role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="frequent-accordion">
                                        <div class="accordion" id="accordionExample{{$key}}">
                                            @foreach($faqs as $key=> $faq)
                                                @if($faq->faq_category_id == $faqCategory->id)
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapse{{$key}}-{{$faq->id}}"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapse{{$key}}-{{$faq->id}}">

                                                                {{ __($faq->question) }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapse{{$key}}-{{$faq->id}}"
                                                             class="accordion-collapse collapse"
                                                             data-bs-parent="#accordionExample{{$key}}">
                                                            <div class="accordion-body">
                                                                {{ __($faq->answer) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Frequently Asked Questions are end -->
@endsection
