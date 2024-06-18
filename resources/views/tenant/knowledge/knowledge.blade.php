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
                        <h2>{{__('knowledge')}}</h2>
                        <div class="breadcrumb-items">
                            <li><a href="{{route('frontend')}}">{{__('Home')}}</a></li>
                            <li>/</li>
                            <li><a href="" class="active">{{__('knowledge')}}</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- hero area end -->


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
                            <input type="search" name="query" placeholder="{{__("Search for questions or topics...")}}">
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


                        @if(empty($searchKnowledgeCategory))

                            @foreach($knowledgeCategory as $knowledgeCategorys)
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

                        @else

                            @forelse ( $searchKnowledgeCategory as $knowledges)

                                <div class="col-lg-6 mb-4">
                                    <div class="single-knowledge-box">
                                        <div class="knowledge-part">
                                            <div class="knowledge-icon flex-shrink-0">
                                                <img src="{{ asset('frontend/assets/images/start-ic.png') }}" alt="">
                                            </div>
                                            <div class="knowledge-title">
                                                <h4>{{ $knowledges->category_title }}
                                                </h4>
                                                <p>{{ substr($knowledges->category_desc, 0,  80) }}</p>
                                            </div>
                                        </div>
                                        <div class="knowledge-list">
                                            <ul>
                                                <li>
                                                    <div class=" flex-shrink-0">
                                                        <img
                                                            src="{{ asset('frontend/assets/images/pase-icon.png') }}"
                                                            alt="">
                                                    </div>
                                                    <a class="knowledge-title-link" href="{{route('tenant.knowledge-category-single', $knowledges->id)}}">{{ $knowledges->title }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="{{ route('tenant.knowledge-category', $knowledges->category_id) }}">{{ __('Explore More') }}
                                            <i class="fa-solid fa-arrow-right-long"></i></a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-danger text-center mb-5"><h3>{{__('No data match')}}</h3></div>
                            @endforelse

                        @endif


                        @if($lookingSupport['looking_support_area'] != null && $lookingSupport['looking_support_area']->status==STATUS_ACTIVE)
                            <div class="col-lg-6">
                                <div class="single-knowledge-support">
                                    <h3>{{$lookingSupport['looking_support_area']->title}}</h3>
                                    <p>{{$lookingSupport['looking_support_area']->description}}</p>
                                    <button><a class="text-white"
                                               href="{{route('tenant.contact.us.index')}}">{{__('Contact Support')}}</a>
                                    </button>
                                    <div class="single-knowledge-support-img">
                                        <img src="{{asset('frontend')}}/assets//images/OBJECTS .png" alt="">
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
