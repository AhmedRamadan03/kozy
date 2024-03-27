@extends('website::layouts.master')
@section('css')
    <style>
        /* .nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            color: #ed3436 !important;
            border: none;
            border-bottom: 1px solid var(--primary);
        } */

        .pictures {
            list-style: none !important;
            margin: 0 !important;
            max-width: 30rem !important;
            padding: 0 !important;
            display: flex;
        }
    </style>
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
                        <li class="breadcrumb-item main-color" aria-current="page">{{ __('front.product_details') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div> --}}

    <div class="container pt-5 mb-5">
        <div class="row pt-4">
            <div class="col-md-7">

                {{-- <div class="product--image border p-2">
                    <img src="{{ asset($product->image) }}" width="90%" height="450" alt="{{ $product->title }}">
                    <div class="images d-flex gap-3 w-25 pt-2 mb-4" style="overflow-x: scroll">
                        @foreach ($product->all_images as $image)
                            <div class="border p-2">
                                <img src="{{ asset($image) }}" width="100" height="100" alt="{{ $product->title }}">
                            </div>
                        @endforeach
                    </div>
                </div> --}}

                <div class="product-image    rounded-3">
                    <div class="row">
                        <div class="col-md-3 pt-2 pb-2 text-center" >
                            <div id="galley">
                                <ul class="pictures d-flex" style="flex-direction: column;height: 450px;overflow: overlay;">
                                    @foreach ($product->all_images as $item)
                                        <li>
                                            <span class="w3-white">
                                                <img class="all_images" width="100%" height="120px" data-original="{{ asset($item) }}"
                                                    src="{{ asset($item) }}" alt="{{ $product->title }}">
                                            </span>
                                        </li>
                                    @endforeach

                                </ul>

                            </div>

                        </div>
                        <div class="col-9">
                            <img id="product_image" src="{{ asset($product->image) }}" alt=""
                                style="width: 100%; height: 450px" data-zoom-image="{{ asset($product->image) }}">

                        </div>
                    </div>

                </div>

            </div>
            <div class="col-md-5 p-5 pt-0">
                <h3><b>{{ $product->title }}</b></h3>

                <b class="fs-3">
                    <b class="main-color">{{ $product->after_discount }} {{ session('country')->currency }}</b>
                    @if ($product->discount > 0)
                        <del class="text-muted">{{ round($product->price) }} {{ session('country')->currency }}</del>
                    @endif
                </b>

                <div class="pt-3">
                    {{ $product->short_description }}
                </div>

                <form id="addToCart" style="display: contents;">
                    <div class="color pt-3">
                        {{-- : <span id="color_name"></span> --}}
                        <p><label for=""> </label></p>
                        <div class="btn-group-toggle" id="chooseColor" data-toggle="buttons">
                            <b class="me-3">{{ __('front.colors') }} </b>
                            @if (isset($product->variations))
                                @foreach ($product->variations()->groupBy('color_id')->select('color_id')->get() as $attr)
                                    {{-- {{ dd($attr) }} --}}
                                    {{-- @if (optional(optional($attr->attributeValue)->attribute)->type == 'color') --}}
                                    <label for="color-{{ $attr->color_id }}"
                                        class="btn p-0  {{ $loop->first ? ' active' : '' }}" style="">
                                        <input type="radio" class="d-none" value="{{ $attr->color_id }}"
                                            {{ $loop->first ? 'checked' : '' }} class="color"
                                            id="color-{{ $attr->color_id }}" name="attr_color_id">
                                        <div onclick="choseColorCustom(this)" data-product_id="{{ $product->id }}"
                                            data-attr_color_id="{{ $attr->color_id }}"
                                            data-color="{{ $attr->color->name }}"
                                            style="width: 44px;height: 44px;background:{{ $attr->color->value }}"
                                            class=" d-flex justify-content-center align-items-center w3-round-large">
                                            @if ($loop->first)
                                                <i style="width: 15px;height: 15px;background: white;border-radius: 8px;box-shadow:  0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);"
                                                    class="fa fa-check text-black"></i>
                                                {{-- <i class="fa fa-check text-white"></i> --}}
                                            @endif
                                        </div>
                                    </label>
                                    {{-- @endif --}}
                                @endforeach
                            @endif
                        </div>
                    </div><br>
                    <div class="col-12 ">

                    </div>
                    <div class=" m-0 sizes d-flex gap-3 mb-3">
                        <b class="me-3">{{ __('front.sizes') }}</b>
                        <span id="chooseSize">
                            @foreach ($product->variations()->groupBy('color_id')->select('color_id')->get() as $attr)
                                @if ($loop->first && count($product->getProSizes($attr->color_id)) > 0)
                                    @foreach ($product->getProSizes($attr->color_id) as $item)
                                        @if ($item->size_id)
                                            <input {{ $loop->first ? 'checked' : '' }} class="btn-check"
                                                id="size-{{ $item->size_id }}" onclick="getValue()" type="radio"
                                                autocomplete="off" value="{{ $item->size_id }}"
                                                data-size="{{ optional($item->size)->value }}" class="size"
                                                name="attr_size_id" id="size-{{ $item->size_id }}">
                                            <label class="btn btn-outline-danger" for="size-{{ $item->size_id }}">
                                                {{ optional($item->size)->value }}
                                            </label>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </span>
                    </div>

                    <div class="pt-2">
                        <b>{{ __('front.category') }} : </b> {{ $product->category->title }}
                    </div>
                    <div class="pt-4">
                        <b>{{ __('front.sku') }} : </b> {{ $product->sku }}
                    </div>
                    <div class="pt-4 d-flex gap-3 align-items-center">
                        <b>{{ __('front.share') }} : </b>
                        <div class="sharethis-inline-share-buttons"></div>
                    </div>
                    <div class="pt-5 d-flex align-items-center gap-3 ">
                        <b>{{ __('front.choose_quantity') }} : </b>
                        @if ($product->quantity > 0)
                            <div class="product-action d-flex gap-4 p-2 w3-round-xxlarge border"
                                style="justify-content: center">
                                <span class="action-mius minus_counter ">

                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="24" cy="24" r="24" fill="white" />
                                        <path
                                            d="M30 24.998H18C17.7348 24.998 17.4804 24.8927 17.2929 24.7052C17.1054 24.5176 17 24.2633 17 23.998C17 23.7328 17.1054 23.4785 17.2929 23.2909C17.4804 23.1034 17.7348 22.998 18 22.998H30C30.2652 22.998 30.5196 23.1034 30.7071 23.2909C30.8946 23.4785 31 23.7328 31 23.998C31 24.2633 30.8946 24.5176 30.7071 24.7052C30.5196 24.8927 30.2652 24.998 30 24.998Z"
                                            fill="#dcc861" />
                                    </svg>
                                </span>
                                <b class="action-number fs-2">1</b>
                                <input class="d-none action-input qtyProduct form-control" type="text" name="quantity"
                                    min="1" value="{{ old('quantity', 1) }}" readonly />
                                <span class="action-plus plus_counter ">
                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="24" cy="24" r="24" fill="white" />
                                        <path
                                            d="M30 24.998H25V29.998C25 30.2633 24.8946 30.5176 24.7071 30.7052C24.5196 30.8927 24.2652 30.998 24 30.998C23.7348 30.998 23.4804 30.8927 23.2929 30.7052C23.1054 30.5176 23 30.2633 23 29.998V24.998H18C17.7348 24.998 17.4804 24.8927 17.2929 24.7052C17.1054 24.5176 17 24.2633 17 23.998C17 23.7328 17.1054 23.4785 17.2929 23.2909C17.4804 23.1034 17.7348 22.998 18 22.998H23V17.998C23 17.7328 23.1054 17.4785 23.2929 17.2909C23.4804 17.1034 23.7348 16.998 24 16.998C24.2652 16.998 24.5196 17.1034 24.7071 17.2909C24.8946 17.4785 25 17.7328 25 17.998V22.998H30C30.2652 22.998 30.5196 23.1034 30.7071 23.2909C30.8946 23.4785 31 23.7328 31 23.998C31 24.2633 30.8946 24.5176 30.7071 24.7052C30.5196 24.8927 30.2652 24.998 30 24.998Z"
                                            fill="#dcc861" />
                                    </svg>

                                </span>
                            </div>
                            <input type="hidden" readonly value="{{ $product->id }}" class="prodId">
                        @endif
                    </div>
                    <div class="col-12 pt-4">
                        <div id="msgErrors" class="alert alert-danger  d-none "></div>

                        {{-- @if ($checkPlaceStore) --}}
                        @if ($product->quantity > 0 && auth()->user())
                            <button
                                class="btn btn-style w3-block  add-to-cart btn-addtocart"id="submitBtnAddCart"
                                type="submit" style="background: #DCC861">
                        <b>                                {{ __('front.add_to_cart') }}</b>
                                <span data-feather="shopping-cart">
                            </button>
                        @elseif (!auth()->user())
                            <a href="{{ route('login') }}" class="btn px-5  add-to-cart btn-style  text-dark w3-block " style="background: #DCC861">
                                <b>                                {{ __('front.add_to_cart') }}</b>
                                <span data-feather="shopping-cart">

                            </a>
                        @else
                            <button onclick="return false;"
                                class="btn px-5 custom-btn add-to-cart out-stock ">{{ __('lang.quantity_out') }}
                            </button>
                        @endif
                        {{-- @endif --}}

                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="row pt-3">
            <div class="col-md-12 shadow-sm">
                <ul class="nav nav-tabs " id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-dark" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button" role="tab" aria-controls="description"
                            aria-selected="true">{{ __('lang.description') }}</button>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                        <button class="nav-link text-dark" id="additional_info-tab" data-bs-toggle="tab"
                            data-bs-target="#additional_info" type="button" role="tab"
                            aria-controls="additional_info"
                            aria-selected="false">{{ __('front.additional_info') }}</button>
                    </li> --}}

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                        aria-labelledby="description-tab">
                        <div class="p-4">{!! $product->description !!}</div>
                    </div>
                    <div class="tab-pane fade" id="additional_info" role="tabpanel"
                        aria-labelledby="additional_info-tab">
                        <div class="p-4">{!! $product->additional_info !!}</div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                </div>
            </div>
        </div>


        <br><br>
        <div class="row">
            <d class="col-md-12 pt-3 mb-5">
                <div class="d-flex justify-content-{{ isRtl()?'start':'end' }}">
                    <b class="display-5 text-dark border--title p{{ isRtl() ? 'e' : 's' }}-2"
                        style="border-{{ isRtl() ? 'right' : 'left' }}: 10px solid #ED3436">
                        {{ __('front.same_products') }}</b>
                </div>
            </d>
            @foreach ($sameProducts as $item)
                <div class="col-lg-3 col-md-6">
                    @component('website::includes.product-card', ['item' => $item])
                    @endcomponent
                </div>
            @endforeach
        </div>
    </div>


    @include('website::categories.modal')
