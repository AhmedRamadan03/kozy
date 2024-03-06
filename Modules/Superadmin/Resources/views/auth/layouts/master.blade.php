<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | @yield('title')</title>
       {{-- Laravel Vite - CSS File --}}
       {{-- {{ module_vite('build-store', 'Resources/assets/sass/app.scss') }} --}}
       @include('superadmin::auth.layouts.css')
       <style>

       </style>
    </head>
    <body >
        <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
  data-sidebar-position="fixed" data-header-position="fixed">
  <!-- Sidebar Start -->

    @include('vendor.sweetalert.alert')

    @yield('content')


    @include('superadmin::auth.layouts.script')

</div>
      </body>
</html>
