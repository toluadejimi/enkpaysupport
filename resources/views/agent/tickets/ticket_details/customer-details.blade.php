<div class="ticket-info-box mt-5">
    <div class="ticket-title ticket-2">
        <h4>{{__('Customer Details')}}</h4>
        <div>
            <a target="_blank" href="{{route('agent.ticket.my-ticket-history', ['id'=>$ticketCreatorData->id])}}"
               class="viewHistory">{{__('Previous Tickets')}}</a>
        </div>
    </div>
    <div class="align-items-center d-flex gap-3 pb-3">
        <div class="sf-img">
            <img src="{{ getFileUrl($ticketCreatorData->image) }}" alt="">
        </div>
        <div class="ticket-user-name">
            <h5>
                {{$ticketCreatorData->name??''}}
            </h5>
            <p>{{$ticketCreatorData->email??''}}</p>
            <p>{{$ticketCreatorData->mobile??''}}</p>
        </div>

    </div>
    <div class="ticket-info">
        <div>
            <h5>{{__('IP Address :')}}</h5>
            <p>{{$ticketData->activityLog->ip_address??''}}</p>
        </div>
    </div>
    @if($ticketCreatorData->address != null)
            <div class="ticket-info">
                <div>
                    <h5>{{__('Location')}}:</h5>
                    <p>{{$ticketCreatorData->address??''}}</p>
                </div>

            </div>
    @endif

    @if($ticketCreatorData->app_timezone != null)
        <div class="ticket-info">
            <div>
                <h5>{{__('Timezone')}}:</h5>
                <p>{{$ticketCreatorData->app_timezone??''}}</p>
            </div>
        </div>
    @endif

</div>
