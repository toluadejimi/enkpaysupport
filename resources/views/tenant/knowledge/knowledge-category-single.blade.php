@extends('tenant.layouts.app')
@push('title')
    {{ __('Welcome') }}
@endpush
@section('content')
    <!-- hero area start -->
    <div class="breadcrumb-bg-area hero-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text-bg">
                        <h2>{{__('Knowledge Category Details')}}</h2>
                        <div class="breadcrumb-items category-block">
                            <li><a href="{{route('frontend')}}">{{__('home')}}</a></li>
                            <li>/</li>
                            <li><a href="{{ route('tenant.knowledge') }}">{{__('knowledge')}}</a></li>
                            <li>/</li>
                            <li><a href="{{ route('tenant.knowledge-category', $knowledgeDetails->id) }}"> {{__('knowledge Category')}}</a></li>
                            <li>/</li>
                            <li><a href="" class="active"> {{__('knowledge Category Details')}}</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- hero area end -->
    <!-- category getting started area start -->

    <section class="category-started">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="category-started-title">
                        <h2>{{$knowledgeDetails->title}}</h2>

                        <div class="category-started-icon">
                            <li>
                                <div><img src="{{asset('frontend')}}/assets//images/Calendar.svg" alt=""></div>
                                <span>{{ $knowledgeDetails->created_at->formatLocalized('%d-%B-%Y') }}</span>
                            </li>
                            <li>
                                <div><img src="{{asset('frontend')}}/assets//images/Clipboard List.svg" alt=""></div>
                                <span>{{$knowledgeDetails->category_title}}</span>
                            </li>
                            <li>
                                <div><img src="{{asset('frontend')}}/assets//images/view.svg" alt=""></div>
                                <span>{{$knowledgeDetails->user_count}}</span>
                            </li>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">

                    <div class="single-category-deities">
                        {!! $knowledgeDetails->description !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="category-support">
                        <div class="category-support-text">
                            <h3>{{__('looking for Support?')}}</h3>
                            <p>{{__("Can't find the answer you're looking for?
                                Don't worry we're here to solve your
                                softtware problem!")}}</p>
                            <button>{{__('contact support')}}</button>
                        </div>
                        <div class="category-support-img">
                            <img src="{{asset('frontend')}}/assets//images/OBJECTS .png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- category getting started area end -->
    <!-- knowledge area start -->
    <section class="knowledge-area bg-white">
        <!-- title area start -->

        <div class="title-area">
            <div class="container">
                <div class="row">
                    <div class="title-text">
                        <h2>{{__('Some of related categories')}}</h2>
                        <p>{{__("Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam
                            voluptatem quia voluptas sit aspernatur aut odit fugit")}} </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- title area end -->

        <!-- knowledge text area start -->

        <div class="knowledge-text category-pd">
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
                                        <h4>{{ $knowledgeCategorys->title }}<span class="number">({{ $knowledgeCategorys->knowledge->count() }})</span>
                                        </h4>
                                        <p>{{ substr($knowledgeCategorys->description, 0,  80) }}</p>
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
                                                    {{ $knowledges->title }}
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
                </div>
            </div>
        </div>


    </section>
    <!-- knowledge text area end -->
@endsection
