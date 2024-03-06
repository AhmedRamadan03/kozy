<!-- bootstarp  css -->
@if (app()->getLocale() == 'ar')
    <link href="{{ asset('assets/css/styles_rtl.min.css') }}" rel="stylesheet" />
@else
    <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet" />
@endif
    <link href="{{ asset('assets/css/my_style_v1.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}">
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" />

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>

.border-dash{
    border: 1px dashed #ccc;
}
</style>
@yield('css')
