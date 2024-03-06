@extends('superadmin::layouts.master')

@php
    $title = __('lang.exam_repots');
@endphp

@section('title')
    {{ $title }}
@endsection


@section('content')

    @include('superadmin::layouts.includes.breadcrumb' , ['title' => $title])

    <div class="row pt-4">
        <div class="col-md-12">
            @component('superadmin::layouts.includes.card', [
                'title' => __('lang.filter'),
                'id' => 'filter_body',
                'action' => true,
                'icon' => true,
            ])
                @slot('content')
                    <form action="{{ route('admin.report.exam') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-3 pt-2">
                                <div class="form-group">
                                    {!! Form::text('search', request()->search, [
                                        'class' => 'form-control',
                                        'placeholder' => __('lang.search_by') . ',' . __('lang.name')  . ',' . __('lang.phone'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 pt-2">
                                <div class="form-group">
                                    {!! Form::select('exam_id', $exams, request()->exam_id, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('lang.choose') . ' ' . __('lang.exam'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 pt-2">
                                <div class="form-group">
                                    {!! Form::select('level_id', $levels, request()->level_id, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('lang.choose') . ' ' . __('lang.level'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 pt-2">
                                <div class="form-group">
                                    {!! Form::select('group_id', $groups, request()->group_id, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('lang.choose') . ' ' . __('lang.group'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 pt-2">
                                <div class="form-group">
                                    {!! Form::select('sort', ['asc' => __('lang.ascending'), 'desc' => __('lang.descending')], request()->sort, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('lang.choose') . ' ' . __('lang.sort'),
                                    ]) !!}
                                </div>
                            </div>

                            <div class="col-md-4 pt-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="ti ti-search"></i>
                                        {{ __('lang.search') }}</button>
                                    <a href="{{ route('admin.report.exam') }}" class="btn btn-secondary"><i
                                            class="ti ti-refresh"></i> {{ __('lang.reset') }}</a>
                                </div>
                            </div>
                    </form>
                @endslot
            @endcomponent
        </div>
        <div class="col-md-12">
           @component('superadmin::layouts.includes.card' )

               @slot('tool')
                   <a href="{{ route('admin.report.exam.export') }}?{{ request()->getQueryString() }}"   class="btn  btn-primary float-end mb-2">
                    <i class="ti ti-file"></i>     {{ __('lang.export') }}
                </a>
               @endslot
               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                           <td>{{ __('lang.exam') }}</td>
                           <td>{{ __('lang.student') }}</td>
                           <td>{{ __('lang.phone') }}</td>
                           <td>{{ __('lang.group') }}</td>
                           <td>{{ __('lang.exam_grade') }}</td>
                           <td>{{ __('lang.student_grade') }}</td>
                           <td>{{ __('lang.time') }}</td>
                           <td>{{ __('lang.actions') }}</td>
                       @endslot

                       @slot('data')
                           @if (isset($examReports))
                               @foreach ($examReports as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{optional($item->exam)->title }}</td>
                                        <td>{{optional($item->user)->fullname }}</td>
                                        <td>{{optional($item->user)->phone }}</td>
                                        <td>{{optional($item->user)->group->title }}</td>
                                        <td>{{optional($item->exam)->grade }}</td>
                                        <td>{{ $item->student_grade }}</td>
                                        <td>{{ $item->current_time }} دقيقة</td>
                                        <td>
                                            <a target="_blank" href="{{ route('admin.student.show-exam-answer',[$item->user_id,$item->exam_id]) }}" class="btn btn-sm btn-info">
                                                <i class="ti ti-file"></i>
                                                {{ __('lang.show_answer') }}
                                            </a>
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
                    {{ $examReports->appends(request()->query())->render() }}
                </div>
               @endslot


           @endcomponent
        </div>
    </div>


</div>
@endsection

