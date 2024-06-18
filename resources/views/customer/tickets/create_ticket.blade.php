@extends('customer.layouts.app')
@push('title')
    {{ __('Create Ticket') }}
@endpush
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote-lite.min.css') }}"/>
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
                                        <h2>{{$pageTitle}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- dashboard area end -->


            <!-- Create Ticket start-->

            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="create-ticket">
                                <form action="{{route('customer.ticket.submit')}}" method="post" class="form-horizontal"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="zi-w-65 zi-lg-w-100">
                                            <div class="user-info-from">
                                                <label class="label-text-title">{{__("Subject")}} <span>*</span></label>
                                                <input type="text" placeholder="{{__("Subject")}}" class="formControl"
                                                       name="subject">
                                            </div>
                                        </div>
                                        <div class="zi-w-35 zi-lg-w-100">
                                            <div class="user-info-from">
                                                <label class="label-text-title">{{__("Category")}}
                                                    <span>*</span></label>
                                                <select id="" class="single-catagories form-control" name="category">
                                                    <option>{{__("Select Category")}}</option>
                                                    @foreach($category as $item)
                                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                       
                                            <div class="col-lg-6">
                                                <div class="user-info-from">
                                                    <label class="label-text-title">{{ __('Email') }}
                                                        <span>*</span></label>
                                                    <input type="text" placeholder="Enter your valid email"
                                                           class="formControl"
                                                           name="email" value="{{auth()->user()->email}}" disabled>
                                                </div>
                                                <h6 style="font-size: 8px; color:brown;">We respond back to your provided Email, make sure its valid</h6>
                                            </div>
                                       
                                    </div>
                                    @if(count($dynamicFields)>0)
                                        <div class="row">
                                            @foreach($dynamicFields as $field)
                                                <div class="zi-lg-w-100"
                                                     style="width: {{$field->width != null?$field->width:100}}%;">
                                                    <div class="user-info-from">
                                                        @if($field->type == TEXT_FIELD_ID)
                                                            <label class="label-text-title">{{$field->level}}
                                                                <span> {{$field->required == REQUIRED_YES?'*':''}}</span>
                                                            </label>
                                                            <input type="text"
                                                                   placeholder="{{$field->placeholder}}"
                                                                   class="formControl" name="{{$field->name}}">

                                                        @elseif($field->type == TEXTAREA_FIELD_ID)
                                                            <label class="label-text-title">{{$field->level}}
                                                                <span> {{$field->required == REQUIRED_YES?'*':''}}</span>
                                                            </label>
                                                            <textarea class="formControl mb-3 text-h"
                                                                      placeholder="{{$field->placeholder}}"
                                                                      name="{{$field->name}}"></textarea>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="user-info-from">
                                                <label class="label-text-title">{{__("Description")}} <span>*</span>
                                                </label>
                                                <textarea class="customer-ticket-create summernote" placeholder="Massage"
                                                          name="details"></textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="file-upload">
                                                <div class="ticket-upload-box">
                                                    <div class="ticket-upload-btn-box">
                                                        <p class="create-ticket-image-type">{{__("Upload file (JPG, JPEG, PNG, ZIP, MP4, GIF, DOC)")}}</p>
                                                        <div class="choose-file-border">
                                                            <p>{{__("Choose files to upload")}}</p>
                                                            <label class="upload__btn" for="ticket-upload-img">
                                                                <span class="browse-file">{{ __('Browse File') }}</span>
                                                                <input type="file" multiple="" data-max_length="20"
                                                                       id="ticket-upload-img" name="file[]"
                                                                       class="ticket-img-input d-none">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="ticket-upload-img-wrap"></div>
                                                </div>
                                                <div class="agree-box">
                                                    <div class="agree-left">
                                                        <input type="checkbox" id="service">
                                                        <label for="service"> {{__("I agree with")}} </label> <a
                                                            href="">{{__("Terms & Service")}}</a>
                                                    </div>
                                                    <div class="agree-right">
                                                        <button class="submit-btu"
                                                                disabled="disabled">{{__("Create Ticket")}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Create Ticket end-->
        </div>
    </div>
@endsection
@push('script')
<script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
<script src="{{ asset('admin/js/custom/summernote-init.js') }}"></script>
<script src="{{ asset('customer/assets/js/custom/tickets.js') }}"></script>
@endpush
