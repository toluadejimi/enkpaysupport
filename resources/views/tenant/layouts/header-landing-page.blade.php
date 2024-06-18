<header class=" all-top">
    <div class="header-area header">

        <div class="">
            <div class="container">
                <div class="header-element">
                    <div class="header-logo">
                        <a href="{{route('frontend')}}">
                            <img src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_logo')) }}" alt="{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }}">
                        </a>
                    </div>
                    <div class="header-menu pageMenu">
                        <ul id="nav" class="nan">
                            <li><a href="{{route('frontend')}}">{{__("Home")}}</a></li>
                            <li><a href="{{route('tenant.knowledge')}}">{{__("Knowledge")}}</a></li>
                            <li><a href="{{route('tenant.faqs')}}">{{__("FAQ,s")}}</a></li>
                            <li><a href="{{route('tenant.contact.us.index')}}">{{__("Contact Us")}}</a></li>

                            @if(Auth::check())
                                @if(auth()->user()->role == USER_ROLE_AGENT)
                                    <li class="down-btu-hide"><a href="{{route('agent.dashboard')}}" class="down-btu">{{__("Dashboard")}}</a>
                                    </li>
                                @else
                                    <li class="down-btu-hide"><a href="{{route('customer.dashboard')}}"
                                                                 class="down-btu">{{__("Dashboard")}}</a></li>
                                @endif
                            @else
                                <li class="down-btu-hide"><a href="{{route('ticket.guest-create-ticket')}}" class="down-btu theme-color">{{__("Create Ticket")}}</a></li>
                                <li class="down-btu-hide"><a href="{{route('login')}}" class="down-btu">{{__("Sign In")}}</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown langHome d-inline-block me-4">
                            <button type="button" class="header-item" id="page-header-user-dropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle avatar-xs fit-image header-profile-user"
                                     src="{{asset(selectedLanguage()?->flag)}}">
                            </button>
                            <div class="dropdown-menu dropdown-menu-lang" aria-labelledby="page-header-user-dropdown">
                                <!-- item-->
                                @foreach(appLanguages() as $app_lang)
                                    <a href="#" class="notification-item">
                                        <div class="d-flex align-items-center gap-4 mb-3 ps-2">
                                            <div>
                                                <img class="rounded-circle avatar-xs fit-image header-profile-user"
                                                     src="{{asset($app_lang->flag)}}" alt="Header Avatar">
                                            </div>
                                            <div class="flex-1">
                                                <p class="mb-1">{{$app_lang->language}}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        </div>

                        @if(Auth::check())
                            @if(auth()->user()->role == USER_ROLE_AGENT)
                                <a href="{{route('agent.dashboard')}}" class="down-btu ">{{__("Dashboard")}}</a>
                            @elseif(auth()->user()->role == USER_ROLE_SUPER_ADMIN)
                                <a href="{{route('admin.dashboard')}}" class="down-btu ">{{__("Dashboard")}}</a>
                            @else
                                <a href="{{route('customer.dashboard')}}" class="down-btu">{{__("Dashboard")}}</a>
                            @endif
                        @else
                            <a href="{{route('ticket.guest-create-ticket')}}" class="down-btu theme-color">{{__("Create Ticket")}}</a>
                            <a href="{{route('login')}}" class="down-btu ms-3">{{__("Sign In")}}</a>
                        @endif
                        <div class="header-toggle">

                            <div class="menu-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</header>
