@extends('website::layouts.master')

@section('title')
    {{ __('front.my_profile') }}
@endsection
@section('css')
    <style>
        table>thead>tr>th,
        table>tbody>tr>td {
            padding: 20px !important;
            border: none !important;
        }
    </style>
@endsection

@section('content')

<section class="mt-5 mb-5">

    <div class="container">
       <div class="row">
        <div class="col-md-3">
            @include('website::profile.includes.nav')
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <b class="fs-3 main-color">{{ __('front.my_orders') }}</b>


                    <div class="pt-4 table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light ">
                                <tr>
                                    <th scope="col">{{ __('front.order_number') }}</th>
                                    <th scope="col">{{ __('front.date') }}</th>
                                    <th scope="col">{{ __('front.total') }}</th>
                                    <th scope="col">{{ __('front.status') }}</th>
                                    <th scope="col">{{ __('lang.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->ref }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->total }}</td>
                                        <td>{{ __('lang.order_status.'.$order->status) }}</td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <a class="btn btn-danger sw-alert btn-sm"
                                                    href="{{ route('front.profile.cancel-order', $order->ref) }}">
                                                    {{ __('front.cancel_order') }}
                                                </a>
                                            @else
                                            ----
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>


        </div>
       </div>
    </div>
</section>

@endsection
