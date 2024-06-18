@php
    $counter = 1;
@endphp
@foreach($conversationData as $conversation)
    <div
        class="view-post  @if($conversation->user->role == USER_ROLE_ADMIN) admin @elseif($conversation->user->role == USER_ROLE_AGENT) maintainer @else customer @endif ">
        <div class="single-post-view">
            <div class="chat-user-img">
                <img src="{{ getFileUrl($conversation->user->image) }}" alt="">
            </div>
            <div class="auth-user-post w-100">
                <div class="auth-user-info">
                    <div class="auth-user-title">
                        <h2>{{$conversation->user->name}}</h2>
                        <p class="roll">{{$conversation->user->email}}</p>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="post-date">
                            <p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $conversation->created_at)->format('Y-m-d')}}
                                | {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $conversation->created_at)->format('g:i A')}}</p>
                            <p class="">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $conversation->created_at )->diffForHumans()}}</p>
                        </div>
                        <div class="dropdown {{$conversation->user->role == USER_ROLE_CUSTOMER?'d-none':''}}">
                            <button class="border-0 p-0 bg-transparent dropdown-toggle conversion-list-dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item edit-modal-action" data-content="{{$conversation->body}}" data-id="{{$conversation->id}}">{{__("Edit")}}</button></li>
                                <li><button class="dropdown-item delete-action" data-id="{{$conversation->id}}">{{__("Delete")}}</button></li>
                            </ul>
                            <input type="hidden" value="{{route('admin.conversations.conversation-delete')}}" id="conversation-delete-Route">
                        </div>
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

