@extends('superadmin::layouts.master')

@php
    $title = __('lang.copons');
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
                   <a data-href="{{ route('admin.copon.create') }}"  data-container=".table-modal" class="btn btn-modal btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.copon') }}</a>
               @endslot

               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                           <td>{{ __('lang.code') }}</td>
                           <td>{{ __('lang.discount_type') }}</td>
                           <td>{{ __('lang.discount') }}</td>
                           <td>{{ __('lang.expired_at') }}</td>
                           <td>{{ __('lang.status') }}</td>

                           <td>{{ __('lang.actions') }}</td>
                       @endslot

                       @slot('data')
                           @if (isset($data))
                               @foreach ($data as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{__('lang.'. $item->discount_type) }}</td>
                                        <td>{{ $item->discount }}</td>
                                        <td>{{ $item->expired_at }}</td>
                                        <td>
                                            <a class="form-check form-switch d-flex m-1 justify-content-between text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('lang.change_status') }}" >
                                                <input class="form-check-input"   type="checkbox" role="switch" id="flexSwitchCheckChecked-{{ $item->id }}" onclick="changeStatus(this,{{ $item->id }})" {{ $item->status == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexSwitchCheckChecked-{{ $item->id }}"></label>
                                        </a>
                                        </td>

                                        <td>
                                            <a data-href="{{ route('admin.copon.edit',$item->id) }}"  data-container=".table-modal"  class="btn btn-modal btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            <a href="{{ route('admin.copon.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
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

    <div class="modal fade table-modal" id="table-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
</div>
@endsection

@section('js')

<script>
    function changeStatus(el , id){
        var is_active = 0 ;
        if(el.checked){
            is_active = 1 ;
        }
        $.ajax({
            url: "{{ route('admin.copon.change-status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                is_active: is_active
            },
            success: function (results) {
               if (results.success) {
                    swal.fire("", results.message, "success");
               } else {
                    swal.fire("", message, "error");
               }
            }
        });
    }
</script>
@endsection
