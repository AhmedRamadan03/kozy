<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
    @if (app()->getLocale() == 'ar') direction="rtl" dir="rtl" style="direction: rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ env('APP_NAME') }} | @yield('title')</title>

    {{-- icon --}}
    <link rel="icon" href="{{ asset(optional($settings->where('key','favicon')->first())->value) }}" />
    @include('superadmin::layouts.css')
    <style>
    </style>

    <script>
        const LANG ={
            'true': '{{ __('lang.true') }}',
            'false': '{{ __('lang.false') }}',
        };
    </script>

</head>

<body>

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            @include('superadmin::layouts.sidebar')
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('superadmin::layouts.header')
            <!--  Header End -->
            <div class="container-fluid">
                <!--  Row 1 -->

                @yield('content')


                @include('superadmin::layouts.script')
                @include('vendor.sweetalert.alert')

            </div>
        </div>
    </div>



</body>

</html>
