@extends('superadmin::layouts.master')

@php
    $title = __('lang.features');
@endphp

@section('title')
    {{ $title }}
@endsection


@section('content')

    @include('superadmin::layouts.includes.breadcrumb' , ['title' => $title])

    <div class="row pt-4">
        <div class="col-md-12">
           @component('superadmin::layouts.includes.card' )
               @slot('tool')
                   <a href="{{ route('admin.feature.create') }}"   class="btn  btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.feature') }}</a>
               @endslot

               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                            <td>{{ __('lang.title') }}</td>
                            <td>{{ __('lang.description') }}</td>
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
                                            {{ $item->title }}
                                        </td>
                                        <td>{{ Str::limit($item->description, 50) }}</td>

                                        <td>
                                            <a href="{{ route('admin.feature.edit',$item->id) }}" class="btn  btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            <a href="{{ route('admin.feature.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
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


