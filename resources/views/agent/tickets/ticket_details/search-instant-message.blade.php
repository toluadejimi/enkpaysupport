@if(!empty($searchData))
    <div class="all-user-search">
        @foreach($searchData as $istMsg)
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
@else
    <p class="">{{__("Data Not Found!")}}</p>
@endif
