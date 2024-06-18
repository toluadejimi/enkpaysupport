<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('tenant.layouts.meta')
    <title>{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }} - @stack('title' ?? '')</title>

    @include('tenant.layouts.style')
    @stack('style')
    <!-- FAVICONS -->
    <link rel="icon" href="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_fav_icon')) }}" type="image/png" sizes="16x16">
    <link rel="shortcut icon" href="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_fav_icon')) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_fav_icon')) }}">

    <!-- fonts file -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    @if(getOption('analytics_enable', 0))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ getOption('google_analytics_measurement_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', "{{ getOption('google_analytics_measurement_id') }}");
        </script>
    @endif

</head>

<body>

@if(getOption('app_preloader_status', 0) == STATUS_ACTIVE)
<!-- Pre Loader Area start -->
<div id="preloader">
    <div id="preloader_status"><img src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_preloader')) }}" alt="img" /></div>
</div>
<!-- Pre Loader Area End -->
@endif

<!--Main Menu/Navbar Area Start -->
@if (Request::is('/'))
    @include('tenant.layouts.header')
@else
    @include('tenant.layouts.header-landing-page')
@endif
<!--Main Menu/Navbar Area End -->

@yield('content')

<!-- footer area start here  -->
@include('tenant.layouts.footer')
<!-- footer area end here  -->

<!--=======================================
All Jquery Script link
===========================================-->
@include('tenant.layouts.script')
@stack('script')

</body>
</html>
