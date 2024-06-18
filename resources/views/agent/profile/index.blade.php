@extends('agent.layouts.app')
@push('title')
    {{ __('Profile') }}
@endpush

@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush

@section('content')
    <!-- Right Content Start -->
    <div class="main-content">
        <div class="page-content">
            <!-- dashboard area start -->

            <section class="dashboard-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dashboard-box">
                                <div class="title-area">
                                    <div class="dashboard-text">
                                        <h2>{{__("Profile Setting")}}</h2>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- dashboard area end -->


            <!-- profile information start-->

            <section>
                <div class="container-fluid">
                    <div class="profile-info">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="set-password">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link mr-1 user-btu active mb-3" id="pills-coustomer-tab"
                                                    data-bs-toggle="pill"
                                                    data-bs-target="#pills-coustomer" type="button" role="tab"
                                                    aria-controls="pills-coustomer"
                                                    aria-selected="true">{{__("Profile Information")}}
                                            </button>
                                        </li>
                                        <li class="nav-item " role="presentation">
                                            <button class="nav-link user-btu mb-3" id="pills-coustomer-2-tab"
                                                    data-bs-toggle="pill"
                                                    data-bs-target="#pills-coustomer-2" type="button" role="tab"
                                                    aria-controls="pills-coustomer-2"
                                                    aria-selected="false">{{__("Password")}}
                                            </button>
                                        </li>

                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-coustomer" role="tabpanel"
                                     aria-labelledby="pills-coustomer-tab">
                                    <div class="col-md-12">
                                        <div class="user-set-info">
                                            <form action="{{route('agent.profile.update')}}" method="post"
                                                  class="form-horizontal" enctype="multipart/form-data">
                                                @csrf

                                                <div class="col-12">
                                                    <!-- Upload Profile Photo Box Start -->
                                                    <div class="upload-profile-photo-box ">
                                                        <div class="img-area">
                                                            <div class="profileImgpart">
                                                                <img id="blah"
                                                                     src="{{ getFileUrl(auth()->user()->image) }}"
                                                                     alt="your image"/>
                                                                <span>

                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                                     fill="none">
                                  <circle cx="15" cy="15" r="14.5" fill="#6659FF" stroke="white"/>
                                  <path
                                      d="M15.0005 18.2C16.1787 18.2 17.1339 17.2449 17.1339 16.0667C17.1339 14.8885 16.1787 13.9334 15.0005 13.9334C13.8223 13.9334 12.8672 14.8885 12.8672 16.0667C12.8672 17.2449 13.8223 18.2 15.0005 18.2Z"
                                      fill="white"/>
                                  <path
                                      d="M19.2664 11.2667H18.0824L17.8531 10.344C17.7663 9.99812 17.5665 9.69113 17.2853 9.47178C17.0041 9.25244 16.6577 9.13333 16.3011 9.13335H13.6984C13.3418 9.13333 12.9954 9.25244 12.7142 9.47178C12.433 9.69113 12.2332 9.99812 12.1464 10.344L11.9171 11.2667H10.7331C10.0258 11.2667 9.34755 11.5476 8.84745 12.0477C8.34736 12.5478 8.06641 13.2261 8.06641 13.9333V18.2C8.06641 18.9073 8.34736 19.5855 8.84745 20.0856C9.34755 20.5857 10.0258 20.8667 10.7331 20.8667H19.2664C19.9737 20.8667 20.6519 20.5857 21.152 20.0856C21.6521 19.5855 21.9331 18.9073 21.9331 18.2V13.9333C21.9331 13.2261 21.6521 12.5478 21.152 12.0477C20.6519 11.5476 19.9737 11.2667 19.2664 11.2667ZM14.9997 19.2667C14.3668 19.2667 13.7482 19.079 13.2219 18.7274C12.6957 18.3758 12.2855 17.876 12.0433 17.2913C11.8011 16.7065 11.7378 16.0631 11.8612 15.4424C11.9847 14.8217 12.2895 14.2515 12.737 13.8039C13.1845 13.3564 13.7547 13.0516 14.3755 12.9282C14.9962 12.8047 15.6396 12.8681 16.2243 13.1103C16.8091 13.3525 17.3088 13.7626 17.6604 14.2889C18.0121 14.8151 18.1997 15.4338 18.1997 16.0667C18.1997 16.9154 17.8626 17.7293 17.2625 18.3294C16.6624 18.9295 15.8484 19.2667 14.9997 19.2667Z"
                                      fill="white"/>
                                  </svg>
                              </span>
                                                            </div>
                                                            <input type='file' id="imgInp" name="profile_image"
                                                                   class="d-none"/>
                                                            <label for="imgInp">{{__("Change Image")}}</label>

                                                        </div>

                                                    </div>

                                                    <!-- Upload Profile Photo Box End -->
                                                </div>
                                                <div class="ticketReview-text-icon">
                                                    <div class="">
                                                    @php
                                                    if( getAgentRatingById(Auth::id())['rating_avg'] > 0 ){
                                                    $rating = round(getAgentRatingById(Auth::id())['rating_avg']);
                                                    }
                                                @endphp
                                                @if(!empty($rating))
                                                    <div class="rating-view-container">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    @if($i<=$rating)
                                                        <div class="rating-view-select">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                        @else
                                                        <div class="rating-view-init">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                        @endif
                                                    @endfor
                                                    </div>
                                                    @else
                                                @endif
                                            </div>
                                        </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5 mb-25">
                                                        <div class="user-info-from">
                                                            <label class="label-text-title">{{__("Full Name")}}
                                                                <span>*</span></label>
                                                            <input type="text" class="formControl"
                                                                   placeholder="{{__("Full Name")}}" name="name"
                                                                   value="{{Auth::user()->name}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 mb-25">
                                                        <div class="user-info-from">
                                                            <label class="label-text-title">{{__("User Name")}}
                                                                <span>*</span></label>
                                                            <input type="text" name="username" class="formControl"
                                                                   placeholder="{{__("User Name")}}"
                                                                   value="{{Auth::user()->username}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 mb-25">
                                                        <div class="user-info-from">
                                                            <label class="label-text-title">{{__("Email address")}}
                                                                <span>*</span></label>
                                                            <input type="text" class="formControl"
                                                                   placeholder="{{__("Email address")}}" name="email"
                                                                   value="{{Auth::user()->email}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 mb-25">
                                                        <div class="user-info-from">
                                                            <label class="label-text-title">{{__("Phone Number")}}<span>*</span></label>
                                                            <input type="tel" class="formControl"
                                                                   placeholder="{{__("Phone Number")}}" name="mobile"
                                                                   value="{{Auth::user()->mobile}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 mb-25">
                                                        <div class="user-info-from">
                                                            <label class="label-text-title">{{__("Location")}}
                                                                <span>*</span></label>
                                                            <input type="text" class="formControl"
                                                                   placeholder="{{__("Location")}}" name="address"
                                                                   value="{{Auth::user()->address}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 mb-25">
                                                        <div class="user-info-from">
                                                            <label class="label-text-title">{{__('Time Zone')}}
                                                                <span>*</span></label>
                                                            <select name="app_timezone" class="form-control select2">
                                                                @foreach($timezones as $timezone)
                                                                    <option
                                                                        value="{{ $timezone }}" {{$timezone == auth()->user()->app_timezone? 'selected' : ''}} > {{ $timezone }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 mb-25">
                                                        <button type="submit"
                                                                class="submit-btu">{{__("Update Profile")}}</button>
                                                    </div>


                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-coustomer-2" role="tabpanel"
                                     aria-labelledby="pills-coustomer-2-tab">
                                    <form action="{{route('agent.profile.change-password')}}" method="post"
                                          class="form-horizontal">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-8 mb-25">
                                                <div class="user-info-from">
                                                    <h2>{{__("Change Password")}}</h2>
                                                </div>
                                                <div class="col-md-8 mb-25">
                                                    <div class="user-info-from">
                                                        <label class="label-text-title">{{__("Current Password")}}
                                                            <span>*</span></label>
                                                        <input type="password" name="old_password" class="formControl" placeholder="*******">
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mb-25">
                                                    <div class="user-info-from">
                                                        <label class="label-text-title">{{__("New Password")}}
                                                            <span>*</span></label>
                                                        <input type="password" name="password" class="formControl" placeholder="*******">
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mb-25">
                                                    <div class="user-info-from">
                                                        <label class="label-text-title">{{__("Confirm Password")}}
                                                            <span>*</span></label>
                                                        <input type="password" name="password_confirmation" class="formControl" placeholder="*******">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-25">
                                                    <button type="submit"
                                                            class="submit-btu">{{__("Update Password")}}</button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- profile information end-->
        </div>
    </div>

@endsection
@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
@endpush
