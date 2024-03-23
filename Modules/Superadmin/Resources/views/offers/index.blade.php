@extends('superadmin::layouts.master')

@php
    $title = __('lang.offers');
@endphp

@section('title')
    {{ $title }}
@endsection


@section('content')

    @include('superadmin::layouts.includes.breadcrumb' , [
        'title' => $title,
        // 'pagetitle' => __('lang.offers'),
        'url' => route('admin.offer.index'),
    ])
 @if(auth()->user()->show_all ==1)
 <div class="row pt-4">
     <div class="col-md-12">
        @component('superadmin::layouts.includes.card' ,['title'=>__('lang.filter')])

            @slot('content')
                 <form action="{{ route('admin.offer.index') }}" method="get">
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
                                 <a href="{{ route('admin.offer.index') }}" class="btn w3-light-grey"> <i class="ti ti-reload"></i>{{ __('lang.reset') }}</a>
                             </div>
                         </div>
                     </div>
                 </form>
            @endslot
        @endcomponent
     </div>
 </div>
 @endif
    <div class="row pt-2">
        <div class="col-md-12">
           @component('superadmin::layouts.includes.card' )
               @slot('tool')
               @if (auth()->user()->isAbleTo('admin_create-offers'))

               <a href="{{ route('admin.offer.create') }}"   class="btn btn-primary d-grid float-end mb-2 ">
                <i class="  bx bx-plus"> {{ __('lang.add') . ' ' . __('lang.offer') }}</i>

            </a>
            @endif
               @endslot

               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                            @if(auth()->user()->show_all ==1)
                            <td>{{ __('lang.country') }}</td>
                           @endif
                           <td>{{ __('lang.product_name') }}</td>
                           <td>{{ __('lang.start_date') }}</td>
                           <td>{{ __('lang.end_date') }}</td>
                           <td>{{ __('lang.actions') }}</td>
                       @endslot

                       @slot('data')
                           @if (isset($data))
                               @foreach ($data as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @if(auth()->user()->show_all ==1)
                                        <td>{{ optional($item->country)->title }}</td>
                                        @endif
                                        <td>
                                            <img src="{{ asset(optional($item->product)->image) }}" class="border-8" width="100px" height="40px" alt="">
                                            <b>{{ optional($item->product)->title }}</b>
                                        </td>

                                        <td>
                                            {{ $item->start_date }}
                                        </td>

                                        <td>
                                            {{ $item->end_date }}
                                        </td>
                                        <td>
                                            @if (auth()->user()->isAbleTo('admin_edit-offers'))

                                            <a href="{{ route('admin.offer.edit',$item->id) }}"   class="btn  btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            @endif
                                            @if (auth()->user()->isAbleTo('admin_delete-offers'))

                                            <a href="{{ route('admin.offer.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
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
@section('scripts')


@endsection
