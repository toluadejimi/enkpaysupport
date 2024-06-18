@php
$counter = 1;
@endphp
@foreach($conversationData as $conversation)
<div class="view-post  @if($conversation->user->role == USER_ROLE_ADMIN) admin @elseif($conversation->user->role == USER_ROLE_AGENT) maintainer @else customer @endif ">
<div class="single-post-view">
    <div class="chat-user-img ">
         <img src="{{ getFileUrl($conversation->user->image) }}" alt="">
    </div>
    <div class="auth-user-post w-100">
    <div class="auth-user-info">
        <div class="auth-user-title">
        <h2>{{getAgentFakeNameConfig2($conversation->user->tenant_id)==1?$conversation->user->username??"No Name":$conversation->user->name}}</h2>
        <p class="roll">{{getRoleName($conversation->user->role)}}</p>
        </div>
        <div class="post-date">
        <p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $conversation->created_at)->format('Y-m-d')}} | {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $conversation->created_at)->format('g:i A')}}</p>
            <p class="">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $conversation->created_at )->diffForHumans()}}</p>
        </div>
    </div>
    <p>{!!nl2br(strip_tags($conversation->body))!!}</p>

        <div class="image-type">
            @if($conversation->file_id)
                <div class="file-type mb-3">
                    @foreach(json_decode($conversation->file_id) as $key=>$fileData)
                        @if(in_array(getFileType($fileData), ['image/jpeg','image/jpg','image/png','image/webp']))
                            <a class="test-popup-link" href="{{ getFileUrl($fileData) }}"><img
                                    src="{{ getFileUrl($fileData) }}" alt=""></a>
                        @else
                            <a href="{{ getFileUrl($fileData) }}" target="_blank">
                                <button>{{getFileName($fileData)}}</button>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
</div>
@php
$counter++;
@endphp
@endforeach

