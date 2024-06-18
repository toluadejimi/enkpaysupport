<div class="sidebar__area">
    <div class="sidebar__close">
        <button class="close-btn">
            <i class="fa fa-close"></i>
        </button>
    </div>

    <div class="sidebar__brand">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_footer_logo')) }}"
                 alt="{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }}">
        </a>
    </div>


    <ul id="sidebar-menu" class="sidebar__menu sf-sidebar-menu">
        <li class="{{ @$navDashboard }}">
            <a href="{{ route('admin.dashboard') }}">
                <div class="sf-icon"><span class="iconify" data-icon="bxs:dashboard"></span></div>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </li>

        <li class="{{ @$navUser}}">
            <a href="{{ route('admin.user.list') }}">
                <div class="sf-icon"><span class="iconify" data-icon="bxs:user"></span></div>
                <span>{{ __('User') }}</span>
            </a>
        </li>

        @if(isAddonInstalled('DESKSAAS') > 0)

            @if(auth()->user()->role == USER_ROLE_SUPER_ADMIN)
                <li class="{{ @$navSubscriptionActiveClass }}">
                    <a class="has-arrow" href="#">
                        <div class="sf-icon"><span class="iconify" data-icon="mdi:blog-outline"></span></div>
                        <span>{{__('Subscription')}}</span>
                    </a>
                    <ul>
                        <li class="{{ @$subNavPackageActiveClass }}">
                            <a href="{{route('admin.packages.index')}}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Packages') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$subNavAllOrdersActiveClass }}">
                            <a href="{{route('admin.subscriptions.orders')}}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('All Orders') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ @$navDomainActiveClass }}">
                    <a class="has-arrow" href="#">
                        <div class="sf-icon"><span class="iconify" data-icon="mdi:blog-outline"></span></div>
                        <span>{{__('Custom Domain')}}</span>
                    </a>
                    <ul>
                        <li class="{{ @$subNavDomainRequestActiveClass }}">
                            <a href="{{route('admin.custom.domain.request-list')}}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Request List') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$subNavInstructionActiveClass }}">
                            <a href="{{route('admin.custom.domain.instruction')}}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Setup Instruction') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if(auth()->user()->role == USER_ROLE_ADMIN)
                <li class="{{ @$navTagActiveClass }}">
                    <a href="{{ route('admin.tickets.tag') }}">
                        <div class="sf-icon"><i class="fa fa-tags"></i></div>
                        <span>{{__('Tag')}}</span>
                    </a>
                </li>
                <li class="{{ @$navCategoryActiveClass }}">
                    <a href="{{ route('admin.tickets.category') }}">
                        <div class="sf-icon"><span class="iconify" data-icon="gg:website"></span></div>
                        <span>{{__('Category')}}</span>
                    </a>
                </li>
                <li class="{{@$navMySubscription}}">
                    <a href="{{ route('admin.subscription.index') }}">
                        <div class="sf-icon"><span class="iconify" data-icon="bxs:user"></span></div>
                        <span>{{ __('My Subscription') }}</span>
                    </a>
                </li>
                <li class="{{ @$navTicketParentActiveClass }}">
                    <a class="has-arrow" href="#">
                        <div class="sf-icon"><i class="fa fa-ticket"></i></div>
                        <span>{{__('Tickets')}}</span>
                    </a>
                    <ul class="">
                        <li class="{{ @$navTicketAllClass }}">
                            <a href="{{ route('admin.tickets.ticketList') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('All Tickets') }}</span>
                            </a>
                        </li>

                        <li class="{{ @$navTicketRecentClass }}">
                            <a href="{{ route('admin.tickets.recentTicketList') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Recent Tickets') }}</span>
                            </a>
                        </li>

                        <li class="{{ @$navTicketActiveClass }}">
                            <a href="{{ route('admin.tickets.activeTicketList') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Active Tickets') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$navTicketResolvedClass }}">
                            <a href="{{ route('admin.tickets.resolvedTicketList') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Resolved Tickets') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$navTicketClosedClass }}">
                            <a href="{{ route('admin.tickets.closedTicketList') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Closed Tickets') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$navTicketOnHoldClass }}">
                            <a href="{{ route('admin.tickets.onHoldTicketList') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('On-Hold Tickets') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$navTicketAssignedClass }}">
                            <a href="{{ route('admin.tickets.assignedTicketList') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Assigned Tickets') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$navTicketSuspendedClass }}">
                            <a href="{{ route('admin.tickets.suspendedTicketList') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Suspended Tickets') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$navTicketDeleteClass }}">
                            <a href="{{ route('admin.tickets.deleted-tickets') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Trashed Tickets') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ @$navSelfTicketsParentActiveClass }} d-none">
                    <a class="has-arrow" href="#">
                        <div class="sf-icon"><i class="fa fa-ticket-simple"></i></div>
                        <span>{{__('My Tickets')}}</span>
                    </a>
                    <ul class="">
                        <li class="{{ @$navMyAssignedTicketsActiveClass }}">
                            <a href="{{ route('admin.tickets.my-assigned-tickets') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('My Assigned Tickets') }}</span>
                            </a>
                        </li>
                        <div class="d-none">
                            <li class="{{ @$navSelfAssignedTicketsActiveClass }}">
                                <a href="{{ route('admin.tickets.self-assigned-tickets') }}">
                                    <i class="fa fa-circle"></i>
                                    <span>{{ __('Self Assigned Tickets') }}</span>
                                </a>
                            </li>
                            <li class="{{ @$navClosedTicketsActiveClass }}">
                                <a href="{{ route('admin.tickets.closed-tickets') }}">
                                    <i class="fa fa-circle"></i>
                                    <span>{{ __('Closed Tickets') }}</span>
                                </a>
                            </li>
                            <li class="{{ @$navSuspendTicketsActiveClass }}">
                                <a href="{{ route('admin.tickets.suspend-tickets') }}">
                                    <i class="fa fa-circle"></i>
                                    <span>{{ __('Suspend Tickets') }}</span>
                                </a>
                            </li>
                        </div>

                    </ul>
                </li>
                <li class="{{ @$navEnvatoParentActiveClass }}">
                    <a class="has-arrow" href="#">
                        <div class="sf-icon"><span class="iconify" data-icon="mdi:ticket"></span></div>
                        <span>{{__('Envato')}}</span>
                    </a>
                    <ul class="">
                        <li class="{{ @$navEnvatoSettingActiveClass }}">
                            <a href="{{ route('admin.envato.config') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Envato Configuration') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$navLicenseVerificationActiveClass }}">
                            <a href="{{ route('admin.envato.license-verification') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('License Verification') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

        @else
            <li class="{{ @$navTagActiveClass }}">
                <a href="{{ route('admin.tickets.tag') }}">
                    <div class="sf-icon"><i class="fa fa-tags"></i></div>
                    <span>{{__('Tag')}}</span>
                </a>
            </li>
            <li class="{{ @$navCategoryActiveClass }}">
                <a href="{{ route('admin.tickets.category') }}">
                    <div class="sf-icon"><span class="iconify" data-icon="gg:website"></span></div>
                    <span>{{__('Category')}}</span>
                </a>
            </li>
            <li class="{{ @$navTicketParentActiveClass }}">
                <a class="has-arrow" href="#">
                    <div class="sf-icon"><i class="fa fa-ticket"></i></div>
                    <span>{{__('Tickets')}}</span>
                </a>
                <ul class="">
                    <li class="{{ @$navTicketAllClass }}">
                        <a href="{{ route('admin.tickets.ticketList') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('All Tickets') }}</span>
                        </a>
                    </li>
                    <li class="{{ @$navMyAssignedTicketsActiveClass }}">
                        <a href="{{ route('admin.tickets.my-assigned-tickets') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('My Assigned Tickets') }}</span>
                        </a>
                    </li>
                    <li class="{{ @$navTicketRecentClass }}">
                        <a href="{{ route('admin.tickets.recentTicketList') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('Recent Tickets') }}</span>
                        </a>
                    </li>
                    <li class="{{ @$navTicketActiveClass }}">
                        <a href="{{ route('admin.tickets.activeTicketList') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('Active Tickets') }}</span>
                        </a>
                    </li>

                    <li class="{{ @$navTicketResolvedClass }}">
                        <a href="{{ route('admin.tickets.resolvedTicketList') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('Resolved Tickets') }}</span>
                        </a>
                    </li>
                    <li class="{{ @$navTicketClosedClass }}">
                        <a href="{{ route('admin.tickets.closedTicketList') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('Closed Tickets') }}</span>
                        </a>
                    </li>
                    <li class="{{ @$navTicketOnHoldClass }}">
                        <a href="{{ route('admin.tickets.onHoldTicketList') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('On-Hold Tickets') }}</span>
                        </a>
                    </li>
                    <li class="{{ @$navTicketAssignedClass }}">
                        <a href="{{ route('admin.tickets.assignedTicketList') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('Assigned Tickets') }}</span>
                        </a>
                    </li>
                    <li class="{{ @$navTicketSuspendedClass }}">
                        <a href="{{ route('admin.tickets.suspendedTicketList') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('Suspended Tickets') }}</span>
                        </a>
                    </li>
                    <li class="{{ @$navTicketDeleteClass }}">
                        <a href="{{ route('admin.tickets.deleted-tickets') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('Trashed Tickets') }}</span>
                        </a>
                    </li>
{{--                    <li class="{{ @$navTicketRatingClass }}">--}}
{{--                        <a href="{{ route('admin.tickets.manageTicketRatings') }}">--}}
{{--                            <i class="fa fa-circle"></i>--}}
{{--                            <span>{{ __('Ticket Rating') }}</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>
            </li>
            <li class="{{ @$navSelfTicketsParentActiveClass }} d-none">
                <a class="has-arrow" href="#">
                    <div class="sf-icon"><i class="fa fa-ticket-simple"></i></div>
                    <span>{{__('My Tickets')}}</span>
                </a>
                <ul class="">
                    <li class="{{ @$navMyAssignedTicketsActiveClass }}">
                        <a href="{{ route('admin.tickets.my-assigned-tickets') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('My Assigned Tickets') }}</span>
                        </a>
                    </li>
                    <div class="d-none">
                        <li class="{{ @$navSelfAssignedTicketsActiveClass }}">
                            <a href="{{ route('admin.tickets.self-assigned-tickets') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Self Assigned Tickets') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$navClosedTicketsActiveClass }}">
                            <a href="{{ route('admin.tickets.closed-tickets') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Closed Tickets') }}</span>
                            </a>
                        </li>
                        <li class="{{ @$navSuspendTicketsActiveClass }}">
                            <a href="{{ route('admin.tickets.suspend-tickets') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Suspend Tickets') }}</span>
                            </a>
                        </li>
                    </div>

                </ul>
            </li>
            <li class="{{ @$navEnvatoParentActiveClass }}">
                <a class="has-arrow" href="#">
                    <div class="sf-icon"><span class="iconify" data-icon="mdi:ticket"></span></div>
                    <span>{{__('Envato')}}</span>
                </a>
                <ul class="">
                    <li class="{{ @$navEnvatoSettingActiveClass }}">
                        <a href="{{ route('admin.envato.config') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('Envato Configuration') }}</span>
                        </a>
                    </li>
                    <li class="{{ @$navLicenseVerificationActiveClass }}">
                        <a href="{{ route('admin.envato.license-verification') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('License Verification') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif


        <li class="{{ @$navSettingParentActiveClass }}">
            <a class="has-arrow" href="#">
                <div class="sf-icon"><i class="fa-solid fa-gear"></i></div>
                <span>{{__('Settings')}}</span>
            </a>
            <ul class="">
                <li class="{{ @$subNavGeneralSettingActiveClass }}">
                    <a href="{{ route('admin.setting.application-settings') }}">
                        <i class="fa fa-circle"></i>
                        <span>{{ __('General Settings') }}</span>
                    </a>
                </li>
                @if(isAddonInstalled('DESKSAAS') > 0)
                    @if(auth()->user()->role == USER_ROLE_SUPER_ADMIN)

                        <li class="{{ @$subNavConfigurationSettingActiveClass }}">
                            <a href="{{ route('admin.setting.configuration-settings') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Configuration') }}</span>
                            </a>
                        </li>

                        <li class="{{ @$subGatewaySettingActiveClass }}">
                            <a href="{{ route('admin.setting.gateway.index') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Payment Gateway') }}</span>
                            </a>
                        </li>

                        <li class="{{ @$subNavLanguageActiveClass }}">
                            <a href="{{ route('admin.setting.languages.index') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{__('Language Setting')}}</span>
                            </a>
                        </li>

                        <li class="{{ @$subNavCountrySettingActiveClass }}">
                            <a href="{{ route('admin.setting.country.list') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{__('Country Settings')}}</span>
                            </a>
                        </li>

                        <li class="{{ @$subNavEmailTempSettingActiveClass }}">
                            <a href="{{ route('admin.setting.email-template') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{__('Email Template')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->role == USER_ROLE_ADMIN)
                        <li class="{{ @$subNavDomainSetupActiveClass }}">
                            <a href="{{ route('admin.setting.domain-setup') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{__('Domain Setup')}}</span>
                            </a>
                        </li>
                        <li class="{{ @$subNavBusinessHoursSettingActiveClass }}">
                            <a href="{{ route('admin.setting.business-hours') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{__('Support Schedule')}}</span>
                            </a>
                        </li>
                        <li class="{{ @$subNavTrackingNoPreFixedSettingActiveClass }} d-none">
                            <a href="{{ route('admin.setting.tracking-no-pre-fixed') }}">
                                <i class="fa fa-circle"></i>
                                <span>{{__('Ticket Config')}}</span>
                            </a>
                        </li>
                    @endif
                @else
                    <li class="{{ @$subNavConfigurationSettingActiveClass }}">
                        <a href="{{ route('admin.setting.configuration-settings') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('Configuration') }}</span>
                        </a>
                    </li>

                    <li class="{{ @$subNavLanguageActiveClass }}">
                        <a href="{{ route('admin.setting.languages.index') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{__('Language Setting')}}</span>
                        </a>
                    </li>
                    <li class="{{ @$subNavCountrySettingActiveClass }}">
                        <a href="{{ route('admin.setting.country.list') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{__('Country Settings')}}</span>
                        </a>
                    </li>
                    <li class="{{ @$subNavEmailTempSettingActiveClass }}">
                        <a href="{{ route('admin.setting.email-template') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{__('Email Template')}}</span>
                        </a>
                    </li>
                    <li class="{{ @$subNavBusinessHoursSettingActiveClass }}">
                        <a href="{{ route('admin.setting.business-hours') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{__('Support Schedule')}}</span>
                        </a>
                    </li>
                    <li class="{{ @$subNavTrackingNoPreFixedSettingActiveClass }}">
                        <a href="{{ route('admin.setting.tracking-no-pre-fixed') }}">
                            <i class="fa fa-circle"></i>
                            <span>{{__('Ticket Config')}}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>

        <li class="{{ @$subNavFrontendSettingActiveClass }}">
            <a href="{{ route('admin.setting.frontend.index') }}">
                <div class="sf-icon"><span class="iconify" data-icon="mdi:application-cog-outline"></span></div>
                <span>{{__('CMS Setting')}}</span>
            </a>
        </li>

        @if(isAddonInstalled('DESKSAAS') > 0)
            @if(auth()->user()->role == USER_ROLE_SUPER_ADMIN)
                <li class="{{ @$navCustomPageActiveClass }}">
                    <a class="has-arrow" href="#">
                        <div class="sf-icon"><span class="iconify" data-icon="mdi:blog-outline"></span></div>
                        <span>{{__('Custom Page')}}</span>
                    </a>
                    <ul class="">
                        <li class="{{ @$subNavPagesActiveClass }}">
                            <a href="{{route('admin.custom-pages')}}">
                                <i class="fa fa-circle"></i>
                                <span>{{ __('Pages') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="{{ @$subDynamicFieldsActiveClass }}">
                    <a href="{{ route('admin.dynamic-fields') }}">
                        <div class="sf-icon"><span class="fa fa-plus-square"></span></div>
                        <span>{{__('Dynamic Fields')}}</span>
                    </a>
                </li>
            @endif
        @else
            <li class="{{ @$navCustomPageActiveClass }}">
                <a class="has-arrow" href="#">
                    <div class="sf-icon"><i class="fa-solid fa-file-lines"></i></div>
                    <span>{{__('Custom Page')}}</span>
                </a>
                <ul class="">
                    <li class="{{ @$subNavPagesActiveClass }}">
                        <a href="{{route('admin.custom-pages')}}">
                            <i class="fa fa-circle"></i>
                            <span>{{ __('Pages') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ @$subDynamicFieldsActiveClass }}">
                <a href="{{ route('admin.dynamic-fields') }}">
                    <div class="sf-icon"><span class="fa fa-plus-square"></span></div>
                    <span>{{__('Dynamic Fields')}}</span>
                </a>
            </li>
        @endif

        <li class="{{ @$navContactMessageListActiveClass }}">
            <a href="{{ route('admin.setting.contact.sms.index') }}">
                <div class="sf-icon"><i class="fa-solid fa-comments"></i></div>
                <span>{{__('Contact Messages')}}</span>
            </a>
        </li>


        @if(isAddonInstalled('DESKSAAS') > 0)
            @if(auth()->user()->role == USER_ROLE_SUPER_ADMIN)
                <li class="{{ @$subNavVersionUpdateActiveClass }}">
                    <a href="{{ route('admin.file-version-update') }}">
                        <i class="fa fa-circle"></i>
                        <span>{{__('Version Update')}}</span>
                    </a>
                </li>
            @else
                <li class="{{@$navAnnouncementActiveClass}}">
                    <a href="{{ route('admin.setting.announcement.index') }}">
                        <div class="sf-icon"><i class="fa-solid fa-bullhorn"></i></div>
                        <span>{{__('Announcement')}}</span>
                    </a>
                </li>
            @endif
        @else
            <li class="{{ @$subNavVersionUpdateActiveClass }}">
                <a href="{{ route('admin.file-version-update') }}">
                    <i class="fa fa-circle"></i>
                    <span>{{__('Version Update')}}</span>
                </a>
            </li>
            <li class="{{@$navAnnouncementActiveClass}}">
                <a href="{{ route('admin.setting.announcement.index') }}">
                    <div class="sf-icon"><i class="fa-solid fa-bullhorn"></i></div>
                    <span>{{__('Announcement')}}</span>
                </a>
            </li>
        @endif

        <li class="pt-5 mb-5 text-center">
            <span>
                <h3>{{ __('Software Version') }} {{ getOption('current_version', '1.0') }}</h3>
            </span>
        </li>


    </ul>
</div>
