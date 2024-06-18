<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }} - {{@$pageTitle}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon included -->
    <link rel="icon" href="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_fav_icon')) }}" type="image/png"
          sizes="16x16">
    <link rel="shortcut icon" href="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_fav_icon'))}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_fav_icon'))}}">


    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600&display=swap"
        rel="stylesheet">

    <!-- All CSS files included here -->
    @include('admin.layouts.style')
    @stack('style')

</head>
<body class="">

@if(getOption('app_preloader_status', 0) == STATUS_ACTIVE)

    <!-- Pre Loader Area start -->
    <div id="preloader">
        <div id="preloader_status"><img src="{{getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_preloader'))}}"
                                        alt="img"/></div>
    </div>
    <!-- Pre Loader Area End -->

@endif

<!-- Sidebar area start -->
@include('admin.layouts.sidebar')
<!-- Sidebar area end -->

<!-- Main Content area start -->
<div class="main-content">

    <!-- Header section start -->
    @include('admin.layouts.header')
    <!-- Header section end -->

    <!-- page content wrap start -->
    <div class="page-content-wrap">
        <!-- Page content area start -->
        @yield('content')
        <!-- Page content area end -->

        <!-- Footer section start -->
        @include('admin.layouts.footer')
        <!-- Footer section end -->
    </div>
    <!-- page content wrap end -->

</div>
<input type="hidden" id="demo-image" value="{{ asset(getFileUrl('/')) }}">
<!-- Main Content area end -->

@include('common.common-functions')

<input type="hidden" class="getCurrentSymbol" value="{{ getCurrencySymbol() }}">
<!-- All Javascript files included here -->

@include('admin.layouts.script')

<script>

    var currencySymbol = "{{ getCurrencySymbol() }}";
    var currencyPlacement = "{{ getCurrencyPlacement() }}";

    @if(Session::has('success'))
    toastr.success("{{ session('success') }}");
    @endif
    @if(Session::has('error'))
    toastr.error("{{ session('error') }}");
    @endif
    @if(Session::has('info'))
    toastr.info("{{ session('info') }}");
    @endif
    @if(Session::has('warning'))
    toastr.warning("{{ session('warning') }}");
    @endif

    @if (@$errors->any())
    @foreach ($errors->all() as $error)
    toastr.error("{{ $error }}");
    @endforeach
    @endif

</script>
<script src="{{ asset('admin/js/custom/csrf.js') }}"></script>
@stack('script')
<script src="{{ asset('admin/js/custom/summernote-init.js') }}"></script>
<script src="{{ asset('admin/js/custom/select2-init.js') }}"></script>
</body>
</html>
