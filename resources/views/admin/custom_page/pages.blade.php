@extends('admin.layouts.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/libs/datatable/datatables.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/custom/image-preview.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('common/css/summernote/summernote-lite.min.css') }}" />
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
                            <h2>{{ __('Custom page') }}</h2>
                        </div>
                    </div>
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard')
                                        }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <input type="hidden" id="news-list-route" value="{{ route('admin.blogs.index') }}">
            <div class="col-xl-12">
                <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                    <div class="item-title d-flex flex-wrap justify-content-between">
                        <h2>{{ $pageTitle }}</h2>
                        <div>
                            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal"
                                data-bs-target="#add-modal">
                                <i class="fa fa-plus"></i> {{ __('Add New') }}
                            </button>
                        </div>
                    </div>

                    <div class="customers__table">
                        <input type="hidden" value="{{route('admin.custom-pages')}}" id="pages-list-route">
                        <table class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                            id="customPageDataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Link') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created Date') }}</th>
                                    <th class="action__buttons d-flex justify-content-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content area end -->


<!-- Add Modal section start -->
<div class="modal fade" id="add-modal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Add New') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="ajax reset" action="{{ route('admin.custom-pages-store') }}" method="post"
                  data-handler="commonResponseForModal">
                @csrf
                <div class="modal-body model-lg">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input__group mb-25">
                                <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title" placeholder="{{ __('Title') }}">
                            </div>
                        </div>

                        <div class="col-md-12 mb-25">
                            <label>{{__('Details')}} <span class="text-danger">*</span></label>
                            <textarea name="details" class="summernote" placeholder="{{ __("Details") }}"></textarea>
                        </div>

                        <div class="col-md-6">
                            <div class="input__group mb-25">
                                <label class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select name="status" class="form-control">
                                        <option value="1">{{ __('Publish') }}</option>
                                        <option value="0">{{ __('Unpublish') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-purple">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal section end -->

<!-- Edit Modal section start -->
<div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- Edit Modal section end -->

@endsection

@push('script')
<script src="{{ asset('admin/libs/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('admin/js/custom/image-preview.js') }}"></script>
<script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
<script src="{{ asset('admin/js/custom/blogs.js') }}"></script>
<script src="{{ asset('admin/js/custom/pages.js') }}"></script>
<script src="{{ asset('admin/js/custom/summernote-init.js') }}"></script>
@endpush
