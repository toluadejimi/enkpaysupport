<header class="header__area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="header__navbar">
                    <div class="header__navbar__left">
                        <button class="sidebar-toggler">
                            <img src="{{asset('admin/images/icons/header/bars.svg')}}" alt="">
                        </button>
                        <a href="{{ route('frontend') }}" target="_blank">
                            <button class="btn btn-blue">{{__('Visit Site')}} <span class="iconify" data-icon="material-symbols:arrow-outward-rounded"></span></button>
                        </a>
                    </div>
                    <div class="header__navbar__right">
                        <ul class="header__menu">
                            <li>
                                <a href="#" class="btn btn-dropdown site-language" id="dropdownLanguage" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{asset(selectedLanguage()?->flag)}}" alt="icon"> {{selectedLanguage()?->language}}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownLanguage">
                                    @foreach(appLanguages() as $app_lang)
                                        <li>
                                            <a class="dropdown-item" href="{{ url('/local/'.$app_lang->iso_code) }}">
                                                <img src="{{asset($app_lang->flag)}}" alt="icon">
                                                <span>{{$app_lang->language}}</span>
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </li>
                            <li>
                                <div class="dropdown d-inline-block flex-shrink-0">
                                    <button type="button" class="header-item noti-icon btn-sm" id="page-header-notifications-dropdown"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-regular fa-bell"></i>
                                        <span class="noti-dot pulse"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end  notificationBox"
                                         aria-labelledby="page-header-notifications-dropdown">
                                        <div class="">
                                            <div class="notificationsHeading">
                                                <div>
                                                    <h5 class="m-0">{{__("You have ".count(userNotification('unseen'))." new notification")}}</h5>
                                                </div>
                                                @if(count(userNotification('unseen'))>0)
                                                    <div>
                                                        <a href="{{route('admin.notification-mark-as-read')}}"
                                                           class="successColor">{{__("Mark as read")}}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            @foreach(userNotification('seen-unseen') as $key=>$item)
                                                @if($key <=2 )
                                                    <a href="{{route('admin.notification-view',$item->id)}}" class="notification-item">
                                                        <div class="single-notifi">
                                                            <div>
                                                                <img src="{{asset('agent/assets/images/email.png')}}"
                                                                     class="rounded-circle avatar-xs" alt="user-pic">
                                                            </div>
                                                            <div class="flex-1">
                                                                <div class="">
                                                                    @if($item->seen_id == null)
                                                                        <h6>{{$item->title}}</h6>
                                                                    @else
                                                                        <h6 class="text-dark-color">{{$item->title}}</h6>
                                                                    @endif
                                                                    <p> {{$item->created_at->diffForHumans()}}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                        @if(count(userNotification('seen-unseen'))>3)
                                            <div class="">
                                                <div class="d-grid">
                                                    <a class="ticket-btu-com w-100 text-center"
                                                       href="{{route('admin.all-notification')}}">
                                                        {{__("View All Notifications")}}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#" class="btn btn-dropdown user-profile" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ getFileUrl(auth()->user()->image) }}" alt="icon">{{auth()->user()->name}}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownUser">
                                    <li>
                                        <a class="dropdown-item" href="{{route('admin.profile.index')}}">
                                            <img src="{{asset('admin/images/icons/user.svg')}}" alt="icon">
                                            <span>{{__('Profile')}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile.change-password') }}">
                                            <img src="{{asset('admin/images/icons/settings.svg')}}" alt="icon">
                                            <span>{{__('Change Password')}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <img src="{{asset('admin/images/icons/logout.svg')}}" alt="icon">
                                            <span>{{ __('Log Out') }}</span>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
