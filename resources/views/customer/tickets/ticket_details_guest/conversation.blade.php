<div class="view-post-reply">
    <div class="quickVieew">
        <input type="hidden" id="ticketStatusChangeRoute"
               value="{{ route('ticket.ticketStatusUpdate',$ticketData) }}">

        <input type="hidden" id="ticketData" value="{{$ticketData}}">
        <input type="hidden" id="ticketDataId" value="{{encrypt($ticketData->id)}}">

    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home2" role="tabpanel" aria-labelledby="nav-home-tab2"
             tabindex="0">
            <form action="{{route('ticket.conversationStore',encrypt($id))}}" method="post" class="form-horizontal"
                  enctype="multipart/form-data">
                @csrf
                <div class="summernote-reply">
                    <input type="hidden" value="{{$ticketData->created_by}}" name="created_by">
                    <textarea class="summernoteReply" name="conversation_details" id="conversation_details"></textarea>
                    <div class="d-flex gap-2 ticket-status-change">
                        <div class=" checkrowed">
                            <input class="ticket_status_input" data-status={{STATUS_CLOSED}} type="radio"
                                   @if($ticketData->status==STATUS_CLOSED) checked="checked" @endif id="closed"
                                   name="ticket_status">
                            <label class="closedColor" for="closed">{{ __('Closed') }}</label>

                        </div>
                        <div class=" checkrowed">
                            <input class="ticket_status_input" data-status={{STATUS_RESOLVED}} type="radio"
                                   @if($ticketData->status==STATUS_RESOLVED) checked="checked" @endif id="solved"
                                   name="ticket_status">
                            <label class="solvedColor me-0" for="solved">{{__("Solved")}}</label>


                        </div>
                    </div>
                    @if(getOption('agent_rating_status') == 1)
                        <div class="rate-section">
                            <div class="rating-view-container" onclick="view_rating_modal()">
                                @php
                                    if( getRatingByTicketId($ticketData->id) > 0 ){
                                    $rating = getRatingByTicketId($ticketData->id);
                                    }
                                @endphp
                                @if(!empty($rating))
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
                                @else
                                    @if($ticketData->status==STATUS_CLOSED)
                                        @for ($i = 1; $i <= 5; $i++)
                                            <div class="rating-view-init">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                        @endfor
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="view-assign-tab " id="noteBox">
                        <div class="user-search">
                            <input type="text" placeholder="{{ __('Search Conversation') }}">
                            <span><i class="fa-solid fa-magnifying-glass"></i></span>
                        </div>
                    </div>
                </div>

                <div class="ticket-upload-box">
                    <div class="ticket-upload-btn-box">
                        <p class="create-ticket-image-type">{{__("Upload file")}} {{__("(JPG, JPEG, PNG, ZIP, MP4, GIF, DOC)")}}</p>
                        <div class=" align-items-center d-flex justify-content-between displayNot">

                            <div class="choose-file-border">
                                <p>{{__('Choose files to upload')}}</p>
                                <label class="upload__btn m-0" for="ticket-upload-img">
                                    <span class="browse-file">{{__("Browse File")}}</span>
                                    <input type="file" multiple="" data-max_length="20" id="ticket-upload-img"
                                           name="file[]" class="ticket-img-input d-none">
                                </label>
                            </div>
                            <div class="submitReaply mb-3">
                                <button type="submit" @if($ticketData->status==STATUS_CLOSED) disabled
                                        @endif class="ticket-btu-com conversation-reply">{{__('Reply Now')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="ticket-upload-img-wrap"></div>
                </div>

            </form>
        </div>
    </div>
</div>

@push('script')

@endpush
