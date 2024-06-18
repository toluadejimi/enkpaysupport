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
                        <h2>{{__("Faq's")}}</h2>
                        <div class="breadcrumb-items">
                            <li><a href="{{ route('frontend') }}">{{__("Home")}}</a></li>
                            <li>/</li>
                            <li><a href="" class="active">{{__("Faq")}}</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Frequently Asked Questions are start -->


    @if (count($faqCategory) > 0)

        <section class="frequent-question-area">
            <!-- title area start -->
            <div class="title-area">
                <div class="container">
                    <div class="row">
                        <div class="title-text">
                            <h2>{{$section->title}}</h2>
                            <p>{{$section->description}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- title area end -->
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="navigation-part">
                        <h3>{{__('Quick Navigation')}}</h3>
                        <div class="navigation-button">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($faqCategory as $key => $faqCategorys)
                                        <button class="nav-link {{$key==0?'active':''}}" id="nav-{{$key}}-tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#nav-{{$key}}" type="button" role="tab"
                                                aria-controls="nav-{{$key}}"
                                                aria-selected="{{$key==0?'true':'false'}}">{{$faqCategorys->title}}</button>
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
        </section>

    @else
        <div class="text-center py-5 my-5"><h3>No Data found</h3></div>
    @endif


  <!-- Frequently Asked Questions are end -->
@endsection
