@extends('superadmin::layouts.master')

@php
    $title = __('lang.cities');
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
                   <a data-href="{{ route('admin.city.create') }}"  data-container=".table-modal" class="btn btn-modal btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.city') }}</a>
               @endslot

               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                           <td>{{ __('lang.name') }}</td>

                           <td>{{ __('lang.actions') }}</td>
                       @endslot

                       @slot('data')
                           @if (isset($data))
                               @foreach ($data as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>

                                        <td>
                                            <a data-href="{{ route('admin.city.edit',$item->id) }}"  data-container=".table-modal"  class="btn btn-modal btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            <a href="{{ route('admin.city.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
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
    $(document).on('change', '#start_date , #end_date', function() {
        var start_date = formatedDate($('#start_date').val());
        var end_date = formatedDate($('#end_date').val());

        $('#year_name').val(start_date + ' : ' + end_date);
        console.log('start_date : ' + start_date + ' end_date : ' + end_date);
     });

     function formatedDate(date) {
        alert(date);
        var m =  date.split("-")[1];
        var y = date.split("-")[0]
        return y + '-' + m;
     }

   </script>
@endsection
