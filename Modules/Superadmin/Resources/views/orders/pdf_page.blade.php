<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>

<body>
    <div class="page-content-wrapper boxed-items orders" style="direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="row">
            <div class="col-md-12">
                <div class=" row" id="General">
                    <h3 class=""> <b>{{ __('lang.general') }} </b></h3>


                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.status') }}:</strong> <span
                                    class="label label-sm label-bg-{{ $data->status }}">{{ __('lang.order_status.' . $data->status) }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.ref') }}:</strong> {{ $data->ref }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.total') }}:</strong> {{ $data->total }}
                                {{ optional($data->country)->currency }}</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('front.subtotal') }}:</strong> {{ $data->sub_total }}
                                {{ optional($data->country)->currency }}</p>
                        </div>
                    </div>
                    {{-- @if ($data->discount > 0)
                        <div class="col-lg-6 col-md-12 pt-2">
                            <div class="display_elem">
                                <p><strong>{{ __('lang.discount') }}:</strong> {{ $data->discount }}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 pt-2">
                            <div class="display_elem">
                                <p><strong>{{ __('lang.after_discount') }}:</strong>
                                    {{ $data->after_discount }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 pt-2">
                            <div class="display_elem">
                                <p><strong>{{ __('lang.coupon') }}:</strong> {{ $data->coupon }}</p>
                            </div>
                        </div>
                    @endif --}}
                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.tax') }}:</strong> {{ $data->tax }}
                                {{ optional($data->country)->currency }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('front.shipping') }}:</strong>
                                {{ $data->shipping }} {{ optional($data->country)->currency }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('front.payment_method') }}:</strong>
                                {{ __('lang.' . $data->payment_method) }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.product_num') }}:</strong>
                                {{ $data->details_count }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.products_quantity') }}:</strong>
                                {{ $data->details->sum('quantity') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.customer_name') }}:</strong>
                                {{$data->name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.username') }}:</strong>
                                {{$data->user->name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.date') }}:</strong> <span
                                    class="ltr inline-block">{{ $data->created_at->format('d-m-Y | h:i a') }}</span>
                            </p>
                        </div>
                    </div>
                    {{-- <div class="col-lg-12 pt-2">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.invoice') }}: </strong> <a href="{{ route('dashboard.orders.invoice', $data->id) }}" target="_blank" title="{{ __('lang.view_invoice') }}" class="invoice-color">{{ __('lang.view_invoice') }}</a> </p>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="Products">
                    <hr>
                    <h3><b>{{ __('lang.products') }}</b>

                    </h3>


                    <div class="table-responsive">
                        <table style="margin-top: 10px;"
                            class="table table-bordered table-striped table-condensed flip-content">
                            <thead class="flip-content">
                                <tr>
                                    <th >{{ __('lang.sku') }}</th>
                                    <th style="width: 300px;"> {{ __('lang.product') }} </th>
                                    <th> {{ __('lang.image') }} </th>
                                    <th> {{ __('lang.price') }} </th>
                                    <th> {{ __('lang.color') }} </th>
                                    <th> {{ __('lang.size') }} </th>
                                    <th> {{ __('lang.quantity') }} </th>
                                    <th> {{ __('lang.total') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->details as $get)
                                    <tr>
                                        <td>
                                            {{ $get->product->sku }}
                                        </td>

                                        <td>
                                            @if ($get->product)
                                                <a class="main_color"
                                                    href="{{ route('admin.product.show', $get->product_id) }}">{{ $get->product->title }}</a>
                                            @else
                                                {{ $get->product->title }}
                                            @endif
                                        </td>
                                        <td class="open_img">
                                            <a href="{{ asset($get->product ? $get->product->image : null) }}"
                                                title="{{ $get->product->title }}">
                                                <img style="width: 70px;height: 70px;border-radius: 4px;"
                                                    src="{{ asset($get->product ? $get->product->image : null) }}">
                                            </a>
                                        </td>

                                        <td><strong>{{ number_format($get->cost / $get->quantity, 2, '.', '') }}</strong>
                                            <small>{{ optional($data->country)->currency }}</small>
                                        </td>

                                        <td>
                                            <span class="" style="margin:0px 8px;border-radius: 12px;padding: 1px 20px;background: {{ optional($get->color)->value }}">
                                            </span>
                                        </td>
                                        <td>{{ optional($get->size)->value }}</td>
                                        <td>{{ $get->quantity }}</td>

                                        <td><strong>{{ $get->cost }}</strong>
                                            <small>{{ optional($data->country)->currency }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
                <div class="row" id="Shipping">
                    <h3 class=""> <b>{{ __('lang.shipping_address') }} </b></h3>


                    <div class="col-lg-6 col-md-12 pt-3">
                        <div class="display_elem">
                            <p><strong>{{ __('lang.phone') }}:</strong> <span class="inline-block"
                                    style="direction: ltr">{{ json_decode($data->address)->phone??'' }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- <div class="col-lg-6 col-md-12 pt-3">
                        <div class="display_elem"><p><strong>{{ __('lang.region') }}:</strong> {{ $data->address['region'][app()->getLocale()]['title'] }}</p></div>
                    </div> --}}



                    <div class="col-lg-6 col-md-12 pt-3">
                        <div class="display_elem">
                            <p><strong>{{ __('front.street') }}:</strong>
                                {{ json_decode($data->address)->street  ?? '----' }}</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 pt-3">
                        <div class="display_elem">
                            <p><strong>{{ __('front.district') }}:</strong>
                                {{ json_decode($data->address)->district  ?? '----' }}</p>
                        </div>
                    </div>


                    <div class="col-lg-6 col-md-12 pt-3">
                        <div class="display_elem">
                            <p><strong>{{ __('front.postal_code') }}:</strong>
                                {{ json_decode($data->address)->postal_code  ?? '----' }}</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 pt-3">
                        <div class="display_elem">
                            <p><strong>{{ __('front.notes') }}:</strong>
                                {{ json_decode($data->address)->notes  ?? '----' }}</p>
                        </div>
                    </div>
                </div>
            </div>
          </div>
    </div>

</body>

</html>
