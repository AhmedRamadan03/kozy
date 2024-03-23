@extends('website::layouts.master')
@section('title')
    {{ __('front.checkout') }}
@endsection

@section('content')
    <div class="container mb-5">
        <div class="pt-5 mb-5">
            <h4><b class="bb-main">{{ __('front.checkout') }}</b></h4>
        </div>

        <div class="row pt-3">
            <div class="col-md-6">
                <b class="main-color">{{ __('front.billing_address') }}</b>
                <form action="{{ route('front.checkout.store') }}" method="post">
                    @csrf
                    <div class="card pt-3">
                        <div class="card-body">
                            <div class="row">



                                <div class="col-md-12 pt-2">
                                    <div class="form-group">
                                        <label for="">{{ __('front.name') }}</label>
                                        <input type="text" name="name" id="name" class="form-control p-3"
                                            placeholder="{{ __('front.name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 pt-2">
                                    <div class="form-group">
                                        <label for="">{{ __('front.district') }}</label>
                                        <input type="text" name="district" id="district" class="form-control p-3"
                                            placeholder="{{ __('front.district') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 pt-2">
                                    <div class="form-group">
                                        <label for="">{{ __('front.street') }}</label>
                                        <input type="text" name="street" id="street" class="form-control p-3"
                                            placeholder="{{ __('front.street') }}">
                                    </div>
                                </div>


                                <div class="col-12 pt-3">
                                    <label for="">{{ __('front.phone') }}</label>
                                    <input type="text" name="phone" id="phone" class="form-control p-3"
                                        placeholder="{{ __('front.phone') }}">
                                </div>
                                <div class="col-md-12 pt-3">
                                    <div class="form-group">
                                        <label for="">{{ __('front.postal_code') }}</label>
                                        <input type="text" name="postal_code" id="postal_code" class="form-control p-3"
                                            placeholder="{{ __('front.postal_code') }}">

                                    </div>
                                </div>
                                <div class="col-md-12 pt-3">
                                    <div class="form-group">
                                        <label for="">{{ __('front.notes') }}</label>
                                        <textarea name="notes" id="notes" class="form-control p-3"
                                            placeholder="{{ __('front.notes') }}"></textarea>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    {{-- <br>
                    <b class="main-color">{{ __('front.payment_method') }}</b> --}}

                    <div class="card pt-3 d-none">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="item p-3 w3-round-large " style="background: #FFF0E6">
                                        <input type="radio" name="payment_method" id="payment_method" value="cash_on_delivery" checked>
                                        <label for="payment_method" class="h4">{{ __('front.cash_on_delivery') }}</label>
                                    </div>
                                    <br>
                                    <div class="item p-3 w3-round-large " style="background: #FFF0E6">
                                        <input type="radio" name="payment_method" id="payment_method2" value="online_payment" >
                                        <label for="payment_method2" class="h4">{{ __('front.online_payment') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 pt-3">
                        <button type="submit" class="btn btn--custom w3-block btn-block">{{ __('front.place_order') }}</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">

                <b class="main-color">{{ __('front.deliviry_summary') }}</b>

                <div class="w3-light-gray w3-round-xlarge p-4">
                    @foreach ($cartData as $item)

                        <div class="item d-flex gap-3 align-items-center ">
                            <b>{{ $item->quantity }} x </b>
                            <img src="{{ asset($item->product->image) }}" width="80" class="border" alt="">
                            <span>
                                <b>{{ $item->product->title }}</b>
                                <br>
                                <span class="main-color">{{ $item->product->after_discount }} {{ __('front.sar') }}</span>

                                <br> <b class=" rounded-circle " style="padding: 1px 10px; background: {{ optional($item->color)->value }}"> </b> <b> - {{optional($item->size)->value }}</b>

                            </span>
                        </div>
                       @if (!$loop->last)
                       <hr>
                       @endif
                    @endforeach
                </div>
                <br>
                <div class="w3-light-gray w3-round-xlarge p-4">
                    <div class="d-flex pt-3 justify-content-between">
                        <b class="">{{ __('front.subtotal') }}</b>
                        <span class="ml-auto ">{{ $CheckoutData['sub_total'] }} {{ session('country')->currency }}</span>
                    </div>
                    <div class="d-flex pt-3 justify-content-between">
                        <b class="">{{ __('front.tax') }} ( {{ session('country')->tax}} %)</b>
                        <span class="ml-auto text-success">{{ $CheckoutData['tax'] }} {{ session('country')->currency }}</span>
                    </div>

                    <div class="d-flex pt-3 justify-content-between">
                        <b class="">{{ __('front.shipping') }}</b>
                        <span class="ml-auto">{{ $CheckoutData['shipping'] ?? 0.00 }} {{ session('country')->currency }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <b class="h4">{{ __('front.total') }}</b>
                        <b class="h4 ml-auto">{{ $CheckoutData['total'] }} {{ session('country')->currency }}</b>
                    </div>
               </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#country_id').on('change', function() {

            var country_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ route('front.checkout.get_cities') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    country_id: country_id
                },
                success: function(data) {
                    var html = '<option value="">{{ __('front.select_city') }}</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    }
                    $('#city_id').html(html);

                }
            });

        });
    </script>
@endsection
