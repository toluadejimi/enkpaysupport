<div class="enate">
    @if(isset($envatoConfigData->envato_expired_on) && $envatoConfigData->envato_expired_on == STATUS_ACTIVE)
        <div class="purchase-code {{($envatoData == null) || (isset($envatoDayCount) && $envatoDayCount == 0) ?'purchase-red':'purchase-green'}} ">
            <h5 class="purchase-text">{{isset($envatoData->item->name)?$envatoData->item->name:''}}</h5>
            <div class="purchase-view-btu">
                <button data-bs-toggle="modal" data-bs-target="#purchaseModal"
                        data-bs-whatever="@mdo">{{__("View Details")}}</button>
            </div>
        </div>
    @endif

    <div class="view-assign">
        <div class="tab-view-assign">
            <nav>
            <span class="deleteLayout " id="notifiBtu-1">

              <i class="fa-solid fa-ellipsis-vertical"></i>
              <div class="show-of showDictive agent" id="show-of">
              <a href="#" onclick="deleteTicket('{{route('agent.ticket.ticket-delete',$ticketData->id)}}')">
                <div class="delete-notifi notifi-close-btu mb-0">
                  <p>{{__('Delete')}}</p>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                       fill="none">
                    <path d="M2 4H3.33333H14" stroke="#737C90" stroke-width="1.4" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path
                        d="M5.33203 4.00004V2.66671C5.33203 2.31309 5.47251 1.97395 5.72256 1.7239C5.9726 1.47385 6.31174 1.33337 6.66536 1.33337H9.33203C9.68565 1.33337 10.0248 1.47385 10.2748 1.7239C10.5249 1.97395 10.6654 2.31309 10.6654 2.66671V4.00004M12.6654 4.00004V13.3334C12.6654 13.687 12.5249 14.0261 12.2748 14.2762C12.0248 14.5262 11.6857 14.6667 11.332 14.6667H4.66536C4.31174 14.6667 3.9726 14.5262 3.72256 14.2762C3.47251 14.0261 3.33203 13.687 3.33203 13.3334V4.00004H12.6654Z"
                        stroke="#737C90" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.66797 7.33337V11.3334" stroke="#737C90" stroke-width="1.4"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9.33203 7.33337V11.3334" stroke="#737C90" stroke-width="1.4"
                          stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
              </a>
              </div>
            </span>

                <div class="nav nav-tabs assign-tag" id="nav-tab" role="tablist">



                    <div class="dropdown">
                        <button class="view-tab assignmentsagent dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M7.57895 0C6.74618 0 5.93212 0.246943 5.2397 0.709602C4.54729 1.17226 4.00761 1.82985 3.68893 2.59923C3.37024 3.3686 3.28686 4.2152 3.44933 5.03196C3.61179 5.84872 4.0128 6.59897 4.60166 7.18782C5.19051 7.77667 5.94075 8.17768 6.75751 8.34015C7.57428 8.50261 8.42087 8.41923 9.19025 8.10055C9.95962 7.78186 10.6172 7.24219 11.0799 6.54977C11.5425 5.85735 11.7895 5.04329 11.7895 4.21053C11.7895 3.09383 11.3459 2.02286 10.5562 1.23323C9.76661 0.443608 8.69565 0 7.57895 0ZM7.57895 6.73684C7.07929 6.73684 6.59085 6.58868 6.1754 6.31108C5.75995 6.03349 5.43615 5.63893 5.24494 5.17731C5.05372 4.71568 5.0037 4.20772 5.10117 3.71767C5.19865 3.22761 5.43926 2.77746 5.79257 2.42415C6.14588 2.07084 6.59603 1.83023 7.08609 1.73275C7.57615 1.63527 8.0841 1.6853 8.54573 1.87652C9.00735 2.06773 9.40191 2.39153 9.6795 2.80698C9.9571 3.22243 10.1053 3.71087 10.1053 4.21053C10.1053 4.88055 9.8391 5.52313 9.36532 5.9969C8.89155 6.47068 8.24897 6.73684 7.57895 6.73684ZM15.1579 16V15.1579C15.1579 13.5945 14.5368 12.0952 13.4314 10.9897C12.3259 9.88421 10.8265 9.26316 9.26316 9.26316H5.89474C4.33136 9.26316 2.83201 9.88421 1.72653 10.9897C0.621051 12.0952 0 13.5945 0 15.1579V16H1.68421V15.1579C1.68421 14.0412 2.12782 12.9702 2.91745 12.1806C3.70707 11.391 4.77804 10.9474 5.89474 10.9474H9.26316C10.3799 10.9474 11.4508 11.391 12.2404 12.1806C13.0301 12.9702 13.4737 14.0412 13.4737 15.1579V16H15.1579Z"
                                    fill="#6659FF"/>
                            </svg>
                            {{__('Assignments')}}

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="6" viewBox="0 0 12 6" fill="none">
                                <path
                                    d="M5.87341 5.71716C6.02962 5.87337 6.28288 5.87337 6.43909 5.71716L11.4734 0.682843C11.7254 0.430857 11.5469 0 11.1906 0H1.12194C0.765574 0 0.587107 0.430857 0.839093 0.682843L5.87341 5.71716Z"
                                    fill="#6659FF"/>
                            </svg>
                        </button>

                        <div class="view-assign-tab dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <div class="user-search">
                                <input type="text" id="agentAssignmentSearch" placeholder="{{ __('Search Agent') }}">
                                <span><i class="fa-solid fa-magnifying-glass"></i></span>
                            </div>
                            <input type="hidden" id="ticketAssignRoute" value="{{ route('agent.ticket.assignTicketUser') }}">
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
                                            <h2 class="ticket_assignee_agent">{{ $user->name.'('.getRoleName(USER_ROLE_AGENT).')' }}</h2>
                                        </div>

                                        <div class="selectBoxTage">
                                            <div class="round">
                                                <input type="checkbox" name="ticket_assignee[]" id="ticket_assignee_{{$user->id}}"
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
                        <button class="view-tab taggingagent me-4 dropdown-toggle" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                                <path
                                    d="M3.75625 2.4C3.51891 2.4 3.28691 2.47038 3.08957 2.60224C2.89223 2.73409 2.73842 2.92151 2.6476 3.14078C2.55677 3.36005 2.53301 3.60133 2.57931 3.83411C2.62561 4.06689 2.7399 4.28071 2.90772 4.44853C3.07555 4.61635 3.28936 4.73064 3.52214 4.77694C3.75492 4.82325 3.9962 4.79948 4.21547 4.70866C4.43474 4.61783 4.62216 4.46402 4.75401 4.26669C4.88587 4.06935 4.95625 3.83734 4.95625 3.6C4.95625 3.28174 4.82982 2.97652 4.60478 2.75147C4.37973 2.52643 4.07451 2.4 3.75625 2.4ZM3.75625 2.4C3.51891 2.4 3.28691 2.47038 3.08957 2.60224C2.89223 2.73409 2.73842 2.92151 2.6476 3.14078C2.55677 3.36005 2.53301 3.60133 2.57931 3.83411C2.62561 4.06689 2.7399 4.28071 2.90772 4.44853C3.07555 4.61635 3.28936 4.73064 3.52214 4.77694C3.75492 4.82325 3.9962 4.79948 4.21547 4.70866C4.43474 4.61783 4.62216 4.46402 4.75401 4.26669C4.88587 4.06935 4.95625 3.83734 4.95625 3.6C4.95625 3.28174 4.82982 2.97652 4.60478 2.75147C4.37973 2.52643 4.07451 2.4 3.75625 2.4ZM15.6842 7.664L8.48425 0.464C8.18426 0.166464 7.77877 -0.000336659 7.35625 5.1017e-07H1.75625C1.3319 5.1017e-07 0.924938 0.168571 0.62488 0.46863C0.324821 0.768688 0.156251 1.17565 0.156251 1.6V7.2C0.156083 7.41113 0.197703 7.6202 0.278712 7.81518C0.359721 8.01015 0.478516 8.18715 0.62825 8.336L0.95625 8.656C1.46632 8.35059 2.0319 8.14938 2.62025 8.064L1.75625 7.2V1.6H7.35625L14.5563 8.8L8.95625 14.4L8.09225 13.536C8.00792 14.1246 7.80663 14.6904 7.50025 15.2L7.82825 15.528C8.12693 15.8285 8.53259 15.9982 8.95625 16C9.37991 15.9982 9.78557 15.8285 10.0843 15.528L15.6842 9.928C15.9847 9.62932 16.1545 9.22366 16.1562 8.8C16.1564 8.58887 16.1148 8.3798 16.0338 8.18483C15.9528 7.98986 15.834 7.81285 15.6842 7.664ZM3.75625 2.4C3.51891 2.4 3.28691 2.47038 3.08957 2.60224C2.89223 2.73409 2.73842 2.92151 2.6476 3.14078C2.55677 3.36005 2.53301 3.60133 2.57931 3.83411C2.62561 4.06689 2.7399 4.28071 2.90772 4.44853C3.07555 4.61635 3.28936 4.73064 3.52214 4.77694C3.75492 4.82325 3.9962 4.79948 4.21547 4.70866C4.43474 4.61783 4.62216 4.46402 4.75401 4.26669C4.88587 4.06935 4.95625 3.83734 4.95625 3.6C4.95625 3.28174 4.82982 2.97652 4.60478 2.75147C4.37973 2.52643 4.07451 2.4 3.75625 2.4ZM6.55625 13.6H4.15625V16H2.55625V13.6H0.156251V12H2.55625V9.6H4.15625V12H6.55625V13.6Z"
                                    fill="#FB5C66"/>
                            </svg>
                            {{__('Tagging')}}
                        </button>
                        <div class=" view-assign-tab dropdown-menu" aria-labelledby="dropdownMenuLink2">
                            <div class="view-user-title">
                                <h3>{{__('Add Tags')}}</h3>
                            </div>
                            <div class="user-search">
                                <input type="text" id="agentTagSearch" placeholder="{{ __('Search Tags') }}">
                                <span><i class="fa-solid fa-magnifying-glass"></i></span>
                            </div>
                            <input type="hidden" id="addTagRoute" value="{{ route('agent.ticket.addTicketTags') }}">
                            <div class="all-user-search">
                                @foreach($allTagsData as $tag)
                                    <div class="view-user-list">
                                        <div class="selectBoxTage">
                                            <div class="round">
                                                <input type="checkbox" name="ticket_tag[]" id="ticket_tag_{{$tag->id}}"
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
                    <div class="d-flex gap-1 pb-2">
                        @foreach ($userList as $user)
                            @if(in_array($user->id,$ticketUserData))
                                @if( $user->image == null)
                                    <div>
                                        <div class="ticket-assign-name border"><h5>{{ucfirst(substr($user->name,0,2))}}</h5></div>
                                    </div>
                                @else
                                    <div class="header-profile-user-img flex-shrink-0 rounded-circle overflow-hidden"><img title="{{$user->name.'('.$user->email.')'}}" class="rounded-circle avatar-xs fit-image" src={{ getFileUrl($user->image) }} alt="img"></div>
                                @endif
                            @endif
                        @endforeach
                    </div>

                </div>
            </nav>
        </div>

        <h3 class="mt-4">#{{$ticketData->tracking_no??""}}-{{$ticketData->ticket_title??""}}</h3>
        <p>{!! nl2br($ticketData->ticket_description)??"" !!}</p>
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
