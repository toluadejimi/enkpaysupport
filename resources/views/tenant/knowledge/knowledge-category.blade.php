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
                        <h2>{{__("Knowledge Category")}}</h2>
                        <div class="breadcrumb-items">
                            <li><a href="{{ route('frontend') }}">{{__("Home")}}</a></li>
                            <li>/</li>
                            <li><a href="{{ route('tenant.knowledge') }}">{{__("Knowledge")}}</a></li>
                            <li>/</li>
                            <li><a href=""  class="active"> {{__('Knowledge Category')}}</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- hero area end -->

    <section class="category-started">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="category-started-title">
                        <h2>{{ $categoryDetails->title }}
                            <span>({{ $knowledgeByCategory->count() }} {{ __('Articles') }})</span>
                        </h2>
                        <p>{{ $categoryDetails->description }}</p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="all-category-area">
                        <form action="{{route('tenant.searchKnowledge.details', $categoryDetails->id)}}" method="get" class="search-form cate ">
                            <div class="search-box">
                                <input type="search" name="query" placeholder="{{ __('Search') }}">
                                <button class="secrch-btu">{{__('Search Here')}}</button>
                            </div>
                        </form>
                    </div>
                    <div class="category-text">
                        @if(empty($searchKnowledge))
                            @foreach($knowledgeByCategory as $knowledges)
                                <div class="single-category">
                                    <h3><a href="{{route('tenant.knowledge-category-single', $knowledges->id)}}">{{$knowledges->title}}</a></h3>
                                    <p class="category-date">
                                        {{__('Views')}}: {{$knowledges->user_count}}</p>
                                    <h4>{!! substr(strip_tags($knowledges->description), 0,  120).'...' !!} </h4>
                                </div>
                            @endforeach
                        @else
                            @forelse ( $searchKnowledge as $knowledges)
                                <div class="single-category">
                                    <h3><a href="{{route('tenant.knowledge-category-single', $knowledges->id)}}">{{$knowledges->title}}</a></h3>
                                    <p class="category-date">
                                        {{__('Views')}}: {{$knowledges->user_count}}</p>
                                    <h4>{!! substr(strip_tags($knowledges->description), 0,  120).'...' !!} </h4>
                                    @empty
                                        <div class="text-danger text-center"><h3>{{__('No data match')}}</h3></div>
                                </div>
                            @endforelse
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="category-support">
                        <div class="category-support-text">
                            <h3>{{__("looking for Support?")}}</h3>
                            <p>{{__("Can't find the answer you're looking for?
                                Don't worry we're here to solve your
                                softtware problem!")}}</p>
                            <button>{{__("contact support")}}</button>
                        </div>
                        <div class="category-support-img">
                            <img src="{{asset('frontend')}}/assets//images/OBJECTS .png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="knowledge-area bg-white">
        <!-- title area start -->

        <div class="title-area">
            <div class="container">
                <div class="row">
                    <div class="title-text">
                        <h2>{{__('Some of related categories')}}</h2>
                        <p>{{__('Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam')}} <br>
                            {{__('voluptatem quia voluptas sit aspernatur aut odit fugit')}} </p>
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
                                <div class="knowledge-part ">
                                    <div class="knowledge-icon flex-shrink-0">
                                        <img src="{{ asset('frontend/assets/images/start-ic.png') }}" alt="">
                                    </div>
                                    <div class="knowledge-title">
                                        <h4>{{ $knowledgeCategorys->title }}<span class="number">({{ $knowledgeCategorys->knowledge->count() }})</span>
                                        </h4>
                                        <p>{{ substr(strip_tags($knowledgeCategorys->description), 0,  80) }}</p>
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
@endsection
