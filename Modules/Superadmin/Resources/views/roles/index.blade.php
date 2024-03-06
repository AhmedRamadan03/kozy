@extends('superadmin::layouts.master')
@section('title', __('lang.roles'))
@section('content')

    @include('superadmin::layouts.includes.breadcrumb', ['title' => __('lang.roles')])

    <div class="row">
        <div class="col-md-12">

            @component('superadmin::layouts.includes.card')
                @slot('tool')
                    <a href="{{ route('admin.role.create') }}"  class="btn  bg-primary "> <span class="feather-15" data-feather="plus"></span> @lang('lang.add')</a>
                @endslot

                @slot('content')

                    @component('superadmin::layouts.includes.table', ['title' => __('lang.roles')])

                        @slot('headers')
                            <th>#</th>
                            <th>@lang('lang.name')</th>
                            <th>@lang('lang.actions')</th>
                        @endslot

                        @slot('data')
                        @if (count($data) >0 )
                             @foreach ($data as $item)
                               <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                   <td>{{ !isRtl()?$item->name :$item->display_name }}</td>

                                   <td style="display: flex">
                                    <a href="{{ route('admin.role.edit',$item->id) }}" data-container='.vendor-model' class=" text-primary">
                                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.role.delete', $item->id) }}" class="sw-alert text-danger" data-confirm-delete="true">
                                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </a>
                                </td>
                               </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">
                                    @include('superadmin::layouts.includes.alert')
                                </td>
                            </tr>
                        @endif

                        @endslot

                    @endcomponent

                @endslot
            @endcomponent
        </div>


    </div>

@endsection

@section('js')

@endsection
