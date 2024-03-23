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
                    <li class="breadcrumb-item main-color" aria-current="page">{{ __('front.contact_us') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container pt-5 mb-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <b class="fs-3 text-dark border--title p{{ isRtl() ? 'e' : 's' }}-2"style="border-{{ isRtl() ? 'right' : 'left' }}: 10px solid #dcc861">{{ getSettingValue('contact_us_title1_'.app()->getLocale()) }}</b>
            <p class="pt-2 w-50 mx-auto">{{getSettingValue('contact_us_description1_'.app()->getLocale()) }}</p>
        </div>

        <div class="col-md-4 pt-3">
            <div class="item w3-light-gray w3-round-large text-center p-4">
                <svg width="120" height="108" viewBox="0 0 120 108" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M84 30H12C10.4087 30 8.88258 30.6321 7.75736 31.7574C6.63214 32.8826 6 34.4087 6 36V84C6 85.5913 6.63214 87.1174 7.75736 88.2426C8.88258 89.3679 10.4087 90 12 90H84C85.5913 90 87.1174 89.3679 88.2426 88.2426C89.3679 87.1174 90 85.5913 90 84V36C90 34.4087 89.3679 32.8826 88.2426 31.7574C87.1174 30.6321 85.5913 30 84 30ZM77.4 36L48 56.34L18.6 36H77.4ZM12 84V38.73L46.29 62.46C46.7922 62.8084 47.3888 62.9951 48 62.9951C48.6112 62.9951 49.2078 62.8084 49.71 62.46L84 38.73V84H12Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M96 42C98.3638 42 100.704 41.5344 102.888 40.6298C105.072 39.7253 107.056 38.3994 108.728 36.7279C110.399 35.0565 111.725 33.0722 112.63 30.8883C113.534 28.7044 114 26.3638 114 24C114 21.6362 113.534 19.2956 112.63 17.1117C111.725 14.9278 110.399 12.9435 108.728 11.2721C107.056 9.60062 105.072 8.27475 102.888 7.37017C100.704 6.46558 98.3638 6 96 6C91.2261 6 86.6477 7.89642 83.2721 11.2721C79.8964 14.6477 78 19.2261 78 24C78 28.7739 79.8964 33.3523 83.2721 36.7279C86.6477 40.1036 91.2261 42 96 42ZM95.536 31.28L105.536 19.28L102.464 16.72L93.864 27.038L89.414 22.586L86.586 25.414L92.586 31.414L94.134 32.962L95.536 31.28Z" fill="#dcc861"/>
                </svg>
                <br>
                <b class="fs-4">{{ __('lang.email') }}</b>
                <br>
                <a href="mailto:{{ getSettingValue('email_1') ?? '' }}" class="text-muted">
                    {{ getSettingValue('email_1') ?? '' }}
                </a>
                <br>
                <a href="mailto:{{ getSettingValue('email_2') ?? '' }}" class="text-muted">
                    {{ getSettingValue('email_2') ?? '' }}
                </a>

            </div>
        </div>
        <div class="col-md-4 pt-3">
            <div class="item w3-light-gray w3-round-large text-center p-4">
                <svg width="121" height="108" viewBox="0 0 121 108" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M83.8887 71.4225L66.2225 63.5062L66.1738 63.4837C65.2566 63.0915 64.2562 62.934 63.2629 63.0257C62.2696 63.1174 61.3149 63.4552 60.485 64.0087C60.3873 64.0733 60.2934 64.1434 60.2038 64.2187L51.0763 72C45.2938 69.1912 39.3238 63.2662 36.515 57.5587L44.3075 48.2925C44.3825 48.1987 44.4538 48.105 44.5213 48.0037C45.0629 47.1761 45.3915 46.2274 45.4778 45.2421C45.5642 44.2568 45.4056 43.2654 45.0163 42.3562V42.3112L37.0775 24.615C36.5628 23.4272 35.6777 22.4378 34.5545 21.7944C33.4312 21.151 32.13 20.8881 30.845 21.045C25.7636 21.7136 21.0994 24.2091 17.7235 28.0653C14.3476 31.9216 12.4908 36.8748 12.5 42C12.5 71.775 36.725 96 66.5 96C71.6252 96.0092 76.5784 94.1524 80.4346 90.7765C84.2909 87.4006 86.7864 82.7363 87.455 77.655C87.6122 76.3705 87.3499 75.0695 86.7072 73.9463C86.0644 72.8231 85.0758 71.9378 83.8887 71.4225ZM66.5 90C53.7739 89.9861 41.573 84.9245 32.5742 75.9257C23.5755 66.927 18.5139 54.7261 18.5 42C18.4859 38.3381 19.8052 34.7962 22.2115 32.0359C24.6178 29.2755 27.9466 27.4855 31.5763 27C31.5748 27.0149 31.5748 27.03 31.5763 27.045L39.4513 44.67L31.7 53.9475C31.6213 54.038 31.5499 54.1345 31.4863 54.2362C30.9219 55.1022 30.5909 56.0992 30.5252 57.1307C30.4595 58.1622 30.6614 59.1932 31.1113 60.1237C34.5088 67.0725 41.51 74.0212 48.5338 77.415C49.4711 77.8607 50.5081 78.0556 51.5433 77.9806C52.5785 77.9057 53.5766 77.5635 54.44 76.9875C54.5363 76.9226 54.6289 76.8525 54.7175 76.7775L63.8338 69L81.4588 76.8937H81.5C81.0204 80.5285 79.233 83.864 76.4722 86.2763C73.7114 88.6885 70.1662 90.0123 66.5 90Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M96.5 42C98.8638 42 101.204 41.5344 103.388 40.6298C105.572 39.7253 107.556 38.3994 109.228 36.7279C110.899 35.0565 112.225 33.0722 113.13 30.8883C114.034 28.7044 114.5 26.3638 114.5 24C114.5 21.6362 114.034 19.2956 113.13 17.1117C112.225 14.9278 110.899 12.9435 109.228 11.2721C107.556 9.60062 105.572 8.27475 103.388 7.37017C101.204 6.46558 98.8638 6 96.5 6C91.7261 6 87.1477 7.89642 83.7721 11.2721C80.3964 14.6477 78.5 19.2261 78.5 24C78.5 28.7739 80.3964 33.3523 83.7721 36.7279C87.1477 40.1036 91.7261 42 96.5 42ZM96.036 31.28L106.036 19.28L102.964 16.72L94.364 27.038L89.914 22.586L87.086 25.414L93.086 31.414L94.634 32.962L96.036 31.28Z" fill="#dcc861"/>
                    </svg>

                <br>
                <b class="fs-4">{{ __('lang.phone') }}</b>
                <br>
                <a href="tel:{{getSettingValue('phone')?? '' }}" class="text-muted">
                    {{getSettingValue('phone')?? '' }}
                </a><br>
                <a href="tel:{{ getSettingValue('whatsapp') ?? '' }}" class="text-muted">
                    {{ getSettingValue('whatsapp') ?? '' }}
                </a>

            </div>
        </div>
        <div class="col-md-4 pt-3">
            <div class="item w3-light-gray w3-round-large text-center p-4">
                <svg width="120" height="108" viewBox="0 0 120 108" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_710_19682)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M48 20C57.5478 20 66.7045 23.7928 73.4558 30.5442C80.2072 37.2955 84 46.4522 84 56C84 68.296 77.296 78.36 70.232 85.58C66.7021 89.1476 62.8511 92.3826 58.728 95.244L57.024 96.404L56.224 96.936L54.716 97.896L53.372 98.716L51.708 99.684C50.578 100.327 49.3002 100.665 48 100.665C46.6998 100.665 45.422 100.327 44.292 99.684L42.628 98.716L40.548 97.436L39.78 96.936L38.14 95.844C33.6919 92.8333 29.5483 89.3957 25.768 85.58C18.704 78.356 12 68.296 12 56C12 46.4522 15.7928 37.2955 22.5442 30.5442C29.2955 23.7928 38.4522 20 48 20ZM48 28C40.5739 28 33.452 30.95 28.201 36.201C22.95 41.452 20 48.5739 20 56C20 65.288 25.088 73.44 31.484 79.984C34.2345 82.7676 37.207 85.3227 40.372 87.624L42.204 88.928C42.796 89.34 43.364 89.724 43.912 90.08L45.472 91.08L46.844 91.916L48 92.592L49.82 91.516L51.288 90.596C52.068 90.1 52.908 89.544 53.796 88.928L55.628 87.624C58.793 85.3227 61.7655 82.7676 64.516 79.984C70.912 73.444 76 65.288 76 56C76 48.5739 73.05 41.452 67.799 36.201C62.548 30.95 55.4261 28 48 28ZM48 40C52.2435 40 56.3131 41.6857 59.3137 44.6863C62.3143 47.6869 64 51.7565 64 56C64 60.2435 62.3143 64.3131 59.3137 67.3137C56.3131 70.3143 52.2435 72 48 72C43.7565 72 39.6869 70.3143 36.6863 67.3137C33.6857 64.3131 32 60.2435 32 56C32 51.7565 33.6857 47.6869 36.6863 44.6863C39.6869 41.6857 43.7565 40 48 40ZM48 48C45.8783 48 43.8434 48.8429 42.3431 50.3431C40.8429 51.8434 40 53.8783 40 56C40 58.1217 40.8429 60.1566 42.3431 61.6569C43.8434 63.1571 45.8783 64 48 64C50.1217 64 52.1566 63.1571 53.6569 61.6569C55.1571 60.1566 56 58.1217 56 56C56 53.8783 55.1571 51.8434 53.6569 50.3431C52.1566 48.8429 50.1217 48 48 48Z" fill="black"/>
                    </g>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M96 42C98.3638 42 100.704 41.5344 102.888 40.6298C105.072 39.7253 107.056 38.3994 108.728 36.7279C110.399 35.0565 111.725 33.0722 112.63 30.8883C113.534 28.7044 114 26.3638 114 24C114 21.6362 113.534 19.2956 112.63 17.1117C111.725 14.9278 110.399 12.9435 108.728 11.2721C107.056 9.60062 105.072 8.27475 102.888 7.37017C100.704 6.46558 98.3638 6 96 6C91.2261 6 86.6477 7.89642 83.2721 11.2721C79.8964 14.6477 78 19.2261 78 24C78 28.7739 79.8964 33.3523 83.2721 36.7279C86.6477 40.1036 91.2261 42 96 42ZM95.536 31.28L105.536 19.28L102.464 16.72L93.864 27.038L89.414 22.586L86.586 25.414L92.586 31.414L94.134 32.962L95.536 31.28Z" fill="#dcc861"/>
                    <defs>
                    <clipPath id="clip0_710_19682">
                    <rect width="96" height="96" fill="white" transform="translate(0 12)"/>
                    </clipPath>
                    </defs>
                    </svg>


                <br>
                <b class="fs-4">{{ __('lang.address') }}</b>
                <br>
                <p class="text-muted">{{ getSettingValue('address_'.app()->getLocale()) }}</p>

            </div>
        </div>
    </div>
</div>
<div class="container pt-5 mb-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <b class="fs-3 text-dark border--title p{{ isRtl() ? 'e' : 's' }}-2"style="border-{{ isRtl() ? 'right' : 'left' }}: 10px solid #dcc861">{{ getSettingValue('contact_us_title2_'.app()->getLocale()) }}</b>
            <p class="pt-2 w-50 mx-auto">{{ getSettingValue('contact_us_description2_'.app()->getLocale()) }}</p>
        </div>

        <div class="col-md-12 pt-4">
            <div class="form pt-3 w-75 mx-auto">
                <form action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 pt-4">
                            <div class="form-group">
                                <input type="text" name="fullname" id="fullname" class="form-control p-4 w3-light-gray border-0" placeholder="{{ __('lang.name') }}" id="">
                            </div>
                        </div>
                        <div class="col-md-6 pt-4">
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control p-4 w3-light-gray border-0" placeholder="{{ __('lang.email') }}" id="">
                            </div>
                        </div>

                        <div class="col-md-6 pt-4">
                            <div class="form-group">
                                <input type="text" name="phone" id="phone" class="form-control p-4 w3-light-gray border-0" placeholder="{{ __('lang.phone') }}" id="">
                            </div>
                        </div>

                        <div class="col-md-6 pt-4">
                            <div class="form-group">
                                <input type="text" name="subject" id="subject" class="form-control p-4 w3-light-gray border-0" placeholder="{{ __('front.subject') }}" id="">
                            </div>
                        </div>

                        <div class="col-md-12 pt-4">
                            <div class="form-group">
                                <textarea name="message" rows="5" id="message" class="form-control p-4 w3-light-gray border-0" placeholder="{{ __('front.message') }}" id=""></textarea>
                            </div>
                        </div>

                        <div class="col-md-12 pt-4 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn btn--custom">

                                    {{ __('front.send_message') }}
                                    <svg width="25" height="25" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="20.5" cy="20" r="20" fill="white"/>
                                        <path d="M22.172 20L17.222 15.05L18.636 13.636L25 20L18.636 26.364L17.222 24.95L22.172 20Z" fill="#dcc861"/>
                                        </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endSection

@section('js')

@endsection
