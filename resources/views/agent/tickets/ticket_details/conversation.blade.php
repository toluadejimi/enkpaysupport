<div class="alertMassas collision-detector-alert d-none">
    <p>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
            <path
                d="M13.032 10.4712L7.70607 0.580625C7.32857 -0.120625 6.32295 -0.120625 5.94513 0.580625L0.619509 10.4712C0.537544 10.6235 0.496451 10.7944 0.50024 10.9672C0.504029 11.1401 0.552571 11.309 0.641129 11.4575C0.729686 11.606 0.855232 11.729 1.00551 11.8145C1.15579 11.9 1.32567 11.9451 1.49857 11.9453H12.1514C12.3244 11.9453 12.4945 11.9005 12.645 11.8151C12.7955 11.7297 12.9212 11.6067 13.01 11.4582C13.0987 11.3096 13.1474 11.1406 13.1513 10.9676C13.1551 10.7946 13.114 10.6236 13.032 10.4712ZM6.82576 10.4141C6.70215 10.4141 6.58131 10.3774 6.47853 10.3087C6.37575 10.2401 6.29564 10.1424 6.24833 10.0282C6.20103 9.91404 6.18865 9.78837 6.21277 9.66713C6.23688 9.54589 6.29641 9.43453 6.38382 9.34712C6.47123 9.25971 6.58259 9.20019 6.70383 9.17607C6.82507 9.15196 6.95073 9.16433 7.06494 9.21164C7.17914 9.25894 7.27675 9.33905 7.34543 9.44183C7.4141 9.54461 7.45076 9.66545 7.45076 9.78906C7.45076 9.95482 7.38491 10.1138 7.2677 10.231C7.15049 10.3482 6.99152 10.4141 6.82576 10.4141ZM7.50451 4.12813L7.32513 7.94063C7.32513 8.07323 7.27246 8.20041 7.17869 8.29418C7.08492 8.38795 6.95774 8.44063 6.82513 8.44063C6.69253 8.44063 6.56535 8.38795 6.47158 8.29418C6.37781 8.20041 6.32513 8.07323 6.32513 7.94063L6.14576 4.12969C6.14173 4.03862 6.15607 3.94768 6.18794 3.86227C6.2198 3.77687 6.26854 3.69875 6.33124 3.63259C6.39393 3.56642 6.46931 3.51355 6.55288 3.47713C6.63644 3.44072 6.72648 3.4215 6.81763 3.42063H6.8242C6.91597 3.42058 7.0068 3.43912 7.09121 3.47515C7.17561 3.51117 7.25185 3.56392 7.31531 3.63021C7.37877 3.6965 7.42814 3.77497 7.46044 3.86087C7.49275 3.94676 7.50731 4.03832 7.50326 4.13L7.50451 4.12813Z"
                fill="#FF434F"/>
        </svg> {{__("Collision detector stoped your massage")}}</p>
