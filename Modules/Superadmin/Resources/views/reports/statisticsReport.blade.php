@php $titlePage = __('lang.statistics_report') @endphp
@extends('superadmin::layouts.master')
@section('title')
    {{ $titlePage }}
@stop
@section('css')
{{-- <link rel="stylesheet" href="https://laravel.pixelstrap.com/cuba/build/assets/app-735d46ec.css" /> --}}
<style>
.widget-1 {
    background-image: url(https://laravel.pixelstrap.com/cuba/build/assets/widget-bg-a2f1cbe6.png);
    background-size: cover;
    margin-bottom: 25px;
}

.card {
    margin-bottom: 30px;
    border: none;
    transition: all .3s ease;
    letter-spacing: .5px;
    border-radius: 15px;
    box-shadow: 0 9px 20px #2e235e12;
}
.widget-1 .card-body {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    padding: 18px 25px;
}
.widget-1 .widget-content {
    display: flex;
    align-items: center;
    gap: 15px;
}
.widget-1 .widget-round.warning {
    border-color: #EB8426;
}

.widget-1 .widget-round {
    position: relative;
    display: inline-block;
    border-width: 1px;
    border-style: solid;
    border-radius: 100%;
}
.widget-1 .widget-round .bg-round {
    width: 56px;
    height: 56px;
    box-shadow: 1px 2px 21px -2px #d6d6e3d4;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 100%;
    margin: 6px;
    position: relative;
    z-index: 1;
}

</style>
@stop
@section('content')
    <div class="page-content-wrapper regions">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>{{ $titlePage }}</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6  pt-2" style="padding-top:50px ">
                   <div class="row mt-5">
                    <div class="col-12 pt-2">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round reached">
                                        <div class="bg-round">
                                            <svg viewBox="0 0 24 24" width="36" height="36" stroke="#ddd" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>                                    </div>
                                    </div>
                                    <div>
                                        <h2>{{ round($total, 1) }}  </h2><span class="f-light">{{__('lang.total_sales') }}</span>
                                    </div>
                                </div>
                                {{-- <div class="font-secondary f-w-500">{{ round($value['total'], 1) }}    </div> --}}
                            </div>
                        </div>
                    </div>



                   </div>
                </div>

            </div>
            <div class="row">
                @foreach ($data as $key => $value)

                <div class="col-md-4">
                    <div class="card widget-1">
                        <div class="card-body">
                            <div class="widget-content">
                                <div class="widget-round  warning">
                                    <div class="bg-round">
                                        <svg viewBox="0 0 24 24" width="36" height="36" stroke="#ddd" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                    </div>
                                </div>
                                <div>
                                    <h2>{{$value['count'] }}</h2><span class="f-light">{{__('lang.order_status.'.$value['status']) }}</span>
                                </div>
                            </div>
                            <div class="font-secondary main-color f-w-500">{{ round($value['total'], 1) }}  </div>
                        </div>
                    </div>
                </div>
                @endforeach



            </div>



        </div>
    </div>
@stop

@section('js')

@endsection
