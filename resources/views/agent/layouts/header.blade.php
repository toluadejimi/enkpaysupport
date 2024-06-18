<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex align-items-center">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{route("agent.dashboard")}}" class="logo logo-light">
            <span class="logo-sm">
              <img src="{{getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_fav_icon'))}}"
                   alt="{{ getGeneralSettingData(getUserIdByTenant(), 'app_name') }}">
            </span>
                    <span class="logo-lg lightLogo">
              <img src="{{getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_logo'))}}"
                   alt="{{ getGeneralSettingData(getUserIdByTenant(), 'app_name') }}">
            </span>
                    <span class="logo-lg blackLogo">
              <img src="{{getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_footer_logo'))}}"
                   alt="{{ getGeneralSettingData(getUserIdByTenant(), 'app_name') }}">
            </span>
                </a>
            </div>
            <button type="button" class="btn-sm px-3 font-24 header-item vertical-menu-icon" id="vertical-menu-btn">
                <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.5625 7.35938H18.8125C18.9156 7.35938 19 7.275 19 7.17188V5.85938C19 5.75625 18.9156 5.67188 18.8125 5.67188H7.5625C7.45937 5.67188 7.375 5.75625 7.375 5.85938V7.17188C7.375 7.275 7.45937 7.35938 7.5625 7.35938ZM7.375 12.1406C7.375 12.2437 7.45937 12.3281 7.5625 12.3281H18.8125C18.9156 12.3281 19 12.2437 19 12.1406V10.8281C19 10.725 18.9156 10.6406 18.8125 10.6406H7.5625C7.45937 10.6406 7.375 10.725 7.375 10.8281V12.1406ZM19.1875 0.75H0.8125C0.709375 0.75 0.625 0.834375 0.625 0.9375V2.25C0.625 2.35312 0.709375 2.4375 0.8125 2.4375H19.1875C19.2906 2.4375 19.375 2.35312 19.375 2.25V0.9375C19.375 0.834375 19.2906 0.75 19.1875 0.75ZM19.1875 15.5625H0.8125C0.709375 15.5625 0.625 15.6469 0.625 15.75V17.0625C0.625 17.1656 0.709375 17.25 0.8125 17.25H19.1875C19.2906 17.25 19.375 17.1656 19.375 17.0625V15.75C19.375 15.6469 19.2906 15.5625 19.1875 15.5625ZM0.704688 9.16172L4.36797 12.0469C4.50391 12.1547 4.70547 12.0586 4.70547 11.8852V6.11484C4.70547 5.94141 4.50625 5.84531 4.36797 5.95312L0.704688 8.83828C0.680055 8.85743 0.660123 8.88196 0.646412 8.90998C0.632701 8.93801 0.625574 8.9688 0.625574 9C0.625574 9.0312 0.632701 9.06199 0.646412 9.09002C0.660123 9.11804 0.680055 9.14257 0.704688 9.16172Z"
                        fill="#160E4D"/>
                </svg>
            </button>
            <!-- App Search-->

            @if(count(getSupportSchedule())>0)
                <div class="dropdown d-inline-block">
                    <button type="button" class="header-item noti-icon btn-sm scheduleBtu"
                            id="page-header-notifications-dropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="supportText">{{__("Support Schedule")}}</span>
                        <span class="headseticon d-none">
              <i class="fa-solid fa-headset "></i>
            </span>
                    </button>
                    <div class="dropdown-menu dropdown-scheduleArea dropdown-menu-end"
                         aria-labelledby="page-header-notifications-dropdown">
                        <div class="scheduleArea">
                            <div class="scheduleImg">
                                <img src="{{asset('agent')}}/assets/images/support.png" alt="">
                            </div>
                            <div class="scheduleTextArea">
                                <h5>{{varityData('schedule_title')}}</h5>
                                <p>{{varityData('schedule_desc')}}</p>
                            </div>
                        </div>
                        @foreach(getSupportSchedule() as $dayItem)
                            <div class="{{$dayItem->days == date("D")?'todayClass':''}}">
                                <div class="scheduleTime">
                                    <div class="singleDate">

                                        <div class="dataName {{$dayItem->status == 'Opened'?'':'closeTimeDate'}}">
                                            <p>{{$dayItem->days}}</p>
                                        </div>
                                        <div class="timetext">
                                            @if($dayItem->status == 'Opened')
                                                <span class="timeBetween">{{$dayItem->start_time}}</span>
                                                <span>{{$dayItem->end_time}}</span>
                                            @else
                                                <span class="closeTime">{{__('Closed')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="d-flex align-items-center flex-shrink-0">

            <div class="flex-shrink-0">
                <button type="button" class="header-item noti-icon btn-sm page-header-mood theme-light mx-1 active"
                        data-theme="light" id="page-header-mood" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M15.9098 14.3262C15.7886 14.5302 15.6499 14.7267 15.4939 14.9135C15.4275 14.9926 15.438 15.1111 15.5175 15.1775C15.597 15.2439 15.7151 15.233 15.7815 15.1539C15.9506 14.9514 16.1006 14.7391 16.2323 14.5182C16.2851 14.4294 16.2559 14.3142 16.167 14.2614C16.0781 14.2081 15.963 14.2374 15.9098 14.3262ZM16.4389 12.9931C16.3868 13.2264 16.3163 13.4566 16.2274 13.6809C16.1891 13.7772 16.2364 13.8864 16.3328 13.9242C16.4288 13.9625 16.5379 13.9152 16.5761 13.8192C16.6725 13.5762 16.7486 13.3272 16.8049 13.0745C16.8274 12.9736 16.7636 12.8735 16.6624 12.851C16.5615 12.8285 16.461 12.8922 16.4389 12.9931ZM16.5266 11.561C16.5495 11.8002 16.5536 12.0406 16.539 12.2806C16.5326 12.3837 16.6114 12.473 16.7149 12.479C16.818 12.4854 16.9069 12.4066 16.9133 12.3035C16.9294 12.044 16.9249 11.7837 16.8998 11.525C16.89 11.4219 16.7981 11.3465 16.6954 11.3562C16.5923 11.366 16.5165 11.4579 16.5266 11.561ZM16.1663 10.1724C16.263 10.3936 16.3414 10.6209 16.4014 10.8522C16.4273 10.9524 16.5296 11.0124 16.6301 10.9865C16.7303 10.9606 16.7903 10.8582 16.7644 10.7581C16.6995 10.5076 16.6144 10.2612 16.5098 10.022C16.4681 9.92712 16.3575 9.88362 16.2626 9.92525C16.1678 9.96687 16.1246 10.0775 16.1663 10.1724ZM15.3896 8.96637C15.552 9.14787 15.6975 9.33912 15.8261 9.53862C15.882 9.62562 15.9983 9.65075 16.0853 9.5945C16.1723 9.53862 16.1974 9.42237 16.1411 9.33537C16.0024 9.11975 15.8449 8.91237 15.6686 8.71625C15.5996 8.639 15.4811 8.63262 15.4039 8.70162C15.327 8.77062 15.3206 8.8895 15.3896 8.96637Z"
                              fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M12 5.625C8.48137 5.625 5.625 8.48137 5.625 12C5.625 15.5186 8.48137 18.375 12 18.375C15.5186 18.375 18.375 15.5186 18.375 12C18.375 8.48137 15.5186 5.625 12 5.625ZM12.375 6.38738C15.3049 6.5805 17.625 9.02138 17.625 12C17.625 14.9786 15.3049 17.4195 12.375 17.6126V6.38738Z"
                              fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M10.9355 2.18963V3.91388C10.9355 4.5015 11.4125 4.9785 12.0002 4.9785C12.5878 4.9785 13.0648 4.5015 13.0648 3.91388V2.18963C13.0648 1.602 12.5878 1.125 12.0002 1.125C11.4125 1.125 10.9355 1.602 10.9355 2.18963Z"
                              fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M18.185 4.31016L16.9659 5.52929C16.5504 5.94479 16.5504 6.61941 16.9659 7.03491C17.3814 7.45041 18.056 7.45041 18.4715 7.03491L19.6907 5.81579C20.1062 5.40029 20.1062 4.72566 19.6907 4.31016C19.2752 3.89466 18.6005 3.89466 18.185 4.31016Z"
                              fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M21.8104 10.9355H20.0861C19.4985 10.9355 19.0215 11.4125 19.0215 12.0002C19.0215 12.5878 19.4985 13.0648 20.0861 13.0648H21.8104C22.398 13.0648 22.875 12.5878 22.875 12.0002C22.875 11.4125 22.398 10.9355 21.8104 10.9355Z"
                              fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M19.6907 18.1841L18.4715 16.9649C18.056 16.5494 17.3814 16.5494 16.9659 16.9649C16.5504 17.3804 16.5504 18.0551 16.9659 18.4706L18.185 19.6897C18.6005 20.1052 19.2752 20.1052 19.6907 19.6897C20.1062 19.2742 20.1062 18.5996 19.6907 18.1841Z"
                              fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M13.0648 21.8104V20.0861C13.0648 19.4985 12.5878 19.0215 12.0002 19.0215C11.4125 19.0215 10.9355 19.4985 10.9355 20.0861V21.8104C10.9355 22.398 11.4125 22.875 12.0002 22.875C12.5878 22.875 13.0648 22.398 13.0648 21.8104Z"
                              fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M5.8153 19.6897L7.03442 18.4706C7.44992 18.0551 7.44992 17.3804 7.03442 16.9649C6.61892 16.5494 5.9443 16.5494 5.5288 16.9649L4.30967 18.1841C3.89417 18.5996 3.89417 19.2742 4.30967 19.6897C4.72517 20.1052 5.3998 20.1052 5.8153 19.6897Z"
                              fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M2.18963 13.0648H3.91388C4.5015 13.0648 4.9785 12.5878 4.9785 12.0002C4.9785 11.4125 4.5015 10.9355 3.91388 10.9355H2.18963C1.602 10.9355 1.125 11.4125 1.125 12.0002C1.125 12.5878 1.602 13.0648 2.18963 13.0648Z"
                              fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M4.30967 5.81579L5.5288 7.03491C5.9443 7.45041 6.61892 7.45041 7.03442 7.03491C7.44992 6.61941 7.44992 5.94479 7.03442 5.52929L5.8153 4.31016C5.3998 3.89466 4.72517 3.89466 4.30967 4.31016C3.89417 4.72566 3.89417 5.40029 4.30967 5.81579Z"
                              fill="white"/>
                    </svg>
                </button>
                <button type="button" class="header-item noti-icon btn-sm page-header-mood theme-dark mx-1"
                        data-theme="dark"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M19.8877 17.9077C19.7363 18.1627 19.5629 18.4083 19.3679 18.6417C19.2849 18.7406 19.298 18.8888 19.3974 18.9717C19.4968 19.0547 19.6444 19.0411 19.7274 18.9422C19.9388 18.6891 20.1263 18.4238 20.2908 18.1477C20.3569 18.0366 20.3204 17.8927 20.2093 17.8266C20.0982 17.76 19.9543 17.7966 19.8877 17.9077ZM20.5491 16.2412C20.484 16.5328 20.3958 16.8206 20.2847 17.1009C20.2369 17.2214 20.296 17.3578 20.4165 17.4052C20.5365 17.453 20.6729 17.3939 20.7207 17.2739C20.8411 16.9702 20.9363 16.6589 21.0066 16.343C21.0347 16.2169 20.955 16.0917 20.8285 16.0636C20.7024 16.0355 20.5768 16.1152 20.5491 16.2412ZM20.6588 14.4511C20.6874 14.7502 20.6925 15.0506 20.6743 15.3506C20.6663 15.4795 20.7647 15.5911 20.8941 15.5986C21.023 15.6066 21.1341 15.5081 21.1421 15.3792C21.1622 15.0548 21.1566 14.7295 21.1252 14.4061C21.113 14.2772 20.9982 14.183 20.8697 14.1952C20.7408 14.2073 20.6461 14.3222 20.6588 14.4511ZM20.2083 12.7153C20.3293 12.9919 20.4272 13.2759 20.5022 13.5652C20.5346 13.6903 20.6625 13.7653 20.7882 13.733C20.9133 13.7006 20.9883 13.5727 20.956 13.4475C20.8749 13.1344 20.7685 12.8264 20.6377 12.5273C20.5857 12.4088 20.4474 12.3544 20.3288 12.4064C20.2102 12.4584 20.1563 12.5967 20.2083 12.7153ZM19.2375 11.2078C19.4405 11.4347 19.6224 11.6738 19.7832 11.9231C19.853 12.0319 19.9983 12.0633 20.1071 11.993C20.2158 11.9231 20.2472 11.7778 20.1769 11.6691C20.0035 11.3995 19.8066 11.1403 19.5863 10.8952C19.5 10.7986 19.3519 10.7906 19.2554 10.8769C19.1593 10.9631 19.1513 11.1117 19.2375 11.2078Z"
                              fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M15 7.03125C10.6017 7.03125 7.03125 10.6017 7.03125 15C7.03125 19.3983 10.6017 22.9688 15 22.9688C19.3983 22.9688 22.9688 19.3983 22.9688 15C22.9688 10.6017 19.3983 7.03125 15 7.03125ZM15.4688 7.98422C19.1311 8.22563 22.0312 11.2767 22.0312 15C22.0312 18.7233 19.1311 21.7744 15.4688 22.0158V7.98422Z"
                              fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M13.6699 2.73703V4.89234C13.6699 5.62687 14.2662 6.22312 15.0007 6.22312C15.7352 6.22312 16.3315 5.62687 16.3315 4.89234V2.73703C16.3315 2.0025 15.7352 1.40625 15.0007 1.40625C14.2662 1.40625 13.6699 2.0025 13.6699 2.73703Z"
                              fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M22.7298 5.38781L21.2059 6.91171C20.6866 7.43109 20.6866 8.27437 21.2059 8.79375C21.7253 9.31312 22.5686 9.31312 23.088 8.79375L24.6119 7.26984C25.1313 6.75046 25.1313 5.90718 24.6119 5.38781C24.0925 4.86843 23.2492 4.86843 22.7298 5.38781Z"
                              fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M27.2634 13.6692H25.1081C24.3736 13.6692 23.7773 14.2655 23.7773 15C23.7773 15.7345 24.3736 16.3308 25.1081 16.3308H27.2634C27.998 16.3308 28.5942 15.7345 28.5942 15C28.5942 14.2655 27.998 13.6692 27.2634 13.6692Z"
                              fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M24.6119 22.7301L23.088 21.2062C22.5686 20.6869 21.7253 20.6869 21.2059 21.2062C20.6866 21.7256 20.6866 22.5689 21.2059 23.0883L22.7298 24.6122C23.2492 25.1316 24.0925 25.1316 24.6119 24.6122C25.1313 24.0928 25.1313 23.2495 24.6119 22.7301Z"
                              fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M16.3315 27.263V25.1077C16.3315 24.3731 15.7352 23.7769 15.0007 23.7769C14.2662 23.7769 13.6699 24.3731 13.6699 25.1077V27.263C13.6699 27.9975 14.2662 28.5937 15.0007 28.5937C15.7352 28.5937 16.3315 27.9975 16.3315 27.263Z"
                              fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M7.26961 24.6122L8.79352 23.0883C9.31289 22.5689 9.31289 21.7256 8.79352 21.2062C8.27414 20.6869 7.43086 20.6869 6.91148 21.2062L5.38758 22.7301C4.8682 23.2495 4.8682 24.0928 5.38758 24.6122C5.90695 25.1316 6.75023 25.1316 7.26961 24.6122Z"
                              fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M2.73703 16.3308H4.89234C5.62687 16.3308 6.22312 15.7345 6.22312 15C6.22312 14.2655 5.62687 13.6692 4.89234 13.6692H2.73703C2.0025 13.6692 1.40625 14.2655 1.40625 15C1.40625 15.7345 2.0025 16.3308 2.73703 16.3308Z"
                              fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M5.38758 7.26984L6.91148 8.79375C7.43086 9.31312 8.27414 9.31312 8.79352 8.79375C9.31289 8.27437 9.31289 7.43109 8.79352 6.91171L7.26961 5.38781C6.75023 4.86843 5.90695 4.86843 5.38758 5.38781C4.8682 5.90718 4.8682 6.75046 5.38758 7.26984Z"
                              fill="black"/>
                    </svg>

                </button>
            </div>
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
                                    <a href="{{route('agent.notification-mark-as-read')}}"
                                       class="successColor">{{__("Mark as read")}}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        @foreach(userNotification('seen-unseen') as $key=>$item)
                            @if($key <=2 )
                                <a href="{{route('agent.notification-view',$item->id)}}" class="notification-item">
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
                                   href="{{route('agent.all-notification')}}">
                                    {{__("View All Notifications")}}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="dropdown header__menu flex-shrink-0">
                <button type="button" class="header-item btn-sm langBtu" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle avatar-xs fit-image header-profile-user"
                         src="{{asset(selectedLanguage()?->flag)}}"
                         alt="Header Avatar">
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="page-header-user-dropdown">
                    <!-- item-->
                    @foreach(appLanguages() as $app_lang)
                        <li>
                            <a href="{{ url('/local/'.$app_lang->iso_code) }}" title="{{$app_lang->language}}" class="d-flex align-items-center cg-8 dropdown-item">
                                <div class="d-flex flex-shrink-0">
                                    <img src="{{asset($app_lang->flag)}}" class="rounded-circle"
                                         alt="user-pic">
                                </div>
                                <p>{{$app_lang->language}}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown d-inline-block user-profile flex-shrink-0">
                <button type="button" class="header-item btn-sm" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle avatar-xs fit-image header-profile-user"
                         src="{{ getFileUrl(auth()->user()->image) }}"
                         alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-3 font-medium">{{auth()->user()->name}}</span>
                    <i class="fa-solid fa-sort-down headerArrow"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="page-header-user-dropdown">
                    <!-- item-->
                    <a class="dropdown-item" href="{{route('agent.profile.index')}}"><i
                            class="fa-regular fa-user"></i>
                        {{__("Profile")}}</a>
                    <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                            class="fa-solid fa-arrow-right-from-bracket"></i> {{__("Log Out")}}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
