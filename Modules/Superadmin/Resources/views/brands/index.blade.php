@extends('superadmin::layouts.master')

@php
    $title = __('lang.brands');
@endphp

@section('title')
    {{ $title }}
@endsection


@section('content')

    @include('superadmin::layouts.includes.breadcrumb' , ['title' => $title])

    @if(auth()->user()->show_all ==1)
    <div class="row pt-4">
        <div class="col-md-12">
           @component('superadmin::layouts.includes.card' ,['title'=>__('lang.filter')])

               @slot('content')
                    <form action="{{ route('admin.brand.index') }}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('country_id', __('lang.choose') . ' ' .__('lang.country'), ['class' => 'form-label']) !!} <span  class="text-danger">: * </span>
                                    {!! Form::select('country_id', $countries, old('country_id', request()->country_id), ['class' => 'form-control form-select select2' , 'required' , 'id' => 'country_id' , 'placeholder' => __('lang.choose') . ' ' .__('lang.country')]) !!}
                                </div>
                            </div>
                            <div class="col-md-6 pt-4">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"> <i class="ti ti-filter"></i> {{ __('lang.filter') }}</button>
                                    <a href="{{ route('admin.brand.index') }}" class="btn w3-light-grey"> <i class="ti ti-reload"></i>{{ __('lang.reset') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
               @endslot
           @endcomponent
        </div>
    </div>
    @endif
    <div class="row pt-4">
        <div class="col-md-12">
           @component('superadmin::layouts.includes.card' )
               @slot('tool')
               @if (auth()->user()->isAbleTo('admin_create-brands'))

               <a data-href="{{ route('admin.brand.create') }}"  data-container=".table-modal" class="btn btn-modal btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.brand') }}</a>
               @endif
               @endslot

               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                           <td>{{ __('lang.name') }}</td>
                           @if(auth()->user()->show_all ==1)
                            <td>{{ __('lang.country') }}</td>
                           @endif
                           <td>{{ __('lang.status') }}</td>

                           <td>{{ __('lang.actions') }}</td>
                       @endslot

                       @slot('data')
                           @if (count($data)>0)
                               @foreach ($data as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{asset($item->image)}}" style="width:50px" class="rounded-circle">

                                            <b> {{ $item->title }}</b>
                                        </td>
                                        @if(auth()->user()->show_all ==1)
                                        <td>{{ optional($item->country)->title }}</td>
                                        @endif
                                        <td>

                                            <a class="form-check form-switch d-flex m-1 justify-content-between text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('lang.change_status') }}" >
                                                <input class="form-check-input "   type="checkbox" role="switch" id="flexSwitchCheckChecked-{{ $item->id }}" onclick="changeStatus(this,{{ $item->id }})" {{ $item->hide == 1 ? '' : 'checked' }}>
                                                <label class="form-check-label" for="flexSwitchCheckChecked-{{ $item->id }}">

                                                </label>
                                            </a>
                                        </td>
                                        <td>
                                            @if (auth()->user()->isAbleTo('admin_update-brands'))

                                            <a data-href="{{ route('admin.brand.edit',$item->id) }}"  data-container=".table-modal"  class="btn btn-modal btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            @endif

                                            @if (auth()->user()->isAbleTo('admin_delete-brands'))

                                            <a href="{{ route('admin.brand.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
                                            @endif
                                        </td>
                                   </tr>
                               @endforeach
                           @else
                               <tr>
                                <td colspan="{{ auth()->user()->show_all ==1 ? 5 : 4 }}">
                                    @component('superadmin::layouts.includes.alert')

                                    @endcomponent
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
            url: "{{ route('admin.brand.change-status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                hide: hide
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
