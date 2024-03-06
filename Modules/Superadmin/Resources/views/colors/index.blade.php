@extends('superadmin::layouts.master')

@php
    $title = __('lang.colors');
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
                <a data-href="{{ route('admin.color.create') }}"  data-container=".table-modal" class="btn btn-modal btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.color') }}</a>

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
                                            <span class="" style="margin:0px 8px;border-radius: 12px;padding: 1px 20px;background: {{ $item->value }}">
                                            </span>
                                        </td>
                                        <td>

                                            <a data-href="{{ route('admin.color.edit',$item->id) }}"  data-container=".table-modal"  class="btn btn-modal btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            <a href="{{ route('admin.color.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
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

<script>

</script>
@endsection
