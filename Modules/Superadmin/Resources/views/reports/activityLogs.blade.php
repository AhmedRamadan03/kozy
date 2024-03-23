@extends('superadmin::layouts.master')

@php
    $title = __('lang.activity_logs');
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
                    <form action="{{ route('admin.report.activityLogs') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 col-sm-4">
                                <div class="form-group">
                                    <label for="date_to"><small>{{ __('lang.admin') }}</small></label>
                                    {!! Form::select('causer_id', $admins, old('admin_id', request()->admin_id ?? ''), [
                                        'class' => 'form-control select-bs',
                                        'id' => 'admin_id',
                                        'placeholder' => __('lang.choose'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="status">{{ __('lang.date') }}</label>
                                        <div class=" input-daterange ">
                                            <input type="text" name="datefilter" class="form-control"
                                                value="{{ old('datefilter', request()->datefilter ?? '') }}" />

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-4">
                                <div class="form-group">
                                    <label for="date_to"><small>{{ __('lang.log_name') }}</small></label>
                                    <select name="log_name" id="log_name" class="form-control select-bs">
                                        <option value="">{{ __('lang.choose') }}
                                            {{ __('lang.log_name') }} </option>
                                        @foreach ($logNames as $key => $name)
                                            <option value="{{ $name }}"
                                                {{ old('log_name', request()->log_name ?? '') == $name ? 'selected' : '' }}>
                                                {{ __('lang.' . $name) }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4">
                                <div class="form-group">
                                    <label for="date_to"><small>{{ __('lang.page') }}</small></label>
                                    <select name="page" id="page" class="form-control select-bs">
                                        <option value="">{{ __('lang.choose') }} {{ __('lang.page') }}
                                        </option>
                                        @foreach ($pages as $key => $name)
                                            <option value="{{ $name }}"
                                                {{ old('page', request()->page ?? '') == $name ? 'selected' : '' }}>
                                                {{ __('lang.' . strtolower(str_replace('App\Models\\', '', $name))) }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pt-4">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"> <i class="ti ti-filter"></i>
                                        {{ __('lang.filter') }}</button>
                                    <a href="{{ route('admin.report.activityLogs') }}" class="btn w3-light-grey"> <i
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
                            <th>#</th>
                            <th>{{ __('lang.log_name') }}</th>
                            <th>{{ __('lang.description') }}</th>
                            <th>{{ __('lang.page') }}</th>
                            <th>{{ __('lang.created_by') }}</th>
                            <th>{{ __('lang.created_at') }}</th>

                        @endslot

                        @slot('data')
                            @if (isset($data))
                                @foreach ($data as $item)
                                    {{-- {{dd($item)}} --}}
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td> {{ __('lang.' . $item->log_name) }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            {{ __('lang.' . strtolower(str_replace('App\Models\\', '', $item->subject_type))) }}
                                            - ({{ optional($item->subject())->ref ?? $item->subject_id }})
                                        </td>
                                        <td>{{ optional($item->causer)->username }}</td>
                                        <td>{{ $item->created_at }}</td>


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
