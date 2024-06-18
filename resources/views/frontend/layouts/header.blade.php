<!-- header area start here  -->
<header class="header-area header">
    <div class="">
        <div class="container">
            <div class="header-element">
                <div class="header-logo">
                    <a href="{{route('frontend')}}">
                        <img src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_logo')) }}"
                             alt="{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }}">
                    </a>
                </div>
                <div class="header-menu">
                    <ul id="nav" class="nan">
                        <li class="{{ request()->is('/') ? 'active' : '' }}">
                            <a href="{{route('frontend')}}">{{__("Home")}}</a></li>
                        @if (isAddonInstalled('DESKSAAS') > 0)
                             <li><a href="{{route('pricing')}}">{{__("Pricing")}}</a></li>
                        @endif
                        <li><a href="{{route('faqs')}}">{{__("FAQ,s")}}</a></li>
                        <li><a href="{{route('contact.us.index')}}">{{__("Contact Us")}}</a></li>
                        <li><a href="{{route('login')}}" class="d-lg-none">{{__("Get Started")}}</a></li>

                    </ul>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown langHome d-inline-block me-4">
                        <button type="button" class="header-item" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle avatar-xs fit-image header-profile-user"
                                 src="{{asset(selectedLanguage()?->flag)}}">
                            <i class="fa-solid fa-chevron-down mx-2"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lang" aria-labelledby="page-header-user-dropdown">
                            <!-- item-->
                            @foreach(appLanguages() as $app_lang)
                                <a href="{{ url('/local/'.$app_lang->iso_code) }}" class="notification-item">
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
                        @if(auth()->user()->role == USER_ROLE_SUPER_ADMIN || auth()->user()->role == USER_ROLE_ADMIN)
                            <a href="{{route('admin.dashboard')}}" class="down-btu">{{__("Dashboard")}}</a>
                        @else
                            <a href="{{route('user.dashboard')}}" class="down-btu">{{__("Dashboard")}}</a>
                        @endif
                    @else
                        <a href="{{route('login')}}" class="down-btu ">{{__("Get Started")}}</a>
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

</header>
<!-- header area end here  -->
