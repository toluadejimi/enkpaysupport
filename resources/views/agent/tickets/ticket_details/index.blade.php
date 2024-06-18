@extends('agent.layouts.app')
@push('title')
    {{ __('Ticket Details') }}
@endpush
@push('style')
    <!-- fonts file -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('common/css/summernote/summernote-lite.min.css')}}"/>

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

            <!-- View Ticket start-->
            <section class="view-ticket-area">
                <div class="container-fluid">
                    <div class="row position-relative">
                        <div class="col-lg-8">
                            <div class="allPostUser">
                                <!-- Ticket Assign Tags Start -->
                                @include('agent.tickets.ticket_details.assign-tag')
                                <!-- Ticket Assign Tags End -->
                                <!-- Ticket Conversation Start -->
                                @include('agent.tickets.ticket_details.conversation')
                                <!-- Ticket Conversation End -->
                            </div>
                            <!-- Conversation List Start -->
                            @include('agent.tickets.ticket_details.conversation-list')
                            <!-- Conversation List End -->
                        </div>
                        <div class="col-lg-4">
                            <!-- Ticket Info Start -->
                            @include('agent.tickets.ticket_details.ticket-info')
                            <!-- Ticket Info end -->
                            <!-- Customer Details Start -->
                            @include('agent.tickets.ticket_details.customer-details')
                            <!-- Customer Details end -->
                            <!-- all notes start -->
                            @include('agent.tickets.ticket_details.all-notes')
                            <!-- all notes end -->
                        </div>
                        <span id="instantnoneClick"></span>
                    </div>
                </div>
                <span id="notfioverlay"></span>
            </section>
        </div>

        <!--  Ticket Note model start -->
        @include('agent.tickets.ticket_details.add-note')
        <!--  Ticket Note model end -->

        <!--  Add Instant Reply model start -->
        @include('agent.tickets.ticket_details.add-instant-message')
        <!--  Add Instant Reply model end -->

        <!--  Add Categorymodel start -->
        <form class="ajax reset" action="{{ route('agent.ticket.categoryUpdate') }}" method="post"
              data-handler="commonResponseForModal">
            @csrf
            <div class="modal fade" id="categorymodel" tabindex="-3" aria-labelledby="categorModalLabel"
                 aria-hidden="true">
                <input type="hidden" name="category_ticket_id" value="{{ $ticketData->id }}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="noteTitle">
                            <h5 class=" " id="categorModalLabel">{{__('Category')}}</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="noteIntoPart">
                            <select class="category" name="ticket_category">
                                @isset($ticketCategory)
                                    @foreach ($ticketCategory as $category )
                                        <option @if($ticketData->category->id==$category->id) selected
                                                @endif value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="noteIntoPart-btu">
                            <button type="button" class="noteIntoPartBtuBorder mx-3"
                                    data-bs-dismiss="modal">{{__('Back')}}
                            </button>
                            <button type="submit" data-bs-dismiss="modal"
                                    class=" submit-btu mx-3">{{__('Save')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--  Add Categorymodel end -->

        <!--  Add priority start -->
        <form class="ajax reset" action="{{ route('agent.ticket.priorityUpdate') }}" method="post"
              data-handler="commonResponseForModal">
            @csrf
            <input type="hidden" name="priority_ticket_id" value="{{ $ticketData->id }}">
            <div class="modal fade" id="prioritymodel" tabindex="-3" aria-labelledby="priorityModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="noteTitle">
                            <h5 class=" " id="priorityModalLabel">{{__('Priority')}}</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="noteIntoPart">
                            <select class="category" name="ticket_priority">
                                @foreach($priorities as $value=>$key)
                                    )
                                    <option @if($ticketData->priority==$value) selected
                                            @endif value="{{$value}}">{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="noteIntoPart-btu">
                            <button type="button" class="noteIntoPartBtuBorder mx-3"
                                    data-bs-dismiss="modal">{{__('Back')}}
                            </button>
                            <button type="submit" data-bs-dismiss="modal"
                                    class=" submit-btu mx-3">{{__('Save')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--  Add priority end -->

        <!--  edit conversion modal start -->
        <form class="ajax reset" action="{{ route('agent.conversations.conversation-update') }}" method="post"
              data-handler="commonResponseForModal">
            @csrf
            <div class="modal fade" id="conversionEditmodel" tabindex="-3" aria-labelledby="conversionEditmodelLabel" aria-hidden="true">
                <input type="hidden" name="conversion_id" id="conversion_id" value="">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Edit Conversion') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="noteIntoPart pt-3">
                            <textarea class="summernoteReply" name="conversation_details" id="conversation_details_edit"></textarea>
                        </div>
                        <div class="noteIntoPart-btu sf-noteIntoPart-btu">
                            <button type="button" class="noteIntoPartBtuBorder mx-3" data-bs-dismiss="modal">{{__('Back')}}</button>
                            <button type="submit" data-bs-dismiss="modal" class=" submit-btu mx-3">{{__('Save')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--  edit conversion modal end -->

        <!--  details dynamic field data edit start -->
        <form class="ajax reset" action="{{ route('agent.dynamic-fields-data-update') }}" method="post"
              data-handler="commonResponseForModal">
            @csrf
            <div class="modal fade" id="detailsInfoModel" tabindex="-3" aria-labelledby="detailsInfoModelLabel" aria-hidden="true">
                <input type="hidden" name="id" id="dynamic_field_data_id" value="">
                <input type="hidden" name="required" id="required" value="">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="noteTitle">
                            <h5 class=" " id="categorModalLabel">{{__('Edit Data')}}</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="noteIntoPart">
                        <span class="text-field d-none">
                             <label class="label-text-title text-field-title"><span class="text-field-required"></span>
                            </label>
                            <input type="text" class="formControl" name="text_field_value" value="" id="text-field">
                        </span>

                            <span class="textarea-field d-none">
                            <label class="label-text-title textarea-field-title"><span class="textarea-field-required"></span>
                            </label>
                            <textarea class="formControl mb-3 text-h" name="textarea_field_value" id="textarea-field"></textarea>
                        </span>

                        </div>
                        <div class="noteIntoPart-btu sf-noteIntoPart-btu">
                            <button type="button" class="noteIntoPartBtuBorder mx-3" data-bs-dismiss="modal">{{__('Back')}}</button>
                            <button type="submit" class=" submit-btu mx-3">{{__('Save')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--  details dynamic field data edit edit -->

        <!--  license field data edit start -->
        <form class="ajax reset" action="{{ route('agent.ticket.license-data-update') }}" method="post"
              data-handler="commonResponseForModal">
            @csrf
            <div class="modal fade" id="licenseEditModel" tabindex="-3" aria-labelledby="detailsInfoModelLabel" aria-hidden="true">
                <input type="hidden" name="ticket_id" id="tickeId" value="">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="noteTitle">
                            <h5 class="" id="">{{__('Edit License')}}</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="noteIntoPart">
                        <span class="text-field ">
                            <input type="text" class="formControl" name="license" value="" id="licenseField">
                        </span>

                        </div>
                        <div class="noteIntoPart-btu sf-noteIntoPart-btu">
                            <button type="button" class="noteIntoPartBtuBorder mx-3" data-bs-dismiss="modal">{{__('Back')}}</button>
                            <button type="submit" class=" submit-btu mx-3">{{__('Save')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--  license field data edit edit end -->

        @endsection
        @push('script')
            <script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
            <script src="{{ asset('agent/assets/js/custom/ticket-details.js') }}"></script>
    @endpush
