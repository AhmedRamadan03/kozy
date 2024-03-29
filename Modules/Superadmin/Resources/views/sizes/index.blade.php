@extends('superadmin::layouts.master')

@php
    $title = __('lang.sizes');
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
               <a href="{{ route('admin.mainPageForProducts') }}"  class="btn  btn-info float-end mb-2"> <i class="ti ti-arrow-back-up"></i> {{ __('lang.back')  }}</a>
               @if (auth()->user()->isAbleTo('admin_create-sizes'))

               <a data-href="{{ route('admin.size.create') }}"  data-container=".table-modal" class="btn btn-modal btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.size') }}</a>
               @endif

                   @endslot

               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                           <td>{{ __('lang.name') }}</td>
                           <td>{{ __('lang.value') }}</td>

                           <td>{{ __('lang.actions') }}</td>
                       @endslot

                       @slot('data')
                           @if (isset($data))
                               @foreach ($data as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>

                                            <b> {{ $item->name }}</b>
                                        </td>
                                        <td>
                                            {{ $item->value }}
                                        </td>
                                        <td>
                                            @if (auth()->user()->isAbleTo('admin_update-sizes'))

                                            <a data-href="{{ route('admin.size.edit',$item->id) }}"  data-container=".table-modal"  class="btn btn-modal btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            @endif
                                            @if (auth()->user()->isAbleTo('admin_delete-sizes'))

                                            <a href="{{ route('admin.size.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
                                            @endif
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


@endsection
