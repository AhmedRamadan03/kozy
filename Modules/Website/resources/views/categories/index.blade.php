@extends('website::layouts.master')
@section('css')
@endsection
@section('title')
    {{ __('front.categories') }}
@endsection

@section('content')
{{-- <div class="panner d-flex" style="background-image: url({{ asset(getSettingValue('mata_banner')) }})">
    <div class="container d-flex">
            <div class="text d-flex align-items-center">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb" style="   {{ isRtl() ? ' flex-direction: row-reverse;' : '' }}">
                        <li class="breadcrumb-item "><a class="w3-text-black"
                                href="{{ route('front.home') }}">{{ __('front.home') }}</a></li>
                        <li class="breadcrumb-item main-color" aria-current="page">{{ __('front.categories') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div> --}}


    <div class="pt-5 container mb-5">
        <div class="row">
            <div class="col-md-3" >
                <div class="--categories p-3" style="height: 100%">
                    <h4 class="border--main text-dark bold p-2">{{ __('front.product_categories') }}</h4>

                    <div class="pt-2">
                        @foreach ($categories as $cat)
                            <div class="item pt-4">
                                <div class="head d-flex justify-content-between"
                                    onclick="toggleSubCategories(this, {{ $cat->id }})">
                                    <b class="{{ request()->main_cat == $cat->slug ? 'main-color' : '' }}"> {{ $cat->title }}</b>
                                    <span id="arrow-{{ $cat->id }}">
                                        <svg width="12" height="7" viewBox="0 0 12 7" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 0.999999L6 6L11 1" stroke="#14090A" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>

                                    </span>
                                </div>
                                <div class="sub {{ request()->category ? (in_array(request()->category, $cat->children->pluck('slug')->toArray()) ? '' : 'hidden') : 'hidden' }} m-2"
                                    id="sub-{{ $cat->id }}">
                                    @foreach ($cat->children as $item)
                                        <a class="{{ request()->category == $item->slug ? 'main-color' : '' }}"
                                            href="{{ route('front.categories') }}?category={{ $item->slug }}">{{ $item->title }}</a>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <br><br>
                    <h4 class="border--main text-dark bold p-2">{{ __('lang.brands') }}</h4>
                    <div>
                      @foreach ($brands as $item)
                      <input type="checkbox" {{ request()->brand == $item->slug ? 'checked' : '' }} class="w3-check" id="brand-{{ $item->id }}"
                        onclick="window.location.href='{{ route('front.categories') }}?brand={{ $item->slug }}'">
                        <label class="text-dark" for="brand-{{ $item->id }}">{{ $item->title }}</label>

                        <br>
                      @endforeach
                    </div>
                    <br><br>
                    <h4 class="border--main text-dark bold p-2">{{ __('front.availability') }}</h4>
                    <div>
                        <input type="checkbox" {{ request()->in_stock ? 'checked' : '' }} class="w3-check" id="in_stock"
                            onclick="window.location.href='{{ route('front.categories') }}?in_stock=true'">
                        <label class="text-dark" for="in_stock">{{ __('front.in_stock') }}</label>

                        <br>

                        <input type="checkbox" {{ request()->onsale ? 'checked' : '' }} class="w3-check" id="onsale"
                            onclick="window.location.href='{{ route('front.categories') }}?onsale=true'">
                        <label class="text-dark" for="onsale">{{ __('front.on_sale') }}</label>
                    </div>
                    <br><br>
                    <h4 class="border--main text-dark bold p-2">{{ __('front.filter_by_price') }}</h4>
                    <div>
                       <form action="{{ route('front.categories') }}" method="GET">
                        @csrf
                        <fieldset class="filter-price">

                            <div class="price-field">
                                <input type="range" min="50" max="5000" value="{{ request()->min ?? 50 }}" id="lower">
                                <input type="range" min="50" max="5000" value="{{ request()->max ?? 5000 }}" id="upper">
                            </div>
                            <div class="price-wrap">
                                <div class="d-flex align-items-center">
                                    <b>{{ __('front.price') }}</b>
                                    <div class="">
                                        <input name="min" value="{{ request()->min }}" id="one"> {{ __('front.sar') }}
                                    </div>
                                    <div class="">--</div>
                                    <div class="2">
                                        <input name="max" value="{{ request()->max }}" id="two">{{ __('front.sar') }}

                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <button type="submit" class="btn  btn--custom">{{ __('front.filter') }}</button></button>
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="--categories p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="item text-dark">
                                    <b>{{ count($products) }} </b> {{ __('front.products_found') }}
                                </div>
                                <div class="item text-dark">
                                    <select class="form-select  select2" name="sort" onchange="window.location.href='{{ route('front.categories') }}?sort='+this.value" id="">
                                        <option value="">{{ __('front.sort_by') }}</option>
                                        <option value="DESC" {{ request()->sort == 'DESC' ? 'selected' : '' }}> {{ __('front.latest') }}</option>
                                        <option value="ASC" {{ request()->sort == 'ASC' ? 'selected' : '' }}> {{ __('front.oldest') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 pt-3">
                        <div class="row">
                            @if ($products->count()>0)
                            @foreach ($products as $item)
                            <div class="col-lg-4 col-md-6 col-12 pt-3">
                                @component('website::includes.product-card', ['item' => $item])
                                @endcomponent
                            </div>
                        @endforeach
                            @else
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <b class="display-5 text-dark border--title p{{ isRtl() ? 'e' : 's' }}-2"
                                        style="border-{{ isRtl() ? 'right' : 'left' }}: 10px solid #ED3436">
                                        {{ __('front.no_products') }}</b>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function toggleSubCategories(el, id) {
            $('#sub-' + id).slideToggle('fast');
            $('#sub-' + id).toggleClass('hidden');
            if ($('#sub-' + id).hasClass('hidden')) {
                $('#arrow-' + id).html(
                    '<svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 0.999999L6 6L11 1" stroke="#14090A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                    )
            } else {
                $('#arrow-' + id).html(
                    '<svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 11L6 6L1 1" stroke="#ED3436" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                    )
            }
        }
    </script>

    <script>
        var lowerSlider = document.querySelector('#lower');
        var upperSlider = document.querySelector('#upper');

        document.querySelector('#two').value = upperSlider.value;
        document.querySelector('#one').value = lowerSlider.value;

        var lowerVal = parseInt(lowerSlider.value);
        var upperVal = parseInt(upperSlider.value);

        upperSlider.oninput = function() {
            lowerVal = parseInt(lowerSlider.value);
            upperVal = parseInt(upperSlider.value);

            if (upperVal < lowerVal + 4) {
                lowerSlider.value = upperVal - 4;
                if (lowerVal == lowerSlider.min) {
                    upperSlider.value = 4;
                }
            }
            document.querySelector('#two').value = this.value
        };

        lowerSlider.oninput = function() {
            lowerVal = parseInt(lowerSlider.value);
            upperVal = parseInt(upperSlider.value);
            if (lowerVal > upperVal - 4) {
                upperSlider.value = lowerVal + 4;
                if (upperVal == upperSlider.max) {
                    lowerSlider.value = parseInt(upperSlider.max) - 4;
                }
            }
            document.querySelector('#one').value = this.value
        };
    </script>
@endsection
