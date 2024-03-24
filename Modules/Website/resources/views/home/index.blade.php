@extends('website::layouts.master')
@section('title')
    {{ __('front.home') }}
@endsection

@section('content')
   <div class="home--bg">
    @include('website::home.slider', ['sliders' => $sliders])
    {{-- <br><br>
    @include('website::home.features', ['features' => $features]) --}}

        <br><br>
    <div class="container">
        <div class="col-md-12">
            <div class="d-flex ">
                <b class="display-5 text-dark border--title p{{ isRtl() ? 'e' : 's' }}-2"
                    style="border-{{ isRtl() ? 'right' : 'left' }}: 10px solid #ED3436">
                    {{ __('front.categories') }}</b>
            </div>
        </div>
        <div class="row pt-5">
            <div class="owl-carousel owl-theme owl-loaded" style="direction: ltr">
                @foreach ($categories as $cat)
                    <div class="item">

                        <div class="card" style="background: #E5C7C5">
                            <a href="{{ route('front.categories') }}?main_cat={{ $cat->slug }}">
                                <div class="card-body text-center">
                                    <img src="{{ asset($cat->image) }}" class="m-auto" style="width: 80px !important" alt="{{ $cat->title }}">
                                    <b class="text-center fs-4 text-dark mt-3">{{ $cat->title }}</b>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    <br><br>
    @include('website::home.categories', ['categories' => $categories])
    <br><br>
    <div class="container pt-3 mb-5">
        <div class="row">
            @foreach ($offers->take(1) as $offer)
                <div class="row offer--item">
                    <input type="hidden" id="end_date" value="{{ $offer->end_date }}">
                    <div class=" col-md-6 p-5">
                        <br>
                        <b class="main-color fs-3">{{ __('front.deal_of_this_week') }}</b>
                        <p class="fs-5 text-dark">{{ __('front.deal_of_this_week_desc') }}</p>
                        <h5> <b>{{ optional($offer->product)->title }}</b> </h5>
                        <span>
                            <b class="main-color fs-3">{{ optional($offer->product)->after_discount }}
                                {{ session('country')->currency }}</b>
                            @if (optional($offer->product)->discount > 0)
                                <del class="text-muted fs-5">{{ round(optional($offer->product)->price) }}
                                    {{ session('country')->currency }}</del>
                            @endif
                        </span>
                        <br><br>
                        <a href="{{ route('front.productDetails',$offer->product->slug) }}" class="btn btn--custom">
                            {{ __('front.buy_now') }}
                        </a>

                        <div class="pt-5 timer">
                            <ul id='demo' class="d-flex gap-3 list-unstyled">
                                <li id="day" class=""></li>
                                <li id="hour" ></li>
                                <li id="minute"></li>
                                <li id="second"></li>
                            </ul>

                        </div>
                    </div>
                    <div class="offer--image col-md-6 m-auto"
                        style="height: 450px;width: 450px;background-image: url({{ asset(optional($offer->product)->image) }})">
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <br><br>
    @include('website::home.offers', ['offers' => $offers])



   </div>



@endsection
@section('js')
<script>
    // Set the date we're counting down to
    //plus 1 day
    var date = $('#end_date').val() + " 23:59:59";
    if ($('#end_date').val()) {
        var countDownDate = new Date(date).getTime()

    // Update the count down every 1 second
    if (countDownDate > 0) {
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            var d = '<span class="">' + days + ' <br>Days</span>';
            document.getElementById("day").innerHTML = days + '<p class=" m-0 text-dark bb-main">{{ __('front.days') }}</p>';
            document.getElementById("hour").innerHTML = hours + '<p class=" m-0 text-dark bb-main">{{ __('front.hours') }}</p>';
            document.getElementById("minute").innerHTML = minutes + '<p class=" m-0 text-dark bb-main">{{ __('front.minutes') }}</p>';
            document.getElementById("second").innerHTML = seconds + '<p class=" m-0 text-dark bb-main">{{ __('front.seconds') }}</p>';
            // document.getElementById("day").innerHTML = d + hours + "h " +
            //     minutes + "m " + seconds + "s ";

            // If the count down is over, write some text

        }, 1000);
    }
    }
</script>

<script>
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    })
</script>
@endsection
