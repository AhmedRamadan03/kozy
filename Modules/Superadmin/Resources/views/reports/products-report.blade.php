@extends('superadmin::layouts.master')

@php
    $title = __('lang.products_qty_reports');
@endphp
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css"
integrity="sha512-gp+RQIipEa1X7Sq1vYXnuOW96C4704yI1n0YB9T/KqdvqaEgL6nAuTSrKufUX3VBONq/TPuKiXGLVgBKicZ0KA=="
crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('title')
    {{ $title }}
@endsection


@section('content')

    @include('superadmin::layouts.includes.breadcrumb', ['title' => $title])

    <div class="row pt-4">
        <div class="col-md-12">
            @component('superadmin::layouts.includes.card', [
                'title' => __('lang.filter'),
                'id' => 'filter_body',
                'action' => true,
                'icon' => true,
            ])
                @slot('content')
                    <form action="{{ route('admin.report.productsReport') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('search',__('lang.search'), ['class' => 'form-label']) !!}
                                    {!! Form::text('search',request()->search,['class' => 'form-control'])!!}
                                </div>
                            </div>
                                @if(auth()->user()->show_all ==1)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('country_id', __('lang.choose') . ' ' .__('lang.country'), ['class' => 'form-label']) !!}
                                        {!! Form::select('country_id', $countries, old('country_id', request()->country_id), ['class' => 'form-control form-select select2' ,  'id' => 'country_id' , 'placeholder' => __('lang.choose') . ' ' .__('lang.country')]) !!}
                                    </div>
                                </div>
                                @endif

                            <div class="col-md-4 pt-4">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"> <i class="ti ti-filter"></i>
                                        {{ __('lang.filter') }}</button>
                                    <a href="{{ route('admin.report.productsReport') }}" class="btn w3-light-grey"> <i
                                            class="ti ti-reload"></i>{{ __('lang.reset') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                @endslot
            @endcomponent
        </div>
        <div class="col-md-12">
            @component('superadmin::layouts.includes.card')
                {{-- @slot('tool')
                    <a href="{{ route('admin.report.orders.export') }}?{{ request()->getQueryString() }}"
                        class="btn  btn-primary float-end mb-2">
                        <i class="ti ti-file"></i> {{ __('lang.export') }}
                    </a>
                @endslot --}}
                @slot('content')
                    @component('superadmin::layouts.includes.table')
                        @slot('headers')
                            <td>{{ __('lang.sku') }}</td>
                            @if (auth()->user()->show_all == 1)
                                <td>{{ __('lang.country') }}</td>
                            @endif
                            <td>{{ __('lang.name') }}</td>
                            <td>{{ __('lang.quantity') }}</td>

                        @endslot

                        @slot('data')
                            @if (isset($data))
                                @foreach ($data as $item)
                                    {{-- {{dd($item)}} --}}
                                    <tr class="">
                                        <td>{{ $item->sku }}</td>
                                        @if (auth()->user()->show_all == 1)
                                            <td>{{ optional($item->country)->title }}</td>
                                        @endif
                                        <td>
                                            <b> {{ $item->title }}</b>
                                        </td>

                                        <td>
                                            <b> {{ $item->quantity }}</b>
                                        </td>


                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">
                                        <div class="text-center alert alert-warring">
                                            {{ __('lang.no_data_found') }}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endslot
                    @endcomponent
                    <div class="pt-3 text-center">
                        {{ $data->appends(request()->query())->render() }}
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>


    </div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/moment.min.js"
integrity="sha512-i2CVnAiguN6SnJ3d2ChOOddMWQyvgQTzm0qSgiKhOqBMGCx4fGU5BtzXEybnKatWPDkXPFyCI0lbG42BnVjr/Q=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"
integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script type="text/javascript">
$(function() {

    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
            'MM/DD/YYYY'));
        orders_table.ajax.reload();
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

});
</script>
@endsection
