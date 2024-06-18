@extends('agent.layouts.app')
@push('title')
    {{ __('Chat Inbox') }}
@endpush
@push('style')

@endpush
@section('content')
    <input type="hidden" id="pusher_app_key" value="{{getOption('pusher_app_key')}}">
    <input type="hidden" id="pusher_cluster" value="{{getOption('pusher_cluster')}}">
    <input type="hidden" id="pusher_chanel" value="{{getOption('pusher_chanel_name')}}">
    <input type="hidden" id="chatUnseenMsgRout" value="{{route('agent.live-chat.unseen-msg')}}">
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
                        <div class="col-lg-12">

                            <div class="row">
                                <input type="hidden" id="chatDataRout" value="{{route('agent.live-chat.fetch-msg')}}">
                                <div class="col-lg-3  inbox mb-3">
                                    <div class="content-user-list">
                                        <h6 class="message-all">{{__("Messages")}} <span class="unseen-count">0</span></h6>
                                        <ul class="scroll list-group-item-action session-item">

                                            @if(count($inboxData)>0)
                                                @foreach($inboxData as $data)
                                                    <li class="inbox-item-action p-0 border-0 chat-thread-{{$data->chat_session_created_by}}"
                                                        data-sender_id="{{$data->chat_session_created_by}}">
                                                        <div class="single-chat-name">
                                                            <div class="single-chat-img flex-shrink-0 d-flex justify-content-center align-items-center overflow-hidden">
                                                                <img src="{{getFileUrl($data->image)}}"
                                                                     alt="">
                                                            </div>
                                                            <div class="single-chat-info-name">
                                                                <div
                                                                    class="d-flex justify-content-between align-content-center flex-wrap">
                                                                    <h5>
                                                                        {{$data->name}}
                                                                    </h5>
                                                                    <p class="chart-time">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->diffForHumans()}}</p>
                                                                </div>

                                                                <p>{{$data->email}}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif

                                        </ul>
                                    </div>

                                </div>
                                <div class="col-lg-9  d-none reply-secion mb-3">

                                    <div class="chart-reaply">
                                        <div class="chat-board  msg-board"></div>
                                        <form class="ajax reset" action="{{route('agent.live-chat.send-msg')}}"
                                              method="post"
                                              data-handler="msgSentResponse">
                                            @csrf
                                            <p class="fileUpload ps-4 ms-4"></p>
                                            <div class="input-box-part">
                                                <input type="hidden" name="receiver_id" id="receiverId" value="">
                                                <div class="reply-input-icon">
                                                    <div class="reply-input-img">
                                                        <div class="upload__box">
                                                            <div class="upload__btn-box">
                                                                <label class="upload__btn">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17"
                                                                         height="18" viewBox="0 0 17 18" fill="none">
                                                                        <path
                                                                            d="M16.1111 8.50079L8.96692 15.635C7.14438 17.455 4.18945 17.455 2.36691 15.635C0.544364 13.815 0.544364 10.8642 2.36691 9.04421L9.51109 1.91C10.7261 0.696667 12.6961 0.696667 13.9111 1.91C15.1261 3.12333 15.1261 5.09053 13.9111 6.30386L6.75914 13.4381C6.15163 14.0447 5.16665 14.0447 4.55914 13.4381C3.95162 12.8314 3.95162 11.8478 4.55914 11.2411L11.1592 4.6581"
                                                                            stroke="#737C90" stroke-width="1.5"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"/>
                                                                    </svg>
                                                                    <input type="file" multiple="" name="file[]"
                                                                           data-max_length="20"
                                                                           class="upload__inputfile d-none">
                                                                </label>
                                                            </div>
                                                            <div class="upload__img-wrap"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="massage">
                                                    <input type="text" placeholder="{{ __('Message') }}" name="message"
                                                              class="form-control input-field-reset input-field" />
                                                </div>
                                                <button type="submit" class="bg-submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                         viewBox="0 0 25 25" fill="none">
                                                        <path
                                                            d="M21.1549 3.84568C21.0558 3.74699 20.9305 3.67866 20.7938 3.64873C20.6572 3.6188 20.5148 3.6285 20.3835 3.6767L4.22023 9.55425C4.08084 9.60713 3.96082 9.70116 3.87614 9.82385C3.79145 9.94655 3.74609 10.0921 3.74609 10.2412C3.74609 10.3903 3.79145 10.5358 3.87614 10.6585C3.96082 10.7812 4.08084 10.8753 4.22023 10.9281L10.5313 13.4481L15.1892 8.77548L16.2251 9.8114L11.5451 14.4914L14.0725 20.8024C14.1269 20.9391 14.2212 21.0563 14.343 21.1388C14.4648 21.2214 14.6086 21.2654 14.7557 21.2653C14.9042 21.2622 15.0483 21.2143 15.1689 21.1277C15.2896 21.0411 15.3812 20.92 15.4317 20.7804L21.3092 4.61711C21.3593 4.48713 21.3713 4.34559 21.344 4.20901C21.3167 4.07242 21.2511 3.94642 21.1549 3.84568Z"
                                                            fill="white"/>
                                                    </svg>
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-9 no-reply-secion">
                                    <div class="chat-board  msg-board">
                                        <h6 class="no-customer">
                                            {{__('No selected customer')}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- View Ticket end-->
        </div>
    </div>
    <div id="zaiDeskChatPopup" class=" model-image-preview">
        <span class="closele" onclick="closeImagePreview()">&times;</span>
        <img class="modal-content" id="imagePreviewSection">
    </div>
@endsection
@push('script')
    <script src="{{ asset('common/js/pusher.min.js') }}"></script>
    <script src="{{ asset('agent/assets/js/custom/chat.js') }}"></script>
@endpush

