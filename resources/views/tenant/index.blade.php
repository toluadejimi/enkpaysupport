@extends('tenant.layouts.app')
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
                        <form method="get" action="{{route('tenant.search')}}" class="search-form mx-2">
                            <div class="search-box">
                                <input type="search" name="search" placeholder="{{__("Search for questions or topics...")}}">
                                <button type="submit" class="secrch-btu">{{("Search Here")}}</button>
                            </div>
                        </form>
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



<!--knowledge area start -->

@if ($section['knowledge_area'] != null && $section['knowledge_area']->status==STATUS_ACTIVE)
    <section class="knowledge-area">
        <!-- title area start -->
        <div class="title-area">
            <div class="container">
                <div class="row">
                    <div class="title-text">
                        <h2>{{$section['knowledge_area']->title}}</h2>
                        <p>{{$section['knowledge_area']->description}} </p>
                    </div>
                </div>

                <form action="{{route('tenant.searchKnowledge')}}" type="get" class="search-form bread ">
                    <div class="search-box">
                        <input type="search" name="query" placeholder="{{ __('Search') }}">
                        <button class="secrch-btu">{{__('Search Here')}}</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- title area end -->

        <!-- knowledge text area start -->
        <div class="knowledge-text pb-5">
            <div class="container">
                <div class="row">
                    @foreach($knowledgeCategory as $key => $knowledgeCategorys)
                        <div class="col-lg-6 mb-4">
                            <div class="single-knowledge-box">
                                <div class="knowledge-part">
                                    <div class="knowledge-icon flex-shrink-0">
                                        <img src="{{ asset('frontend/assets/images/start-ic.png') }}" alt="">
                                    </div>
                                    <div class="knowledge-title">
                                        <h4>{{ $knowledgeCategorys->title }}<span class="number ps-2">({{ $knowledgeCategorys->knowledge->count() }})</span>
                                        </h4>
                                        <p>{{ substr($knowledgeCategorys->description, 0,  150) }}</p>
                                    </div>
                                </div>
                                <div class="knowledge-list">
                                    <ul>
                                        @foreach($knowledge as $knowledges)
                                            @if($knowledges->knowledge_category_id == $knowledgeCategorys->id)
                                                <li>
                                                    <div class=" flex-shrink-0">
                                                        <img
                                                            src="{{ asset('frontend/assets/images/pase-icon.png') }}"
                                                            alt="">
                                                    </div>
                                                    <a class="knowledge-title-link" href="{{route('tenant.knowledge-category-single', $knowledges->id)}}">{{ $knowledges->title }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <a href="{{ route('tenant.knowledge-category', $knowledgeCategorys->id) }}">{{ __('Explore More') }}
                                    <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-lg-6">
                        <div class="single-knowledge-support">
                            <h3>{{$section['looking_support_area']->title}}</h3>
                            <p>{{$section['looking_support_area']->description}}</p>
                            <button><a class="text-white" href="{{route('tenant.contact.us.index')}}">Contact Support</a></button>
                            <div class="single-knowledge-support-img">
                                <img src="{{asset('frontend')}}/assets//images/OBJECTS .png" alt="">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endif
<!-- knowledge area end-->


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
                        @if (count($faqCategory) > 0)
                            <h3>{{__('Quick Navigation')}}</h3>
                        @endif
                        <div class="navigation-button">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($faqCategory as $key => $faqCategorys)
                                        <button class="nav-link {{$key==0?'active':''}}" id="nav-{{$key}}-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#nav-{{$key}}" type="button" role="tab"
                                            aria-controls="nav-home"
                                            aria-selected="true">{{$faqCategorys->title}}
                                        </button>
                                    @endforeach
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="tab-content" id="nav-tabContent">

                        @foreach($faqCategory as $key=> $cate_item)
                        @php $category_faq_counter = 0; @endphp
                            <div class="tab-pane fade show {{$key==0?'active':''}}" id="nav-{{$key}}" role="tabpanel"
                                 aria-labelledby="nav-{{$key}}-tab">

                                 <div class="frequent-accordion">
                                    <div class="accordion" id="accordionExample{{$key}}">
                                        @foreach($faqs as $key2 => $faq)
                                            @if($cate_item->id == $faq->faq_category_id )
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button {{$category_faq_counter==0?'':'collapsed'}}" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse{{$key2}}"
                                                                aria-expanded="{{$category_faq_counter==0?'true':'false'}}"
                                                                aria-controls="collapse{{$key2}}">
                                                            {{$faq->question}}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{$key2}}" class="accordion-collapse collapse {{ ($category_faq_counter === 0) ? 'show' : '' }}"
                                                         data-bs-parent="#accordionExample{{$key}}">
                                                        <div class="accordion-body">
                                                            {{$faq->answer}}
                                                        </div>
                                                    </div>
                                                </div>
                                                @php $category_faq_counter = $category_faq_counter + 1; @endphp
                                                @else
                                                @php $category_faq_counter = 0; @endphp
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

    <!-- support houre area start -->
    @if($section['need_support_area'] != null && $section['need_support_area']->status==STATUS_ACTIVE)
    <section class="support-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="support-bg">
                        <h2>{{__($section['need_support_area']->title)}}</h2>
                        <p>{{__($section['need_support_area']->description)}}</p>
                        <button class="mt-5"><a class="text-white" href="{{route('ticket.guest-create-ticket')}}">{{__("open ticket")}}</a></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- support houre area end -->


@endsection
