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
                            <h2>{{ __('Ticket Rating Management') }}</h2>
                        </div>
                    </div>
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <input type="hidden" id="ticket-list-route" value="{{ $targetDataUrl }}">
            <div class="col-xl-12">
                <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                    <div class="item-title d-flex flex-wrap justify-content-between">
                        <h2>{{ $pageTitle }}</h2>
                    </div>

                    <div class="customers__table">
                        <table class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline ZaideskTable"
                            id="ticketRatingDataTable">
                            <thead>
                                <tr>
                                    <th>{{ __("Ticket Id") }}</th>
                                    <th>{{ __('Ticket Details') }}</th>
                                    <th>{{ __('Rating By') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Rating') }}</th>
                                    <th>{{ __('Comments') }}</th>
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

<!-- Ticket View Modal section start -->
<div class="modal fade" id="ticket-view-modal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        </div>
    </div>
</div>
<!-- Ticket View section end -->
<input type="hidden" id="ticketAssignToUrl" value="{{ route('admin.tickets.ticketRatingUpdate') }}">
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
<script src="{{ asset('admin/js/custom/ticketRating.js') }}"></script>
<script src="{{ asset('admin/js/custom/image-preview.js') }}"></script>
@endpush
