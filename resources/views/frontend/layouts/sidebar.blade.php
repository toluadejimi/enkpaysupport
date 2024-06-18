<div class="col-lg-4 col-xl-3">
    <aside class="sidebar-area">
        <nav class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('user.dashboard') }}" class="nav-link {{ @$activeDashboard }}">
                        <span class="menu-icon"><img src="{{ asset('frontend/assets/images/menu-icon-1.svg') }}"
                                                     alt="{{ __("Dashboard") }}"></span>
                        <span class="menu-text">{{ __("Dashboard") }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.referral') }}" class="nav-link {{ @$activeReferral }}">
                        <span class="menu-icon"><img src="{{ asset('frontend/assets/images/menu-icon-7.svg') }}"
                                                     alt="{{ __("Referral") }}"></span>
                        <span class="menu-text">{{ __('Referral')}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.referral.earning') }}" class="nav-link {{ @$activeReferralEarning }}">
                        <span class="menu-icon"><img src="{{ asset('frontend/assets/images/menu-icon-8.svg') }}"
                                                     alt="{{ __("Referral Tree") }}"></span>
                        <span class="menu-text">{{ __("My Referral Earning") }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('user.settings')}}" class="nav-link {{ @$activeSetting }}">
                        <span class="menu-icon"><img src="{{ asset('frontend/assets/images/menu-icon-9.svg') }}"
                                                     alt="{{ __("Settings") }}"></span>
                        <span class="menu-text">{{ __("Settings") }}</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-bottom mt-5">
            <a href="{{route('logout')}}" class="log-out-btn">
                <span class="menu-icon"><img src="{{ asset('frontend/assets/images/log-out.svg') }}"
                                             alt="log-out"></span>
                <span class="menu-text">{{ __("Logout") }}</span>
            </a>
        </div>
    </aside>
</div>
