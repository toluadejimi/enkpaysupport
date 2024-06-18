<!DOCTYPE html>

<head>
    @include('customer.layouts.meta')
    <title>{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }} - @stack('title' ?? '')</title>
    @include('customer.layouts.style')
    @stack('style')
<!-- FAVICONS -->
    <link rel="icon" href="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_fav_icon'))}}"
          type="image/png" sizes="16x16">
    <link rel="shortcut icon" href="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_fav_icon'))}}"
          type="image/x-icon">
    <link rel="shortcut icon" href="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_fav_icon'))}}">


    @if(getOption('analytics_enable', 0))
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async
                src="https://www.googletagmanager.com/gtag/js?id={{ getOption('google_analytics_measurement_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', "{{ getOption('google_analytics_measurement_id') }}");
        </script>
    @endif

</head>

<body class="{{session()->get('dark_mood') == 1 || session()->get('dark_mood') != null?'dark':''}}">

<!-- Pre Loader Area start -->
@if(getOption('app_preloader_status', 0) == STATUS_ACTIVE)
    <div id="preloader">
        <div id="preloader-status"><img src="{{getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_preloader'))}}" alt="img" /></div>
    </div>
@endif
<!-- Pre Loader Area End -->

@include('customer.layouts.header')

@include('customer.layouts.sidebar')

<!-- Right Content Start -->
@yield('content')
<!-- Right Content end -->

<!-- modal area start -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="delete-modal-box">
                <div>
                    <img src="{{asset('customer')}}/assets/images/carbon_warning.png" alt="">
                </div>
                <h4>{{__('You are about delete this ticket?')}}</h4>
                <p>{{__('You’re about to delete a tickets on this page. this operation is irreversible.are you sure?')}}</p>
                <div class="delete-modal">
                    <button type="button" class="submit-btu mx-3" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="button" data-bs-dismiss="modal"
                            class="delete-btu submit-btu mx-3">{{__('Delete')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal area end -->

@if(getOption('chat_setting_status') == 1)
    @include('customer.chat.chat_button')
@endif

@include('customer.layouts.script')
@stack('script')
<script src="{{ asset('common/js/dark-mode.js') }}"></script>


</body>

</html>
