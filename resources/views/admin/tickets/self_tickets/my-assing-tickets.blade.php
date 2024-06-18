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
                            <h2>{{ __('Tickets') }}</h2>
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
            <input type="hidden" id="self-assigned-tickets" value="{{ route('admin.tickets.my-assigned-tickets') }}">
            <div class="col-xl-12">
                <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                    <div class="item-title d-flex flex-wrap justify-content-between">
                        <h2>{{ $pageTitle }}</h2>
                    </div>

                    <div class="customers__table">
                        <table class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                            id="ticketManagementDataTable">
                            <thead>
                                <tr>
                                    <th>{{ __("Ticket Id") }}</th>
                                    <th>{{ __('Ticket Details') }}</th>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Updated') }}</th>
                                    <th>{{ __('Assigned') }}</th>
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

@endsection

@push('script')
<script src="{{ asset('admin/libs/datatable/datatables.min.js') }}"></script>
{{--<script src="{{ asset('admin/js/custom/tickets.js') }}"></script>--}}
<script src="{{ asset('admin/js/custom/image-preview.js') }}"></script>
    <script>
        $(document).on('change', '#assign_to', function(){

            let val = $(this).val();
            var ticketId = $(this).attr("data-id");
            var targetUrl = "{{ route('admin.tickets.ticketAssignTo') }}"+'?ticketId='+ticketId;
            var modalId = '#ticketAssignModal';
            var modalUrl = $(this).attr("modal-url");
            if(val=='others')
            {
                $.ajax({
                    type: 'GET',
                    url: modalUrl,
                    success: function (data) {
                        $(document).find(modalId).find('.modal-content').html(data);
                        $(modalId).modal('toggle');
                        $(document).ready(function() {
                            $(".sf-select").select2({
                                dropdownCssClass: "sf-select-dropdown",
                                selectionCssClass: "sf-select-section",
                            });
                        });
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message)
                    }
                })
            }
            else if(val=='self')
            {
                $.ajax({
                    type: 'GET',
                    url: targetUrl,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status === true) {
                            toastr.success(data.message);
                        }
                        else{
                            toastr.error("Something Went Wrong!");
                        }
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message)
                    }
                });
            }
        });
        $('#ticketManagementDataTable').DataTable({
            pageLength: 25,
            ordering: false,
            serverSide: true,
            processing: true,
            searing: false,
            ajax: $('#self-assigned-tickets').val(),
            language: {
                paginate: {
                    previous: "<span class='iconify' data-icon='material-symbols:chevron-left-rounded'></span>",
                    next: "<span class='iconify' data-icon='material-symbols:chevron-right-rounded'></span>",
                },
                searchPlaceholder: "Search",
                search: ""
            },
            dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>tr<"bottom"<"row"<"col-sm-6"i><"col-sm-6"p>>><"clear">',
            columns: [
                {"data": 'ticket_id', "name": 'tracking_no'},
                {"data": "ticket_title", "name": "ticket_title"},
                {"data": "created_by", "name": "created_by"},
                {"data": "updated", "name": "updated", searchable: false},
                {"data": "assigned_to", "name": "assigned_to"},
                {"data": "action", searchable: false, responsivePriority:2},
            ]
        });
    </script>
@endpush
