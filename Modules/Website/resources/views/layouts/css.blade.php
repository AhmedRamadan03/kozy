 <!-- Libraries Stylesheet -->
 <link href="{{ asset('website/lib/animate/animate.min.css') }}" rel="stylesheet">
 <link href="{{ asset('website/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

 <!-- Customized Bootstrap Stylesheet -->
 <link href="{{ asset('website/css/bootstrap.min.css') }}" rel="stylesheet">
 <link
 rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>
 <!-- Template Stylesheet -->
 @if (app()->getLocale() == 'ar')

 <link href="{{ asset('website/css/style-rtl.css') }}" rel="stylesheet">
 @else

 <link href="{{ asset('website/css/style.css') }}" rel="stylesheet">
 @endif
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


 <link rel="stylesheet" href="{{ asset('website/css/my-style.css') }}">
@yield('css')




