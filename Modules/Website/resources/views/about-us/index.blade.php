@extends('website::layouts.master')

@section('title')
    {{ __('front.about_app') }}
@endsection

@section('content')
<div class="panner d-flex" style="background-image: url({{ asset(getSettingValue('mata_banner')) }})">
    <div class="container d-flex">
        <div class="text d-flex align-items-center">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb" style="   {{ isRtl() ? ' flex-direction: row-reverse;' : '' }}">
                    <li class="breadcrumb-item "><a class="w3-text-black"
                            href="{{ route('front.home') }}">{{ __('front.home') }}</a></li>
                    <li class="breadcrumb-item main-color" aria-current="page">{{ __('front.about') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container pt-5 mb-5">
    <div class="row">
        <div class="col-md-5 p-3  text-center">
            <img src="{{ asset($about->image??'') }}" width="100%" class="m-auto" alt="">
        </div>
        <div class="col-md-7 p-3 p{{ isRtl()?'e':'s' }}-5">
            <div class="pt-5">
                <b class="display-5 text-dark border--title p{{ isRtl() ? 'e' : 's' }}-2"
                    style="border-{{ isRtl() ? 'right' : 'left' }}: 10px solid #dcc861">
                    {{ $about->title ?? '' }}
                </b>
                <br>
                <p>{{ $about->short_description ?? '' }}</p>
                <div class="pt-3">
                    {!! $about->description ?? '' !!}
                </div>

            </div>
        </div>
    </div>
</div>
<br><br>
@include('website::home.features', ['features' => $features])


@endSection

@section('js')
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
