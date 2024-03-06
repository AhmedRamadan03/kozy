@extends('superadmin::layouts.master')

@php
    $title = __('lang.admins');
@endphp

@section('title')
    {{ $title }}
@endsection


@section('content')

    @include('superadmin::layouts.includes.breadcrumb' , ['title' => $title])
    {{-- <div class="row mb-2">
        <div class="col-md-12">
            @component('superadmin::layouts.includes.card', [
                'title' => __('lang.filter'),
                'id' => 'filter_body',
                'action' => true,
                'icon' => true
            ])
            @slot('content')
                <form action="{{ route('admin.admin.index') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 pt-2">
                            <div class="form-group">
                                {!! Form::text('search', request()->search, ['class' => 'form-control' , 'placeholder' => __('lang.search_by'). ','.__('lang.name') .',' . __('lang.email').',' . __('lang.phone')]) !!}
                            </div>
                        </div>
                        <div class="col-md-4 pt-2">
                            <div class="form-group">
                                {!! Form::select('level_id', $levels, request()->level_id, ['class' => 'form-control select2' , 'placeholder' => __('lang.choose') . ' ' . __('lang.level')]) !!}
                            </div>
                        </div>
                        <div class="col-md-4 pt-2">
                            <div class="form-group">
                                {!! Form::select('city_id', $cities, request()->city_id, ['class' => 'form-control select2' , 'placeholder' => __('lang.choose') . ' ' . __('lang.city')]) !!}
                            </div>
                        </div>
                        <div class="col-md-4 pt-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="ti ti-search"></i> {{ __('lang.search') }}</button>
                                <a href="{{ route('admin.admin.index') }}" class="btn btn-secondary"><i class="ti ti-refresh"></i> {{ __('lang.reset') }}</a>
                        </div>
                    </div>
                </form>
            @endslot


            @endcomponent
        </div>
    </div> --}}
    <div class="row pt-4">
        <div class="col-md-12">
           @component('superadmin::layouts.includes.card' )
               @slot('tool')
                   <a href="{{ route('admin.admin.create') }}"   class="btn  btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.admin') }}</a>
               @endslot

               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                            <td>{{ __('lang.username') }}</td>
                            <td>{{ __('lang.email') }}</td>
                           <td>{{ __('lang.actions') }}</td>
                       @endslot

                       @slot('data')
                           @if (isset($data))
                               @foreach ($data as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset($item->image) }}" width="30" height="30" class="rounded-circle" alt="">
                                            @endif
                                            {{ $item->username }}
                                        </td>
                                        <td>{{ $item->email }}</td>

                                        <td>
                                            @if (auth()->user()->show_all == 1)

                                            <a href="{{ route('admin.admin.auto-login',$item->id) }}" target="_blank" class="btn  btn-warning btn-sm"><i class="ti ti-key"></i></a>
                                            @endif
                                            <a href="{{ route('admin.admin.edit',$item->id) }}" class="btn  btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            <a href="{{ route('admin.admin.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
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

           {{-- <div class="row">
            @if (count($data) >0)
                @foreach ($data as $item)
                    <div class="col-lg-3 col-md-4">
                        @include('superadmin::admins.item_card' , ['item' => $item])
                    </div>
                @endforeach
            @else
            @include('superadmin::layouts.includes.alert')
            @endif
           </div> --}}
        </div>
    </div>

    <div class="modal fade table-modal" id="table-model" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
</div>
@endsection