</div>
<div class="view-post-reply">
    <div class="repley-btu-check">
        <div class="aiReaplayView">
            <nav>
                @if(getOption('chat_gpt_api_key_status') !=null && getOption('chat_gpt_api_key_status') == 1)
                    <span class="iconNotifi ">
                    <span class="ellipsisDote">
                <button class="view-tab smWide assignmentsagent mb-0">
                    {{__("AI Reply")}}
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="6" viewBox="0 0 12 6" fill="none">
                    <path
                        d="M5.87341 5.71716C6.02962 5.87337 6.28288 5.87337 6.43909 5.71716L11.4734 0.682843C11.7254 0.430857 11.5469 0 11.1906 0H1.12194C0.765574 0 0.587107 0.430857 0.839093 0.682843L5.87341 5.71716Z"
                        fill="#6659FF"/>
                </svg>
                </button>
            </span>
                    <div class="editPart aiReplayBtu popup top-down">
                <input type="hidden" id="generateAiReplayRoute" value="{{route('agent.ai-replay-generate')}}">
                <input type="hidden" id="aiReplayDeleteRoute" value="{{route('agent.ai-replay-delete')}}">
                <input type="hidden" id="ticketData" value="{{$ticketData}}">
                <div class="coustomPart generate-ai-replay" data-id="{{$ticketData->id}}">
                <span class="replay "><i class="fa fa-plus me-1" aria-hidden="true"></i> {{__("Generate Reply")}}</span>
                    <div class="spinner-border text-primary d-none" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                    <i class="fa fa-check generate-done mt-2 text-success d-none" aria-hidden="true"></i>
                </div>
                <hr>
                <div class="reply-list">
                    @foreach(aiReplyList($ticketData->id) as $reply)
                        <div class="coustomPart-new">
                        <div class="show-read-more reply-result"
                             data-result="{{$reply->ai_replay_text}}">{{$reply->ai_replay_text}}</div>
                            <span class="ai_reply_delete" data-id="{{$reply->id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                     fill="none">
                            <path d="M2 4H3.33333H14" stroke="#737C90" stroke-width="1.4" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path
                                d="M5.33203 4.00004V2.66671C5.33203 2.31309 5.47251 1.97395 5.72256 1.7239C5.9726 1.47385 6.31174 1.33337 6.66536 1.33337H9.33203C9.68565 1.33337 10.0248 1.47385 10.2748 1.7239C10.5249 1.97395 10.6654 2.31309 10.6654 2.66671V4.00004M12.6654 4.00004V13.3334C12.6654 13.687 12.5249 14.0261 12.2748 14.2762C12.0248 14.5262 11.6857 14.6667 11.332 14.6667H4.66536C4.31174 14.6667 3.9726 14.5262 3.72256 14.2762C3.47251 14.0261 3.33203 13.687 3.33203 13.3334V4.00004H12.6654Z"
                                stroke="#737C90" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.66797 7.33337V11.3334" stroke="#737C90" stroke-width="1.4"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M9.33203 7.33337V11.3334" stroke="#737C90" stroke-width="1.4"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            </svg>
                            </span>
                    </div>
                    @endforeach
                </div>

            </div>
            </span>
                @endif
                <button class="view-tab ticketNote smWide m-0" data-ticke_id="{{$ticketData->id}}">
                    + {{__('Ticket Note')}}
                </button>
            </nav>

            <input type="hidden" id="ticketStatusChangeRoute" value="{{ route('agent.ticket.ticketStatusUpdate') }}">

        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home2" role="tabpanel" aria-labelledby="nav-home-tab2"
             tabindex="0">
            <form action="{{route('agent.conversations.conversationStore',encrypt($ticketData->id))}}" method="post"
                  class="form-horizontal"
                  enctype="multipart/form-data">
                @csrf
                <div class="summernote-reply">
                    <textarea class="summernoteReply collision-detector-check" name="conversation_details"
                              id="conversation_details"></textarea>
                    <div class="d-flex gap-3 ticket-status-change">
                        <div class=" checkrowed"
                             onclick="changeTicketStatus({{$ticketData->id}},{{STATUS_ON_HOLD}},{{$ticketData->status}})">
                            <input type="radio" class="status{{STATUS_ON_HOLD}}"
                                   @if($ticketData->status==STATUS_ON_HOLD) checked="checked" @endif  id="onHold"
                                   name="ticket_status">
                            <label class="onHoldColor mt-1" for="onHold">{{ __('On-Hold') }}</label>

                        </div>
                        <div class=" checkrowed"
                             onclick="changeTicketStatus({{$ticketData->id}},{{STATUS_CLOSED}},{{$ticketData->status}})">
                            <input type="radio" class="status{{STATUS_CLOSED}}"
                                   @if($ticketData->status==STATUS_CLOSED) checked="checked" @endif id="closed"
                                   name="ticket_status">
                            <label class="closedColor mt-1" for="closed">{{ __('Closed') }}</label>

                        </div>
                        <div class=" checkrowed"
                             onclick="changeTicketStatus({{$ticketData->id}},{{STATUS_SUSPENDED}},{{$ticketData->status}})">
                            <input type="radio" class="status{{STATUS_SUSPENDED}}"
                                   @if($ticketData->status==STATUS_SUSPENDED) checked="checked" @endif id="suspend"
                                   name="ticket_status">
                            <label class="suspendColor mt-1" for="suspend"
                            >Suspend</label>

                        </div>
                        <div class=" checkrowed"
                             onclick="changeTicketStatus({{$ticketData->id}},{{STATUS_INPROGRESS}},{{$ticketData->status}})">
                            <input type="radio" class="status{{STATUS_INPROGRESS}}"
                                   @if($ticketData->status==STATUS_INPROGRESS) checked="checked" @endif id="processing"
                                   name="ticket_status">
                            <label class="processingColor mt-1" for="processing">{{ __('Processing') }}</label>

                        </div>
                        <div class=" checkrowed"
                             onclick="changeTicketStatus({{$ticketData->id}},{{STATUS_RESOLVED}},{{$ticketData->status}})">
                            <input type="radio" class="status{{STATUS_RESOLVED}}"
                                   @if($ticketData->status==STATUS_RESOLVED) checked="checked" @endif id="solved"
                                   name="ticket_status">
                            <label class="solvedColor mt-1 me-0" for="solved">{{ __('Solved') }}</label>

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
                    <span class="instant-btu" id="noteBoxBtuto"><img
                            src="{{ asset('agent/assets/images/akar-icons.png')}}" alt="">
                    {{__('Instant Reply')}} <img src="{{ asset('agent/assets/images/dote3.png')}}" alt=""></span>
                    <div class="view-assign-tab " id="noteBox">
                        <div class="user-search">
                            <input type="text" id="instantReplySearch" placeholder="{{ __('Search Conversation') }}">
                            <span class="top-col-2"><i class="fa-solid fa-magnifying-glass"></i></span>
                        </div>
                        <div class="all-user-search">
                            @foreach($instantMessageData as $istMsg)
                                <div
                                    class="view-user-list clock-instant d-flex justify-content-between align-items-center gap-2">
                                    <div class="align-items-start d-flex gap-2 w-100">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('agent/assets/images/clock.png')}}" alt="">
                                        </div>
                                        <input type="hidden" id="{{$istMsg->id}}" value="{{$istMsg->message}}">
                                        <a href="#" onclick="loadInstantMessage({{$istMsg->id}})"
                                           data-target="{{$istMsg->id}}"><p>{{$istMsg->title}}</p></a>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="border-0 p-0 bg-transparent font-11 text-secondary"
                                                onclick="editInstantMessage('{{$istMsg->id}}', '{{$istMsg->title}}', '{{$istMsg->message}}')">
                                            <i class="fa-solid fa-pen"></i></button>
                                        <button type="button" class="border-0 p-0 bg-transparent font-11 text-danger"
                                                onclick="deleteItem('{{route('agent.conversations.instant.message.delete', $istMsg->id)}}','',true)">
                                            <i class="fa-solid fa-trash"></i></button>
                                    </div>

                                </div>
                            @endforeach
                            <span class="ticket-btu-com add-ins-reply w-100" data-bs-toggle="modal"
                                  data-bs-target="#InstantModal"
                                  data-bs-whatever="@mdo">{{__('Add Instant Reply')}}</span>
                        </div>
                    </div>
                </div>
                <div class="create-ticket-image">
                </div>
                <div class="">
                    <div class="ticket-upload-box">
                        <div class="ticket-upload-btn-box">
                            <p class="create-ticket-image-type">{{__('Upload file (JPEG, PNG, ZIP, MP4, GIF,DOC)')}}</p>
                            <div
                                class="align-items-center d-flex justify-content-between displayNot ag-ticket-conv-image">
                                <div class="choose-file-border">
                                    <p>{{__('Choose files to upload')}}</p>
                                    <label class="upload__btn" for="ticket-upload-img">
                                        <span class="browse-file">{{__('Browse File')}}</span>
                                        <input type="file" multiple="" data-max_length="20" id="ticket-upload-img"
                                               name="file[]" class="ticket-img-input d-none">
                                    </label>
                                </div>
                                <div class="submitReaply mb-3">
                                    <button type="submit" @if($ticketData->status==STATUS_CLOSED) disabled
                                            @endif class="ticket-btu-com">{{__('Send Message')}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="ticket-upload-img-wrap"></div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
{{--<input type="hidden" id="checkCollisionDetector" value="{{route('agent.check-collision-detector')}}">--}}
<input type="hidden" id="ticketId" value="{{$ticketData->id}}">
<input type="hidden" id="instantReplaySearchRoute" value="{{route('agent.conversations.instant.message.search')}}">

@push('script')
    <script src="{{ asset('assets/js/custom/ai_replay.js') }}"></script>
    <script src="{{ asset('assets/js/custom/collision_detector.js') }}"></script>
@endpush
