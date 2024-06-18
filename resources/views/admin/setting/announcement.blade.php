@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote-lite.min.css') }}"/>
@endpush

@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __("Announcement") }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12 col-lg-12 col-md-8">
                    <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                        <div class="customers__table">
                            <div>
                                <form class="ajax" action="{{ route('admin.setting.announcement-store') }}"
                                      method="POST"
                                      enctype="multipart/form-data" data-handler="settingCommonHandler">

                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{$announcementData?->id}}">
                                        <div class="col-xxl-12 col-lg-6 mb-3">
                                            <label class="form-label"><h3>{{__('Customer Announcement')}}</h3> </label>
                                            <textarea name="customer_announcement"
                                                      class="summernote"
                                                      placeholder="{{ __("Customer Announcement") }}"> {{$announcementData?->customer_announcement}} </textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input__group general-settings-btn">
                                                <button type="submit"
                                                        class="btn btn-blue float-right">{{__('Update')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="add-modal" aria-hidden="true" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Add New') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form class="ajax reset" action="{{ route('admin.setting.frontend.faq.store') }}" method="post"
                              data-handler="commonResponseForModal">
                            @csrf

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-purple">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->

@endsection

@push('script')
    <script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom/blogs.js') }}"></script>
@endpush
