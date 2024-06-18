
<div class="chart-customer-area">
    <div class="customer-all-chart msg-board-customer m-0 chat-customer-thread-{{auth()->id()}}">
        @if(count($chat)>0)
            @foreach($chat as $chatData)
                    @if($chatData->sender_id != auth()->id())
                        <div class="customer-single-massages agent">
                            <div class="customer-name ">
                                <h5 class="text-end">{{$chatData->user_name}} <span>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $chatData->created_at)->diffForHumans()}}</span></h5>
                                @if($chatData->message !=null)
                                    <p class="customer-massages agent-name">
                                        {{$chatData->message}}
                                    </p>
                                @endif
                                @if($chatData->file !=null)
                                    <div class="image-type mt-2">
                                        @foreach(json_decode($chatData->file) as $fileData)
                                            <img id="myImg1" src="{{getFileUrl($fileData)}}" class="uplodimg rounded"  alt="Snow" onclick="imagePreview('{{getFileUrl($fileData)}}')">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="single-img-customer">
                                <img src="{{getFileUrl($chatData->image)}}" alt="">
                            </div>
                        </div>
                    @else
                        <div class="customer-single-massages">
                            <div class="single-img-customer">
                                <img src="{{getFileUrl($chatData->image)}}" alt="">
                            </div>
                            <div class="customer-name">
                                <h5>{{$chatData->user_name}} <span>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $chatData->created_at)->diffForHumans()}}</span></h5>
                                @if($chatData->message !=null)
                                <p class="customer-massages">
                                    {{$chatData->message}}
                                </p>
                                @endif
                                @if($chatData->file !=null)
                                    <div class="image-type mt-2">
                                    @foreach(json_decode($chatData->file) as $fileData)
                                            <img id="myImg" src="{{getFileUrl($fileData)}}" class="uplodimg rounded"  alt="Snow" onclick="imagePreview('{{getFileUrl($fileData)}}')">
                                    @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif


            @endforeach
        @endif
    </div>
    @if($session->status)
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
    @endif
</div>
