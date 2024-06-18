@extends('frontend.layouts.app')
@push('title')
    {{ __('Contact Us') }}
@endpush
@section('content')

    <div class="breadcrumb-bg-area hero-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text-bg">
                        <h2>{{__("Contact Us")}}</h2>
                        <div class="breadcrumb-items">
                            <li><a href="{{ route('frontend') }}">{{__("Home")}}</a></li>
                            <li>/</li>
                            <li>{{__("Contact Us")}}</li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-page-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-form">
                        <h2>{{__('Send Us Message')}}</h2>
                        @if (session('message'))
                            <div class="alert alert-success mb-3"> {{ session('message') }}</div>
                        @endif
                        <form action="{{ route('contact.us.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="created_by" value="{{getUserIdByTenant()}}">

                                <div class="col-md-6">
                                    <div class="contact-input mb-5 pb-3">
                                        <label for="name">{{__("Your Name")}}</label>
                                        <input value="{{old('name')}}" type="text" class="mb-0 form-control" id="name" name="name"
                                               placeholder="{{ __("Your Name") }}">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-input mb-5 pb-3">
                                        <label for="email">{{__('Your Email')}}</label>
                                        <input value="{{old('email')}}" type="email" class="mb-0 form-control" id="email" name="email"
                                               placeholder="{{ __('Your Email') }}">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-input mb-5 pb-3">
                                        <label for="phone">{{__('Phone Number')}}</label>
                                        <input value="{{old('phone')}}" type="text" class="mb-0 form-control" id="phone" name="phone"
                                               placeholder="{{ __('Phone Number') }}">
                                        @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-input mb-5 pb-3">
                                        <label for="subject">{{__('Your Subject')}}</label>
                                        <input value="{{old('subject')}}" type="text" class="mb-0 form-control" id="subject" name="subject"
                                               placeholder="{{ __("Your Subject") }}">
                                        @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="contact-input">
                                        <label for="massage">{{__('Write Your Message')}}</label>
                                        <textarea value="{{old('message')}}" class="mb-0 form-control message-box" name="message" id="message" cols="30"
                                                  rows="6" placeholder="{{ __('Enter Your Message') }}"></textarea>
                                        @error('message')
                                        <span class="text-danger ">{{ $message }}</span>
                                        @enderror
                                        <br>
                                        <button class="mt-5" type="submit">{{__('Send massage')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-icon">
                        <div class="single icon-contact">
                            <div>
                                <img src="{{asset('frontend')}}/assets/images/email.png" alt="">
                            </div>
                            <h4>{{__('Send Us Email')}}
                            </h4>
                            @if($contactUs)
                                <p>{{ $contactUs->app_email }}</p>
                            @else
                                <p>{{__('No email found')}}</p>
                            @endif
                        </div>
                        <div class="single icon-contact">
                            <div>
                                <img src="{{asset('frontend')}}/assets/images/phone.png" alt="">
                            </div>
                            <h4>{{__('call us now')}}</h4>
                            @if($contactUs)
                                <p>{{$contactUs->app_contact_number}}</p>
                            @else
                                <p>{{__('No Contect Number Found')}}</p>
                            @endif
                        </div>
                        <div class="single icon-contact">
                            <div>
                                <img src="{{asset('frontend')}}/assets/images/loacation.png" alt="">
                            </div>
                            <h4>{{__('office location')}}
                            </h4>
                            @if($contactUs)
                                <p>{{$contactUs->app_location}}</p>
                            @else
                                <p>{{__('No Location Found')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
