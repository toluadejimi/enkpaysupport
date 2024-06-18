<div class="ticket-info-box">
    <div class="ticket-title ">
        <h4>{{__('Ticket Info')}}</h4>
        <button class="small-btn success-btn">{{getTicketStatus($ticketData->status)}}</button>
    </div>
    @if(count($ticketDynamicFieldData)>0)
        @foreach($ticketDynamicFieldData as $field)
            <div class="ticket-info">
                <div>
                    <h5>{{$field->level}}:</h5>
                    <p>{{$field->field_value??""}}</p>
                </div>
            </div>
        @endforeach
    @endif
    <div class="ticket-info">
        <div>
            <h5>{{__('Envato Licence')}}:</h5>
            <p>{{$ticketData->envato_licence??""}}</p>
        </div>
    </div>
    <div class="ticket-info">
        <div>
            <h5>{{__('Category')}}:</h5>
            <p>{{$ticketData->category->name??""}}</p>
        </div>
    </div>
    <div class="ticket-info">
        <div>
            <h5>{{__('Created')}}:</h5>
            <p>{{$ticketData->category->name ?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ticketData->created_at)->format('d M, Y H:i:s'):""}}</p>
        </div>

    </div>
    <div class="ticket-info">
        <div>
            <h5>{{__('Last Message')}}:</h5>
            <p>{{\Carbon\Carbon::parse($ticketData->last_reply_time)->diffForHumans()}}</p>
        </div>
    </div>
    <div class="ticket-info">
        <div>
            <h5>{{__('Priority')}}:</h5>
            <p class="{{$ticketData->priority?getPriorityColor($ticketData->priority):"generally-color"}}">{{$ticketData->priority?getPriorityStatus($ticketData->priority):""}}</p>
        </div>
    </div>

</div>
