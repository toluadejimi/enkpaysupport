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
                <div>
                    <span class="ticket-details-dynamic-filed-edit-action" data-id="{{$field->id}}"
                          data-value="{{$field->field_value??""}}" data-filed_type="{{$field->type}}"
                          data-level="{{$field->level}}" data-required="{{$field->required}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                               fill="none">
                            <rect width="25" height="25" rx="5" fill="#6659FF"/>
                            <g clip-path="url(#clip0_846_1766)">
                              <path
                                  d="M11.875 7.49996H7.5C7.16848 7.49996 6.85054 7.63166 6.61612 7.86608C6.3817 8.1005 6.25 8.41844 6.25 8.74996V17.5C6.25 17.8315 6.3817 18.1494 6.61612 18.3838C6.85054 18.6183 7.16848 18.75 7.5 18.75H16.25C16.5815 18.75 16.8995 18.6183 17.1339 18.3838C17.3683 18.1494 17.5 17.8315 17.5 17.5V13.125"
                                  stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path
                                  d="M16.5625 6.56237C16.8111 6.31373 17.1484 6.17405 17.5 6.17405C17.8516 6.17405 18.1889 6.31373 18.4375 6.56237C18.6861 6.81102 18.8258 7.14824 18.8258 7.49987C18.8258 7.85151 18.6861 8.18873 18.4375 8.43737L12.5 14.3749L10 14.9999L10.625 12.4999L16.5625 6.56237Z"
                                  stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                              <clipPath id="clip0_846_1766">
                                <rect width="15" height="15" fill="white" transform="translate(5 5)"/>
                              </clipPath>
                            </defs>
                          </svg>
                    </span>
                </div>
            </div>
        @endforeach
    @endif
    @if($envato?->enable_purchase_code == 1)
        <div class="ticket-info">
            <div>
                <h5>{{__('Licence')}}:</h5>
                <p>{{$ticketData->envato_licence??""}}</p>
            </div>
            <div>
                                <span class="license-edit-action" data-id="{{$ticketData->id}}"
                                      data-value="{{$ticketData->envato_licence??""}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                               fill="none">
                            <rect width="25" height="25" rx="5" fill="#6659FF"/>
                            <g clip-path="url(#clip0_846_1766)">
                              <path
                                  d="M11.875 7.49996H7.5C7.16848 7.49996 6.85054 7.63166 6.61612 7.86608C6.3817 8.1005 6.25 8.41844 6.25 8.74996V17.5C6.25 17.8315 6.3817 18.1494 6.61612 18.3838C6.85054 18.6183 7.16848 18.75 7.5 18.75H16.25C16.5815 18.75 16.8995 18.6183 17.1339 18.3838C17.3683 18.1494 17.5 17.8315 17.5 17.5V13.125"
                                  stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                              <path
                                  d="M16.5625 6.56237C16.8111 6.31373 17.1484 6.17405 17.5 6.17405C17.8516 6.17405 18.1889 6.31373 18.4375 6.56237C18.6861 6.81102 18.8258 7.14824 18.8258 7.49987C18.8258 7.85151 18.6861 8.18873 18.4375 8.43737L12.5 14.3749L10 14.9999L10.625 12.4999L16.5625 6.56237Z"
                                  stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                              <clipPath id="clip0_846_1766">
                                <rect width="15" height="15" fill="white" transform="translate(5 5)"/>
                              </clipPath>
                            </defs>
                          </svg>
                    </span>
            </div>
        </div>
    @endif
    {{--    <div class="ticket-info">--}}
    {{--        <div>--}}
    {{--            <h5>{{__('Domain')}}:</h5>--}}
    {{--            <p><a href="{{$ticketData->domain??""}}" target="_blank">{{$ticketData->domain??""}}</a></p>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="ticket-info">
        <div>
            <h5>{{__('Category')}}:</h5>
            <p>{{$ticketData->category->name??""}}</p>
        </div>
        <div>
        <span data-bs-toggle="modal" data-bs-target="#categorymodel" data-bs-whatever="@mdo">

          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
            <rect width="25" height="25" rx="5" fill="#6659FF"/>
            <g clip-path="url(#clip0_846_1766)">
              <path
                  d="M11.875 7.49996H7.5C7.16848 7.49996 6.85054 7.63166 6.61612 7.86608C6.3817 8.1005 6.25 8.41844 6.25 8.74996V17.5C6.25 17.8315 6.3817 18.1494 6.61612 18.3838C6.85054 18.6183 7.16848 18.75 7.5 18.75H16.25C16.5815 18.75 16.8995 18.6183 17.1339 18.3838C17.3683 18.1494 17.5 17.8315 17.5 17.5V13.125"
                  stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
              <path
                  d="M16.5625 6.56237C16.8111 6.31373 17.1484 6.17405 17.5 6.17405C17.8516 6.17405 18.1889 6.31373 18.4375 6.56237C18.6861 6.81102 18.8258 7.14824 18.8258 7.49987C18.8258 7.85151 18.6861 8.18873 18.4375 8.43737L12.5 14.3749L10 14.9999L10.625 12.4999L16.5625 6.56237Z"
                  stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            <defs>
              <clipPath id="clip0_846_1766">
                <rect width="15" height="15" fill="white" transform="translate(5 5)"/>
              </clipPath>
            </defs>
          </svg>
        </span>
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
        <div>
        <span data-bs-toggle="modal" data-bs-target="#prioritymodel" data-bs-whatever="@mdo">

          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
            <rect width="25" height="25" rx="5" fill="#6659FF"/>
            <g clip-path="url(#clip0_846_1766)">
              <path
                  d="M11.875 7.49996H7.5C7.16848 7.49996 6.85054 7.63166 6.61612 7.86608C6.3817 8.1005 6.25 8.41844 6.25 8.74996V17.5C6.25 17.8315 6.3817 18.1494 6.61612 18.3838C6.85054 18.6183 7.16848 18.75 7.5 18.75H16.25C16.5815 18.75 16.8995 18.6183 17.1339 18.3838C17.3683 18.1494 17.5 17.8315 17.5 17.5V13.125"
                  stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
              <path
                  d="M16.5625 6.56237C16.8111 6.31373 17.1484 6.17405 17.5 6.17405C17.8516 6.17405 18.1889 6.31373 18.4375 6.56237C18.6861 6.81102 18.8258 7.14824 18.8258 7.49987C18.8258 7.85151 18.6861 8.18873 18.4375 8.43737L12.5 14.3749L10 14.9999L10.625 12.4999L16.5625 6.56237Z"
                  stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            <defs>
              <clipPath id="clip0_846_1766">
                <rect width="15" height="15" fill="white" transform="translate(5 5)"/>
              </clipPath>
            </defs>
          </svg>
        </span>
        </div>
    </div>

    @if($ticketData->status_change_by)
        <div class="ticket-info">
            <div>
                <h5>{{__('Status Change By ')}}:</h5>
                <p class="">{{getUserFullNameUsingID($ticketData->status_change_by).' ('.getUserEmailById($ticketData->status_change_by).')'}}</p>
            </div>
        </div>
    @endif

    <div class="ticket-info py-2">
        <div>
            <h5>{{__('Customer Info ')}}:</h5>
            <div class="d-flex">
                <div class="d-flex gap-1 pb-3">
                    <div class="d-flex gap-1 align-items-center">
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
                </div>
            </div>
        </div>
    </div>


</div>
