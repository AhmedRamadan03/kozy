@extends('superadmin::layouts.master')

@php
    $title = __('lang.todos');
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
               @if (auth()->user()->isAbleTo('admin_create-todos'))

               <a data-href="{{ route('admin.todo.create') }}"  data-container=".table-modal" class="btn btn-modal btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.todo') }}</a>
               @endif
               @endslot

               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                           <td>{{ __('lang.subject') }}</td>
                           <td>{{ __('lang.task') }}</td>
                           <td>{{ __('lang.end_date') }}</td>
                           <td>{{ __('lang.status') }}</td>
                           <td>{{ __('lang.actions') }}</td>
                       @endslot

                       @slot('data')
                           @if (isset($data))
                               @foreach ($data as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>

                                            <b> {{ $item->subject }}</b>
                                        </td>
                                        <td>
                                            {{ $item->task }}
                                        </td>
                                        <td>
                                            {{ $item->end_date }}
                                        </td>
                                        <td>
                                            @if ($item->status == 'complet')
                                            <span class="badge bg-success"> {{ __('lang.'. $item->status) }}</span>
                                            @else
                                            <form action="{{ route('admin.todo.change-status') }}" method="post" id="form-status">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <select name="status" id="status" onchange="$('#form-status').submit()" class="form-control select2">
                                                    @foreach ($status as $key =>$st)
                                                        <option {{ $item->status == $st ?'selected':'' }} value="{{ $st }}"> {{ __('lang.'.$st) }}</option>
                                                    @endforeach
                                                </select>
                                               </form>
                                            @endif
                                        </td>
                                        <td>
                                            @if (auth()->user()->isAbleTo('admin_read-todos'))

                                            <a data-href="{{ route('admin.todo.notes',$item->id) }}"  data-container=".table-modal"  class="btn btn-modal btn-info btn-sm"><i class="ti ti-note"></i></a>
                                            @endif
                                            @if (auth()->user()->isAbleTo('admin_read-todos'))

                                            <a data-href="{{ route('admin.todo.show',$item->id) }}"  data-container=".table-modal"  class="btn btn-modal btn-info btn-sm"><i class="ti ti-eye"></i></a>
                                            @endif
                                            @if (auth()->user()->isAbleTo('admin_update-todos'))

                                            <a data-href="{{ route('admin.todo.edit',$item->id) }}"  data-container=".table-modal"  class="btn btn-modal btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            @endif
                                            @if (auth()->user()->isAbleTo('admin_delete-todos'))

                                            <a href="{{ route('admin.todo.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
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
