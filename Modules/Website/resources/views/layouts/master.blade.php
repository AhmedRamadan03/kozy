<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}" style="direction: {{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <a href="{{ route('front.cart.store') }}" id="CartStoreR"></a>
       {{-- Laravel Vite - CSS File --}}
       {{-- {{ module_vite('build-website', 'Resources/assets/sass/app.scss') }} --}}
        @include('website::layouts.css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap');
body,h1,h2,h3,h4,h5,h6,p,a,span,div,* {
    font-family: "Cairo", sans-serif;
    /* font-family: "Nunito Sans", sans-serif; */
    font-weight: 600 !important;
}
</style>
    </head>
    <body class="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        @include('website::layouts.header')
        @yield('content')

        @include('website::layouts.footer')
        @include('website::layouts.script')
        @include('vendor.sweetalert.alert')
        {{-- Laravel Vite - JS File --}}
        {{-- {{ module_vite('build-website', 'Resources/assets/js/app.js') }} --}}
        <a href="{{ route('front.fav.store') }}" id="FavoritesStore" style="display: none;"></a>
        <a href="{{ route('front.fav.remove') }}" id="FavoritesDelete" style="display: none;"></a>
    </body>
</html>
