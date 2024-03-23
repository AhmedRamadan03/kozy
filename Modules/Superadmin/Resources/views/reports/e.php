@php $titlePage = __('lang.activity_log_report') @endphp
@extends('dashboard.layouts.master')
@section('title')
    {{ $titlePage }}
@stop
@section('content')
    <div class="page-content-wrapper regions">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>{{ $titlePage }}</h1>
                </div>
            </div>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">{{ __('lang.dashboard') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ route('dashboard.pages.reportSection') }}">{{ __('lang.statistics_reports') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span class="active">{{ $titlePage }}</span>
                </li>
            </ul>
            <div class="row">

                <div class="portlet-body form form-body bordered">
                    <div class="search-content">
                        <form action="{{ route('dashboard.reports.activityLogs') }}" method="get" id="searchForm">
                            <div class="row">

                                <div class="col-md-12">
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

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <button type="submit" id="submit"
                                        class="btn btn_search green">{{ __('lang.search_now') }}</button>
                                    <a role="button" href="{{ route('dashboard.reports.activityLogs') }}" id="reset"
                                        class="btn btn_search ">{{ __('lang.reset') }}</a>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <div style="padding: 0;" class="form-body form_add form_product">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <table style="margin-top: 10px;"
                                        class="table table-bordered table-striped table-condensed flip-content">
                                        <thead class="flip-content">
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('lang.log_name') }}</th>
                                                <th>{{ __('lang.description') }}</th>
                                                <th>{{ __('lang.page') }}</th>
                                                <th>{{ __('lang.created_by') }}</th>
                                                <th>{{ __('lang.created_at') }}</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <br>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    {{-- Include Messages Flash --}}
                    @include('includes.flash_msg')
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css"
        integrity="sha512-gp+RQIipEa1X7Sq1vYXnuOW96C4704yI1n0YB9T/KqdvqaEgL6nAuTSrKufUX3VBONq/TPuKiXGLVgBKicZ0KA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
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
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        });
    </script>

@endsection
