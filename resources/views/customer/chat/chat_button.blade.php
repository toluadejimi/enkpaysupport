<input type="hidden" id="chatDataRout" value="{{route('customer.live-chat.fetch-msg')}}">
<input type="hidden" id="historyChatDataRout" value="{{route('customer.live-chat.fetch-history-msg')}}">
<input type="hidden" id="sessionStatusChangeRoute" value="{{route('customer.live-chat.session-status-change')}}">
<input type="hidden" id="chatHistoryRout" value="{{route('customer.live-chat.chat-history')}}">

<input type="hidden" id="pusher_app_key" value="{{getOption('pusher_app_key')}}">
<input type="hidden" id="pusher_cluster" value="{{getOption('pusher_cluster')}}">
<input type="hidden" id="pusher_chanel" value="{{getOption('pusher_chanel_name')}}">
<input type="hidden" id="receiverid" value="">

<button class="round-button" onclick="openForm()"><i class="fa fa-message icon-size"></i></button>
<div class="chat-popup" id="myForm">
    <div class="chat-inbox-area-part">
        <div class="tab-content chat" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                 tabindex="0">
                <div class="chart-area-start">
                    <div class="chart-banner">
                        <div class="d-flex align-content-center justify-content-between">
                            <div class="logo-chart">
                                <img src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_footer_logo')) }}"
                                     alt="{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }}">
                            </div>
                            <div class="close-tab-chart">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                        </div>
                        <h5 class="need-help">
                            {{getChatConfiguration(1, 'chat_title')}}
                        </h5>
                    </div>
                    <div class="typicall-max-hight">
                        <div class="single-typically-part">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="typicall-text-part">
                                    <h5 class="typically-title">
                                        {{getChatConfiguration(1, 'message_title')}}
                                    </h5>
                                    <p> {{getChatConfiguration(1, 'message_discription')}}</p>
                                </div>
                                <button class="sent-btu new-ticket-create" id="new-ticket">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17" viewBox="0 0 19 17"
                                         fill="none">
                                        <path
                                            d="M18.1378 8.72015C18.1375 8.57735 18.0964 8.43761 18.0194 8.31737C17.9423 8.19712 17.8326 8.10137 17.703 8.04137L1.7939 0.617128C1.65512 0.554676 1.50063 0.535922 1.35094 0.563357C1.20125 0.590792 1.06344 0.663118 0.955834 0.770728C0.848224 0.878338 0.775899 1.01614 0.748464 1.16583C0.721028 1.31552 0.739782 1.47001 0.802233 1.60879L3.5386 7.98303L10.2734 7.97243L10.2734 9.46788L3.51738 9.46788L0.786324 15.8474C0.72695 15.9854 0.710374 16.138 0.738739 16.2855C0.767103 16.433 0.839105 16.5686 0.945416 16.6747C1.05478 16.7797 1.19339 16.849 1.34296 16.8736C1.49254 16.8983 1.64606 16.877 1.78329 16.8126L17.6924 9.38834C17.8223 9.33064 17.9332 9.2372 18.0121 9.11889C18.0909 9.00059 18.1346 8.8623 18.1378 8.72015Z"
                                            fill="#6659FF"/>
                                    </svg>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                 tabindex="0">
                <div class="chart-area-start">
                    <div class="messages-title">
                        <div class="d-flex align-content-center">

                            <div class="messages-title-text">
                                <h6 class="">
                                    {{__('History')}}
                                </h6>

                            </div>
                            <div class="close-tab-chart">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                        </div>
                    </div>
                    <div id="chatHistoryList">

                    </div>
                </div>
            </div>
        </div>

        <div class="chat-part-bg">

            <ul class="nav nav-pills mb-3 chat-part-tab" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active chat-home" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">
                    <span class="icon-chart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <path
                            d="M12.6765 6.00647L18.2647 11.0359V19.7647H16.0294V13.0588H9.32353V19.7647H7.08823V11.0359L12.6765 6.00647ZM12.6765 3L1.5 13.0588H4.85294V22H11.5588V15.2941H13.7941V22H20.5V13.0588H23.8529L12.6765 3Z"
                            fill="#737C90"/>
                        </svg>
                    </span>
                        <span class="chart-tab-text">
                        {{__("Home")}}
                    </span>
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link chat-history" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">
                    <span class="icon-chart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M20 2C20.5304 2 21.0391 2.21071 21.4142 2.58579C21.7893 2.96086 22 3.46957 22 4V16C22 16.5304 21.7893 17.0391 21.4142 17.4142C21.0391 17.7893 20.5304 18 20 18H6L2 22V4C2 3.46957 2.21071 2.96086 2.58579 2.58579C2.96086 2.21071 3.46957 2 4 2H20ZM4 4V17.17L5.17 16H20V4H4ZM6 7H18V9H6V7ZM6 11H15V13H6V11Z"
                                fill="#737C90"/>
                        </svg>
                    </span>
                        <span class="chart-tab-text">
                            {{__("History")}}
                    </span>
                    </button>
                </li>
            </ul>
        </div>

    </div>


    {{-- new ticket create start --}}
    <div class="new-ticket-box ticket-box-customer ">
        <div class="customer-chat-banner">
            <div class="back-button-chat">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M23 12H5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 19L5 12L12 5" stroke="white" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="customer-user-info-chat">
                <div class="customer-user-img-chat">
                    <img src="{{asset('assets/images/no-image.jpg')}}" alt="">
                </div>
                <div class="customer-user-text-chat">
                    <h4 class="customer-user-name-chat">{{__("Agent")}}</h4>
                </div>
            </div>
        </div>
        <div class="chart-customer-area">
            <div class="customer-all-chart msg-board-customer m-0 chat-customer-thread-{{auth()->id()}}">

            </div>
            <form class="ajax reset" action="{{route('customer.live-chat.send-msg')}}" method="post"
                  data-handler="msgSentResponse" id="chatForm">
                @csrf
                <div class="input-box-part">
                    <input type="hidden" name="receiver_id" id="receiverId" value="">
                    <div class="reply-input-icon">
                        <div class="reply-input-img">
                            <div class="upload__box">
                                <div class="upload__btn-box">
                                    <label class="upload__btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18"
                                             viewBox="0 0 17 18" fill="none">
                                            <path
                                                d="M16.1111 8.50079L8.96692 15.635C7.14438 17.455 4.18945 17.455 2.36691 15.635C0.544364 13.815 0.544364 10.8642 2.36691 9.04421L9.51109 1.91C10.7261 0.696667 12.6961 0.696667 13.9111 1.91C15.1261 3.12333 15.1261 5.09053 13.9111 6.30386L6.75914 13.4381C6.15163 14.0447 5.16665 14.0447 4.55914 13.4381C3.95162 12.8314 3.95162 11.8478 4.55914 11.2411L11.1592 4.6581"
                                                stroke="#737C90" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                        </svg>
                                        <input type="file" name="file[]" multiple="" data-max_length="20"
                                               class="upload__inputfile d-none">
                                    </label>
                                </div>
                                <div class="upload__img-wrap"></div>
                            </div>
                        </div>

                    </div>
                    <div class="massage">
                        <input type="text" placeholder="{{ __('Message') }}" class="input-field-reset input-field" name="message" required>
                    </div>
                    <button type="submit" class=" customer-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <circle cx="20" cy="20" r="20" fill="#6659FF"/>
                            <path
                                d="M27.7961 12.1941C27.7061 12.1046 27.5925 12.0426 27.4685 12.0154C27.3445 11.9883 27.2153 11.9971 27.0961 12.0408L12.4302 17.3739C12.3037 17.4219 12.1948 17.5072 12.118 17.6185C12.0412 17.7298 12 17.8619 12 17.9972C12 18.1325 12.0412 18.2645 12.118 18.3759C12.1948 18.4872 12.3037 18.5725 12.4302 18.6205L18.1566 20.907L22.383 16.6672L23.323 17.6072L19.0765 21.8537L21.3698 27.58C21.4192 27.7041 21.5047 27.8104 21.6152 27.8853C21.7257 27.9602 21.8562 28.0001 21.9897 28C22.1244 27.9972 22.2552 27.9537 22.3646 27.8752C22.4741 27.7966 22.5572 27.6868 22.603 27.56L27.9361 12.8941C27.9815 12.7762 27.9925 12.6477 27.9677 12.5238C27.9429 12.3999 27.8834 12.2855 27.7961 12.1941Z"
                                fill="white"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- new ticket create end --}}

    {{-- history ticket create start --}}
    <div class="history-ticket-box ticket-box-customer">
        <div class="customer-chat-banner">
            <div class="back-button-chat-history">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M23 12H5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 19L5 12L12 5" stroke="white" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="customer-user-info-chat">
                <div class="customer-user-img-chat">
                    <img src="{{asset('assets/images/no-image.jpg')}}" alt="">
                </div>
                <div class="customer-user-text-chat">
                    <h4 class="customer-user-name-chat">{{__("Agent")}}</h4>
                </div>
            </div>
        </div>
        <div class="chart-customer-area">
            <div class="customer-all-chart chat-history-details ">

            </div>
        </div>
    </div>
    {{-- history ticket create end --}}


</div>


<div id="zaiDeskChatPopup" class=" model-image-preview">
    <span class="closele" onclick="closeImagePreview()">&times;</span>
    <img class="modal-content" id="imagePreviewSection">
</div>

@push('script')

@endpush
