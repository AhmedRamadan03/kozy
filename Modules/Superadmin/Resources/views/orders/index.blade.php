@extends('superadmin::layouts.master')

@php
    $title = __('lang.orders');
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
            @component('superadmin::layouts.includes.card', ['title' => __('lang.filter')])
                @slot('content')
                    <form action="{{ route('admin.order.index') }}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('search', __('lang.search_by'), ['class' => 'form-label']) !!}
                                    {!! Form::text('search', request()->search, [
                                        'class' => 'form-control',
                                        'placeholder' => __('lang.search_by') . ' ' . __('lang.ref') . ', ' . __('lang.name') . ', ' . __('lang.phone'),
                                    ]) !!}
                                </div>
                            </div>
                            @if (auth()->user()->show_all == 1)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('country_id', __('lang.choose') . ' ' . __('lang.country'), ['class' => 'form-label']) !!}
                                        {!! Form::select('country_id', $countries, old('country_id', request()->country_id), [
                                            'class' => 'form-control form-select select2',
                                            'id' => 'country_id',
                                            'placeholder' => __('lang.choose') . ' ' . __('lang.country'),
                                        ]) !!}
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('status', __('lang.status'), ['class' => 'form-label']) !!}
                                    <select name="status" class="form-control select2 update_status">
                                        <option value="">{{ __('lang.select') . __('lang.status') }}</option>
                                        @foreach ((new App\Models\Order())->statuses() as $status)
                                            <option {{ request()->status == $status ? 'selected' : '' }}
                                                value="{{ $status }}">
                                                {{ __('lang.order_status.' . $status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status" class="form-label">{{ __('lang.date') }}</label>
                                    <div class=" input-daterange ">
                                        <input type="text" name="datefilter" class="form-control"
                                            id="datefilter"
                                            value="{{ old('datefilter', request()->datefilter ?? '') }}" />

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pt-4">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"> <i class="ti ti-filter"></i>
                                        {{ __('lang.filter') }}</button>
                                    <a href="{{ route('admin.order.index') }}" class="btn w3-light-grey"> <i
                                            class="ti ti-reload"></i>{{ __('lang.reset') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                @endslot
            @endcomponent
        </div>
    </div>
    <div class="row pt-4">
        <div class="col-md-12">
            @component('superadmin::layouts.includes.card')
                {{-- @slot('tool')
                <a data-href="{{ route('admin.order.create') }}"  data-container=".table-modal" class="btn btn-modal btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.order') }}</a>

                   @endslot --}}

                @slot('content')
                    @component('superadmin::layouts.includes.table')
                        @slot('headers')
                            <td>{{ __('lang.ref') }}</td>
                            @if (auth()->user()->show_all == 1)
                                <td>{{ __('lang.country') }}</td>
                            @endif
                            <td>{{ __('lang.name') }}</td>
                            <td>{{ __('lang.phone') }}</td>
                            <td>{{ __('lang.address') }}</td>
                            {{-- <td>{{ __('lang.tax') }}</td>
                           <td>{{ __('lang.shipping') }}</td> --}}
                            <td>{{ __('lang.total') }}</td>
                            <td>{{ __('lang.product_num') }}</td>
                            <td>{{ __('lang.date') }}</td>
                            <td>{{ __('lang.status') }}</td>

                            <td>{{ __('lang.actions') }}</td>
                        @endslot

                        @slot('data')
                            @if (isset($data))
                                @foreach ($data as $item)
                                    {{-- {{dd($item)}} --}}
                                    <tr class="{{ $item->show ==0 ?'w3-light-gray' :'' }}">
                                        <td>{{ $item->ref }}</td>
                                        @if (auth()->user()->show_all == 1)
                                            <td>{{ optional($item->country)->title }}</td>
                                        @endif
                                        <td>
                                            <b> {{ $item->name }}</b>
                                        </td>
                                        <td>
                                            <a href="tel: {{ json_decode($item->address)->phone ?? '' }}">
                                                {{ json_decode($item->address)->phone ?? '' }} <i class="fa fa-phone"></i></a>
                                        </td>
                                        <td>
                                            <b> {{ json_decode($item->address)->street ?? '' }}</b>
                                        </td>
                                        {{-- <td>
                                            <b> {{ $item->tax }}</b>
                                        </td>
                                        <td>
                                            <b> {{ $item->shipping }}</b>
                                        </td> --}}
                                        <td>
                                            <b> {{ $item->total }}</b>
                                        </td>
                                        <td>
                                            <b> {{ $item->details->count() }}</b>
                                        </td>
                                        <td>
                                            <b> {{ $item->created_at }}</b>
                                        </td>
                                        <td>
                                            @if (auth()->user()->isAbleTo('admin_update-orders'))

                                            <form action="{{ route('admin.order.status', $item->id) }}"
                                                method="post" id="change_status_form">
                                                @csrf
                                                <div
                                                    class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">

                                                    <select onchange="changeStatus(this)" data-id="{{ $item->status }}" id="change_status"
                                                        name="status" class="form-control select2">
                                                        @foreach ($statuses as $stat)
                                                            <option {{ $item->status == $stat ? 'selected' : '' }}
                                                                value="{{ $stat }}">
                                                                {{ __('lang.order_status.' . $stat) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </form>
                                            @else
                                                {{ __('lang.order_status.' . $item->status) }}
                                            @endif

                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-list fs-4"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if (auth()->user()->isAbleTo('admin_read-orders'))

                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.order.show', $item->id) }}">
                                                            <i class="ti ti-eye"></i>
                                                            {{ __('lang.view_order') }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @if (auth()->user()->isAbleTo('admin_read-orders'))

                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.order.pdfview', $item->id) }}">
                                                            <i class="ti ti-file"></i>
                                                            {{ __('lang.order_details') }}(PDF)
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @if (auth()->user()->isAbleTo('admin_update-orders'))

                                                    <li>
                                                        <a class="dropdown-item btn-modal" data-container=".table-modal" data-href="{{ route('admin.order.admin-notes', $item->id) }}">
                                                            <i class="ti ti-note"></i>
                                                            {{ __('lang.admin_notes') }}
                                                        </a>
                                                    </li>
                                                    @endif

                                                </ul>
                                            </div>
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
                @endslot
            @endcomponent
        </div>
    </div>

    <div class="modal fade table-modal" id="table-model" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

<script>
    function changeStatus(el) {
        if (confirm('Are you sure you want to change status?')) {
            $(el).closest('form').submit()
        }
    }
</script>
@endsection
