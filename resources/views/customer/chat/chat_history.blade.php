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
