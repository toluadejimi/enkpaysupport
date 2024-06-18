 @if(count($history)>0)
    @foreach($history as $chatHistory)
        <div class='history-ticket' data-id="{{$chatHistory->last()->session_id}}">
            <div class="single-personal position-relative">
                @if($chatHistory->first()->session_thread->status == 1)
                <div class="circle"></div>
                @endif
                <div class="personal-image">
                    @foreach($chatHistory->chat_users as $c)
                        <div class="agent-img">
                            <img src="{{getFileUrl($c)}}" alt="">
                        </div>
                    @endforeach
                </div>
                <div class="customer-name-info">
                    <h6 class="customer-name-chart">
                        {{$chatHistory->last()->message}}
                    </h6>
                    <p> {{$chatHistory->last()->created_at }} <span class="time-left-count">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $chatHistory->last()->created_at )->diffForHumans()}}</span></p>
                </div>
            </div>
        </div>
    @endforeach
@else
@endif
 <script src="{{asset('customer/assets/js/custom/chat_history.js') }}"></script>

