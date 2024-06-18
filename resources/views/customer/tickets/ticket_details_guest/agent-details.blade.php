<div class="ticket-info-box mt-5">
    <div class="ticket-title ">
        <h4>{{__('Agent Details')}}</h4>
    </div>
        @forelse($ticketUserData as $assignedAgent)
            <div class="ticket-info-img">
                <div class="ticket-user-name">

                    <div class="view-post p-0 w-100">
                        <div class="single-post-view">
                            <div class="customer-user-img">
                                 @if( $assignedAgent['image'] == null)
                                    <div><div class="ticket-assign-name border"><h5>{{ucfirst(substr($assignedAgent['name'],0,2))}}</h5></div></div>
                                @else
                                    <div class="header-profile-user-img"><img title="{{$assignedAgent['name']}}" class="rounded-circle avatar-xs fit-image" src={{ getFileUrl($assignedAgent['image']) }} alt="img"></div>
                                @endif
                            </div>
                            <div class="auth-user-post w-100">
                                <div class="auth-user-info">
                                    <div class="auth-user-title">
                                        <h2>{{getAgentFakeNameConfig2($assignedAgent['tenant_id'])==1?$assignedAgent['username']??"No Name":$assignedAgent['name']}}</h2>
                                        <p class="roll">{{getRoleName($assignedAgent['role'])}}</p>
                                    </div>
                                </div>
                                @if(getOption('agent_rating_status') == 1)
                                    @php
                                        if( getAgentRatingById($assignedAgent['id'])['rating_avg'] > 0 ){
                                        $rating = round(getAgentRatingById($assignedAgent['id'])['rating_avg']);
                                        }
                                    @endphp
                                    @if(!empty($rating))
                                        <div class="rating-view-container">
                                        @for ($i = 1; $i <= 5; $i++)
                                        @if($i<=$rating)
                                            <div class="rating-view-select">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                            @else
                                            <div class="rating-view-init">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                            @endif
                                        @endfor
                                        </div>
                                        @else
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        @empty
            <div class="notes-not-yet">
                <div class="notes-not-img">
                    <img src="../../../assets/images/no-data.png" alt="">
                </div>
                <h5 class="notes-not-title">{{__('Don’t have any agent yet.')}}</h5>
                <p class="notes-not-yet">{{__('Add your agent here.')}}</p>
            </div>

        @endforelse
</div>
