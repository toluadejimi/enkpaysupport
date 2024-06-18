@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/libs/datatable/datatables.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/custom/image-preview.css') }}">
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
                                <h2>{{ __('CMS Setting') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="hidden" id="news-list-route" value="{{ route('admin.setting.frontend.feature.index') }}">
                <div class="col-xxl-3 col-lg-3 col-md-4 pr-0">
                    @include('admin.setting.partials.frontend-sidebar')
                </div>
                <div class="col-xxl-9 col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                        <div class="item-title d-flex flex-wrap justify-content-between">
                            <h2>{{ $pageTitle }}</h2>
                            <div>
                            </div>
                        </div>

                        <div class="customers__table">
                            <table
                                class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                                id="featureDataTable">
                                <thead>
                                <tr>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Status') }}</th>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add New') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="ajax reset" action="{{ route('admin.setting.frontend.feature.store') }}" method="post"
                      data-handler="commonResponseForModal">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="input__group mb-25">
                                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="title" placeholder="{{ __('Title') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input__group mb-25">
                                    <label for="description">{{ __('Description') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description" rows="5" id=""></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input__group mb-25">
                                    <label for="icon" class="text-lg-right text-black"> {{ __('Icon') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="upload-img-box">
                                        <img src="{{ getDefaultImage() }}">
                                        <input type="file" name="icon" accept="image/*" onchange="previewFile(this)">
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- Edit Modal section end -->
@endsection

@push('script')
    <script src="{{ asset('admin/libs/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom/feature.js') }}"></script>
    <script src="{{ asset('admin/js/custom/image-preview.js') }}"></script>
@endpush
