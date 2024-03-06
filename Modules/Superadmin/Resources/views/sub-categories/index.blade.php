@extends('superadmin::layouts.master')

@php
    $title = __('lang.subcats');
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
                <a href="{{ route('admin.category.index') }}"  class="btn  btn-info float-end mb-2"> <i class="ti ti-arrow-back-up"></i> {{ __('lang.back')  }}</a>
                   <a data-href="{{ route('admin.subcat.create',$mainCategory->id) }}"  data-container=".table-modal" class="btn btn-modal btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.category') }}</a>

                   @endslot

               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                           <td>{{ __('lang.name') }}</td>
                           <td>{{ __('lang.status') }}</td>

                           <td>{{ __('lang.actions') }}</td>
                       @endslot

                       @slot('data')
                           @if (isset($data))
                               @foreach ($data as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{asset($item->image)}}" style="width:50px" class="rounded-circle">

                                            <b> {{ $item->title }}</b>
                                        </td>
                                        <td>

                                            <a class="form-check form-switch d-flex m-1 justify-content-between text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('lang.change_status') }}" >
                                                <input class="form-check-input "   type="checkbox" role="switch" id="flexSwitchCheckChecked-{{ $item->id }}" onclick="changeStatus(this,{{ $item->id }})" {{ $item->hide == 1 ? '' : 'checked' }}>
                                                <label class="form-check-label" for="flexSwitchCheckChecked-{{ $item->id }}">

                                                </label>
                                            </a>
                                        </td>
                                        <td>

                                            <a data-href="{{ route('admin.subcat.edit',$item->id) }}"  data-container=".table-modal"  class="btn btn-modal btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            <a href="{{ route('admin.subcat.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
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
    function changeStatus(el , id){
        var hide = 1 ;
        if(el.checked){
            hide = 0 ;
        }
        $.ajax({
            url: "{{ route('admin.subcat.change-status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                is_active: hide
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