@endsection
@section('js')
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=65e728a59391bf00191aa162&product=inline-share-buttons&source=platform"
        async="async"></script>
    <script>
        function choseColorCustom(element) {
            var icon =
                '<i style="width: 15px;height: 15px;background: white;border-radius: 50%;box-shadow:  0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);" class="fa fa-check text-black"></i>'
            $('#color_name').empty();

            $('#color_name').append($(element).data('color'));
            $('.fa-check').remove();
            $('.rounded-circle').css('padding', ' 5px 15px');
            $(element).append(icon);
            $(element).css('padding', ' 5px 10px');
            var attr_color_id = $(element).data('attr_color_id');
            var product_id = $(element).data('product_id');
            $.ajax({
                url: "{{ route('front.get_product_sizes') }}",
                type: "GET",
                dataType: "html",
                data: {
                    color_id: attr_color_id,
                    product_id: product_id
                },
                success: function(response) {
                    $('#chooseSize').html(response);
                }
            })
        }

        $('.minus_counter').on('click', function(e) {
            e.preventDefault();
            var qtyProduct = $(this).parent().find('.qtyProduct');
            let value = +qtyProduct.val();
            let max = +qtyProduct.attr('max');
            let min = +qtyProduct.attr('min');

            if (value > min) {
                value = value - 1;
                qtyProduct.val(value);
                $('.action-number').html(value);
            }
        });

        $('.plus_counter').on('click', function(e) {
            // e.preventDefault();
            var qtyProduct = $(this).parent().find('.qtyProduct');
            let value = +qtyProduct.val();
            // let max = +qtyProduct.attr('max');
            // let qty = $('.quantity-span').text();
            // alert(qty);
            if (value) {
                value = value + 1;
                qtyProduct.val(value);
                $('.action-number').html(value);
            }
            // qtyProduct.val(value + 1)
        });



        $('#addToCart').submit(function(event) {
            event.preventDefault();

            let Self = $(this);
            let CartStoreR = $('#CartStoreR');
            let submitBtnAddCart = Self.find('#submitBtnAddCart');
            var msgErrors = $('#msgErrors');
            msgErrors.empty();

            // Set Send Data
            let sendData = {
                'product_id': $(this).find('.prodId').val(),
                'quantity': $(this).find('.qtyProduct').val(),
                'price': "{{ $product->after_discount }}",
            };

            // Set chooseColor ID
            // Set chooseColor ID
            if ($("#chooseColor input[type='radio']:checked").val()) {
                Object.assign(sendData, {
                    "color_id": $("#chooseColor input[type='radio']:checked").val()
                });
            }
            // Set chooseSize ID
            if ($("#chooseSize input[type='radio']:checked").val()) {
                Object.assign(sendData, {
                    "size_id": $("#chooseSize input[type='radio']:checked").val()
                });
            }

            $.ajax({
                url: CartStoreR.attr('href'),
                type: 'post',
                dataType: 'json',
                beforeSend: function() {
                    submitBtnAddCart.attr('disabled', true).append(
                        '<i class="	fa fa-refresh spinnerBTN rotating"></i>');
                },
                data: {
                    'cart': sendData,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(res) {
                    submitBtnAddCart.attr('disabled', false).find('.spinnerBTN').remove();
                    if (res.status === true) {
                        $('#AfterAddCart').modal('show');
                        $('#cart_header_box').html(res.data.resultCheckout);
                        $('.cart--count').html((res.data.items_count > 99 ? '+99' :
                            res.data.items_count));
                    } else if (res.status === false) {
                        $('#msgErrors').removeClass('d-none');
                        $('#msgErrors').html(res.message);
                    }
                },
                error: function(reject) {
                    submitBtnAddCart.attr('disabled', false).find('.spinnerBTN').remove();
                    if (reject.status === 422) {
                        var response = JSON.parse(reject.responseText);
                        var errorString =
                            '<div class="alert alert-danger d-flex justify-content-between" role="alert">' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><ul class="list-unstyled mb-0">';
                        $.each(response.errors, function(key, value) {
                            errorString += '<li>' + value + '</li>';
                        });
                        errorString += '</ul></div>';

                        msgErrors.empty();
                        msgErrors.append(errorString);
                    }
                }
            });
            return false;
        });


        $('#continueShopping').on('click', function(e) {
            e.preventDefault();
            $('#AfterAddCart').modal('hide');
        })
    </script>
@endsection
