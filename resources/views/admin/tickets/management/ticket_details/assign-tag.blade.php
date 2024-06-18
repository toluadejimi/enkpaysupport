<div class="enate">
    @if(isset($envato->envato_expired_on) && $envato->envato_expired_on == STATUS_ACTIVE)
        <div
            class="purchase-code {{($envatoData == null) || (isset($envatoDayCount) && $envatoDayCount == 0) ?'purchase-red':'purchase-green'}} ">
            <h5 class="purchase-text">{{isset($envatoData->item->name)?$envatoData->item->name:''}}</h5>
            <div class="purchase-view-btu">
                <button data-bs-toggle="modal" data-bs-target="#purchaseModal"
                        data-bs-whatever="@mdo">{{__("View Details")}}</button>
            </div>
        </div>
    @endif
    <div class="view-assign">
        <div class="tab-view-assign">
            <nav class="d-flex align-items-start assign-tag">
                <div class="nav nav-tabs justify-content-between " id="nav-tab" role="tablist">
                    <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-1">
                        <div class="dropdown">
                            <button class="view-tab assignmentsagent" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                {{__('Assignments')}}

                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="6" viewBox="0 0 12 6"
                                     fill="none">
                                    <path
                                        d="M5.87341 5.71716C6.02962 5.87337 6.28288 5.87337 6.43909 5.71716L11.4734 0.682843C11.7254 0.430857 11.5469 0 11.1906 0H1.12194C0.765574 0 0.587107 0.430857 0.839093 0.682843L5.87341 5.71716Z"
                                        fill="#6659FF"/>
                                </svg>
                            </button>
                            <div class="view-assign-tab dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <div class="user-search">
                                    <input type="text" id="adminAssignmentSearch"
                                           placeholder="{{ __('Search Admin') }}">
                                    <span><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                                <input type="hidden" id="ticketAssignRoute"
                                       value="{{ route('admin.tickets.assignTicketUser') }}">
                                <div class="all-user-search">
                                    <div class="view-user-title">
                                        <h3>{{__('Anyone')}}</h3>
                                    </div>
                                    @foreach ($userList as $user)
                                        <div class="view-user-list justify-content-between">
                                            <div class="d-flex gap-2 align-items-center">
                                                <div>
                                                    <img src="{{ getFileUrl($user->image) }}" alt="">
                                                </div>
                                                <h2 class="">{{ $user->name.'('.getRoleName(USER_ROLE_AGENT).')' }}</h2>
                                            </div>

                                            <div class="selectBoxTage">
                                                <div class="round ">
                                                    <input type="checkbox" name="ticket_assignee[]"
                                                           id="ticket_assignee_{{$user->id}}"
                                                           onclick="addUserToTicket({{$ticketData->id}},{{ $user->id }})"
                                                           @if(in_array($user->id,$ticketUserData)) checked @endif />
                                                    <label for="ticket_assignee_{{$user->id}}" class="top-0"></label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="view-tab taggingagent" role="button" id="dropdownMenuLink1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16"
                                     fill="none">
                                    <path
                                        d="M3.75625 2.4C3.51891 2.4 3.28691 2.47038 3.08957 2.60224C2.89223 2.73409 2.73842 2.92151 2.6476 3.14078C2.55677 3.36005 2.53301 3.60133 2.57931 3.83411C2.62561 4.06689 2.7399 4.28071 2.90772 4.44853C3.07555 4.61635 3.28936 4.73064 3.52214 4.77694C3.75492 4.82325 3.9962 4.79948 4.21547 4.70866C4.43474 4.61783 4.62216 4.46402 4.75401 4.26669C4.88587 4.06935 4.95625 3.83734 4.95625 3.6C4.95625 3.28174 4.82982 2.97652 4.60478 2.75147C4.37973 2.52643 4.07451 2.4 3.75625 2.4ZM3.75625 2.4C3.51891 2.4 3.28691 2.47038 3.08957 2.60224C2.89223 2.73409 2.73842 2.92151 2.6476 3.14078C2.55677 3.36005 2.53301 3.60133 2.57931 3.83411C2.62561 4.06689 2.7399 4.28071 2.90772 4.44853C3.07555 4.61635 3.28936 4.73064 3.52214 4.77694C3.75492 4.82325 3.9962 4.79948 4.21547 4.70866C4.43474 4.61783 4.62216 4.46402 4.75401 4.26669C4.88587 4.06935 4.95625 3.83734 4.95625 3.6C4.95625 3.28174 4.82982 2.97652 4.60478 2.75147C4.37973 2.52643 4.07451 2.4 3.75625 2.4ZM15.6842 7.664L8.48425 0.464C8.18426 0.166464 7.77877 -0.000336659 7.35625 5.1017e-07H1.75625C1.3319 5.1017e-07 0.924938 0.168571 0.62488 0.46863C0.324821 0.768688 0.156251 1.17565 0.156251 1.6V7.2C0.156083 7.41113 0.197703 7.6202 0.278712 7.81518C0.359721 8.01015 0.478516 8.18715 0.62825 8.336L0.95625 8.656C1.46632 8.35059 2.0319 8.14938 2.62025 8.064L1.75625 7.2V1.6H7.35625L14.5563 8.8L8.95625 14.4L8.09225 13.536C8.00792 14.1246 7.80663 14.6904 7.50025 15.2L7.82825 15.528C8.12693 15.8285 8.53259 15.9982 8.95625 16C9.37991 15.9982 9.78557 15.8285 10.0843 15.528L15.6842 9.928C15.9847 9.62932 16.1545 9.22366 16.1562 8.8C16.1564 8.58887 16.1148 8.3798 16.0338 8.18483C15.9528 7.98986 15.834 7.81285 15.6842 7.664ZM3.75625 2.4C3.51891 2.4 3.28691 2.47038 3.08957 2.60224C2.89223 2.73409 2.73842 2.92151 2.6476 3.14078C2.55677 3.36005 2.53301 3.60133 2.57931 3.83411C2.62561 4.06689 2.7399 4.28071 2.90772 4.44853C3.07555 4.61635 3.28936 4.73064 3.52214 4.77694C3.75492 4.82325 3.9962 4.79948 4.21547 4.70866C4.43474 4.61783 4.62216 4.46402 4.75401 4.26669C4.88587 4.06935 4.95625 3.83734 4.95625 3.6C4.95625 3.28174 4.82982 2.97652 4.60478 2.75147C4.37973 2.52643 4.07451 2.4 3.75625 2.4ZM6.55625 13.6H4.15625V16H2.55625V13.6H0.156251V12H2.55625V9.6H4.15625V12H6.55625V13.6Z"
                                        fill="#FB5C66"/>
                                </svg>
                                {{__('Tagging')}}
                            </button>
                            <div class=" view-assign-tab dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                <div class="view-user-title">
                                    <h3>{{__('Add Tags')}}</h3>
                                </div>
                                <div class="user-search">
                                    <input type="text" id="adminTagSearch" placeholder="{{ __('Search Tags') }}">
                                    <span><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                                <input type="hidden" id="addTagRoute"
                                       value="{{ route('admin.tickets.addTicketTags') }}">
                                <div class="all-user-search">
                                    @foreach($allTagsData as $tag)
                                        <div class="view-user-list">
                                            <div class="selectBoxTage">
                                                <div class="round">
                                                    <input type="checkbox" name="ticket_tag[]"
                                                           id="ticket_tag_{{$tag->id}}"
                                                           onclick="addTagToTicket({{$ticketData->id}},{{ $tag->id }})"
                                                           @if(in_array($tag->id,$existingTagsData['ids'])) checked @endif />
                                                    <label for="ticket_tag_{{$tag->id}}" class="top-0"></label>
                                                </div>
                                            </div>
                                            <p>{{$tag->name}}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <span id="noneClick" class=""></span>
                        <div class="d-flex gap-1 align-self-start pb-30">
                            @foreach ($userList as $user)
                                @if(in_array($user->id,$ticketUserData))
                                    @if( $user->image == null)
                                        <div class="ticket-assign-name border flex-shrink-0">
                                            <h5>{{ucfirst(substr($user->name,0,2))}}</h5></div>
                                    @else
                                        <div
                                            class="header-profile-user-img flex-shrink-0 rounded-circle overflow-hidden">
                                            <img title="{{$user->name.'('.$user->email.')'}}"
                                                 class="rounded-circle avatar-xs fit-image"
                                                 src={{ getFileUrl($user->image) }} alt="img"></div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
                <span class="deleteLayout " id="notifiBtu-1">
                <i class="fa-solid fa-ellipsis-vertical"></i>
                 <div class="show-of showDictive agent " id="show-of">
    {{--                  <a target="_blank" href="{{route('admin.tickets.my-ticket-history', ['id'=>$ticketCreatorData->id])}}"--}}
                     {{--                     class="viewHistory">{{__('All Tickets')}}</a>--}}
                   <a href="{{route('admin.tickets.my-ticket-history', ['id'=>$ticketCreatorData->id])}}">
                    <div class="delete-notifi notifi-close-btu">
                       <p>{{__('All Tickets')}}</p>
                    </div>
                   </a>
                </div>
              </span>
            </nav>


        </div>

        <div class="ticket-details">
            <h3 class="mt-4">#{{$ticketData->tracking_no??""}}-{{$ticketData->ticket_title??""}}</h3>
            <div class="sf-fixed-p m-1 p-1">
                <p>{!! nl2br($ticketData->ticket_description)??"" !!}</p>
            </div>
        </div>
        <div class="tag-key-word mb-4">
            @isset($existingTagsData['names'])
                @foreach($existingTagsData['names'] as $tagNames)
                    <span> {{$tagNames}}</span>
                @endforeach
            @endisset
        </div>

        <div class="image-type">
            @if($ticketData->file_id)
                <div class="file-type mb-3">
                    @foreach(json_decode($ticketData->file_id) as $key=>$fileData)
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

        <!--  Add purchaseModalLabel model start -->
        <div class="modal fade" id="purchaseModal" tabindex="-2" aria-labelledby="purchaseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div class="purchase-model-text">
                        <div class="purchase-details-header">
                            <h5>{{__("Purchase Details")}}</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="client-details-bg alert alert-danger">

                            @if($envatoData == null)
                                <p class="alert alert-danger mt-3 mx-3 py-4 h4">{{__('Purchase code not valid!')}}</p>
                            @else
                                <div class="client-details-area">

                                    <h4 class="client-border-details">{{__('Client Details:')}}</h4>
                                    <div class="item-icon-client">
                                        <h4 class="item-icon">{{__("Item Icon")}}: </h4>
                                        <img src="{{isset($envatoData->item->previews->icon_preview->icon_url)?$envatoData->item->previews->icon_preview->icon_url:''}}" alt="">
                                    </div>
                                </div>
                                <div class="client-item-details">
                                    <div class="single-client-item-info">
                                        <div class="client-item-info">
                                            <h5 >{{__("Item Name")}}:</h5>
                                        </div>
                                        <p>{{isset($envatoData->item->name)?$envatoData->item->name:''}}</p>
                                    </div>
                                    <div class="single-client-item-info">
                                        <div class="client-item-info">
                                            <h5 >{{__("Client")}}:</h5>
                                        </div>
                                        <p>{{isset($envatoData->buyer)?$envatoData->buyer:''}}</p>
                                    </div>
                                    <div class="single-client-item-info">
                                        <div class="client-item-info">
                                            <h5 >{{__("Sold At")}}:</h5>
                                        </div>
                                        <p>{{isset($envatoData->sold_at)?date('d-m-Y',strtotime($envatoData->sold_at)):''}} <span> {{isset($envatoData->sold_at)?date('H:i:s',strtotime($envatoData->sold_at)):''}}</span></p>
                                    </div>
                                    <div class="single-client-item-info">
                                        <div class="client-item-info">
                                            <h5 >{{__("Support Until")}}:</h5>
                                        </div>
                                        <p>{{isset($envatoData->supported_until)?date('d-m-Y',strtotime($envatoData->supported_until)):''}} <span>{{isset($envatoData->supported_until)?date('H:i:s',strtotime($envatoData->supported_until)):''}}</span>
                                            @if(isset($envatoDayCount) && $envatoDayCount != 0)
                                                <span class="small-btn success-btn ms-3">{{__("Supported")}}</span>
                                            @else
                                                <span class="small-btn danger-btn ms-3">{{__("License Expiry")}}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="single-client-item-info">
                                        <div class="client-item-info">
                                            <h5 >{{__("License")}}:</h5>
                                        </div>
                                        <p>{{isset($envatoData->license)?$envatoData->license:''}}</p>
                                    </div>
                                    <div class="single-client-item-info mb-0">
                                        <div class="client-item-info">
                                            <h5 >{{__("Count")}}:</h5>
                                        </div>
                                        <p>{{isset($envatoData->purchase_count)?$envatoData->purchase_count:0}}</p>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--  Add purchaseModalLabel model end -->

</div>
