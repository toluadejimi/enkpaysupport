@extends('admin.layouts.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/libs/datatable/datatables.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/custom/image-preview.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/custom/frontend.css') }}" />
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
                            <h2>{{ __('Category') }}</h2>
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
            <input type="hidden" id="news-list-route" value="{{ route('admin.tickets.category') }}">
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
                        <table class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                            id="ticketCategoryDataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Is Ticket Prefix') }}</th>
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

            <form class="ajax reset" action="{{ route('admin.tickets.category-store') }}" method="post"
                data-handler="commonResponseForModal">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="input__group mb-25">
                                <label for="title">{{ __('Name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" placeholder="{{ __('Name') }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input__group mb-25">
                                <label for="title">{{ __('Code') }} <span class="text-danger">*</span></label>
                                <input type="text" name="code" placeholder="">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input__group mb-25">
                                <label class="form-label">{{ __('Group User') }}</label>
                                <div class="input-group">
                                    <select name="group_user[]" class="form-control js-example-basic-multiple" multiple="multiple">
                                        @foreach($userList as $user)
                                            <option value="{{$user->id}}">{{ $user->email.'('.getRoleName(USER_ROLE_AGENT).')' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input__group mb-25">
                                <label class="form-label">{{ __('Is Ticket Prefix') }}</label>
                                <div class="input-group">
                                    <select name="is_ticket_prefix" class="form-control">
                                        <option value="1" >{{ __('Active') }}</option>
                                        <option value="0" >{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input__group mb-25">
                                <label class="form-label">{{ __('Status') }}</label>
                                <div class="input-group">
                                    <select name="status" class="form-control">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Deactive') }}</option>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        </div>
    </div>
</div>
<!-- Edit Modal section end -->
@endsection

@push('script')
<script src="{{ asset('admin/libs/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('admin/js/custom/ticketCategory.js') }}"></script>
<script src="{{ asset('admin/js/custom/image-preview.js') }}"></script>


@endpush
