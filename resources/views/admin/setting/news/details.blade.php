@extends('user.layouts.app')
@push('title')
    {{ __('Welcome') }}
@endpush
@push('style')
@endpush
@section('content')
    <main class="home-page">


        <!-- Get In Touch Area Start -->
        <section class="news-and-article-area section-t-space section-b-115-space bg-white">
            <div class="container">

                <!-- Section Heading Start -->
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h2 class="section-heading">{{__("News Details")}}</h2>
                        </div>
                    </div>
                </div>
                <!-- Section Heading End -->
                <hr>
                <!-- Blog Items Area Start -->
                <div class="row blog-items-area">
                    <div class="col-lg-4">
                        <img src="{{getFileUrl($news->image)}}" alt="" class="blog-item-img radius-10 fit-image">

                    </div>

                    <div class="col-lg-8">
                        <div class="blog-item-content flex-grow-1 ms-3 mt-20">
                            <span
                                class="blog-publish-date d-inline-flex justify-content-center bg-green-transparent green-color px-2 py-1 radius-3">{{date('M d, Y', strtotime($news->created_at))}}</span>
                            <h4 class="blog-title mt-25">{{ $news->title }}</h4>
                            <p class="section-sub-heading mt-20">{{ $news->description }}</p>
                        </div>

                    </div>

                </div>
                <!-- Blog Items Area End -->

            </div>
        </section>
        <!-- Get In Touch Area End -->

        <!-- Footer Start -->
        @include('frontend.layouts.footer')
        <!-- Footer End -->

    </main>
@endsection

@push('script')
@endpush
