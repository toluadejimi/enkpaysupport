
@extends('customer.layouts.app_guest')
@push('title')
    {{ __('Create Ticket') }}
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote-lite.min.css') }}"/>
@endpush

@section('content')
    <!-- Right Content Start -->
    <div class="">
        <!-- dashboard area start -->
        <section class="dashboard-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dashboard-box">
                            <div class="title-area">
                                <div class="dashboard-text">
                                    <h2>{{ $pageTitle }}</h2>
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
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="create-ticket">
                            <form action="{{ route('ticket.guest-ticket-submit') }}" method="post" class="form-horizontal"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="guest" value="1">
                                    <div class="zi-w-65 zi-lg-w-100">
                                        <div class="user-info-from">
                                            <label class="label-text-title">{{ __('Subject') }} <span>*</span></label>
                                            <input type="text" placeholder="{{ __('Subject') }}" class="formControl"
                                                name="subject">
                                        </div>
                                    </div>
                                    <div class="zi-w-35 zi-lg-w-100">
                                        <div class="user-info-from">
                                            <label class="label-text-title">{{ __('Category') }}
                                                <span>*</span></label>
                                            <select id="" class="single-catagories form-control" name="category">
                                                <option>{{ __('Select Category') }}</option>
                                                @foreach ($category as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @if (count($dynamicFields) > 0)
                                        @foreach ($dynamicFields as $field)
                                            <div class="zi-lg-w-100"
                                                style="width: {{ $field->width != null ? $field->width : 100 }}%;">
                                                <div class="user-info-from">
                                                    @if ($field->type == TEXT_FIELD_ID)
                                                        <label class="label-text-title">{{ $field->level }} <span>
                                                                {{ $field->required == REQUIRED_YES ? '*' : '' }}</span>
                                                        </label>
                                                        <input type="text" placeholder="{{ $field->placeholder }}"
                                                            class="formControl" name="{{ $field->name }}">
                                                    @elseif($field->type == TEXTAREA_FIELD_ID)
                                                        <label class="label-text-title">{{ $field->level }} <span>
                                                                {{ $field->required == REQUIRED_YES ? '*' : '' }}</span>
                                                        </label>
                                                        <textarea class="formControl mb-3 text-h" placeholder="{{ $field->placeholder }}" name="{{ $field->name }}"></textarea>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                    @if ($envato?->enable_purchase_code == 1)
                                        <div class="col-lg-6">
                                            <div class="user-info-from">
                                                <label class="label-text-title">{{ __('Purchase Code') }}
                                                    <span>*</span></label>
                                                <input type="text" placeholder="8c3b8f37-34bd-4d4c-71da-331abb35ecc9"
                                                    class="formControl" name="purchase_code">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-6">
                                        <div class="user-info-from">
                                            <label class="label-text-title">{{ __('Email') }} <span>*</span></label>
                                            <input type="text" placeholder="example@email.com" class="formControl"
                                                name="email">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="user-info-from">
                                            <label class="label-text-title">{{ __('Description') }} <span>
                                                    *</span>
                                            </label>
                                            <textarea class="customer-ticket-create summernote" placeholder=" Massage" name="details"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="file-upload">
                                            <div class="ticket-upload-box">
                                                <div class="ticket-upload-btn-box">
                                                    <p class="create-ticket-image-type">
                                                        {{ __('Upload file (JPG, JPEG, PNG, ZIP, MP4, GIF, DOC)') }}</p>
                                                    <div class="choose-file-border">
                                                        <p>{{ __('Choose files to upload') }}</p>
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
                                                    <label for="service"> {{ __('I agree with') }} </label> <a
                                                        href="">{{ __('Terms & Service') }}</a>
                                                </div>
                                                <div class="agree-right">
                                                    <button class="submit-btu w-auto"
                                                        disabled="disabled">{{ __('Create Ticket') }}</button>
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

@endsection


@push('script')
    <script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom/summernote-init.js') }}"></script>
    <script src="{{ asset('customer/assets/js/custom/tickets.js') }}"></script>
@endpush
