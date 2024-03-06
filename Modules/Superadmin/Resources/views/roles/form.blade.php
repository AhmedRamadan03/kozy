@extends('superadmin::layouts.master')
@php
    $title = $resource->id ?  __('lang.edit') . ' ' . __('lang.role') : __('lang.add') . ' ' . __('lang.role')

@endphp

@section('title',$title)
@section('content')

    @include('superadmin::layouts.includes.breadcrumb', ['title' =>$title,'new_item'=>__('lang.roles'), 'url'=>route('admin.role.index')])


    <div class="row">
        <div class="col-md-12">

            <form class="" action="{{ $resource->id?route('admin.role.update',$resource->id):route('admin.role.store') }}" method="post" enctype="multipart/form-data">
                @csrf
            @component('superadmin::layouts.includes.card', ['title' => $title])
                @slot('content')
                <div class="row">

                    <div class="col-md-6 pt-2">
                        <div class="form-group">
                            <label>{{ __('lang.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required
                                value="{{ old('name', $resource->name ?? '') }}">
                        </div>
                    </div>

                    <div class="col-md-6 pt-2">
                        <div class="form-group">
                            <label>{{ __('lang.display_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="display_name" required
                                value="{{ old('display_name', $resource->display_name ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-12 pt-2">
                        <div class="form-group">
                            <label>{{ __('lang.description') }}</label>
                            <input type="text" class="form-control" name="description"
                                value="{{ old('description', $resource->description ?? '') }}">
                        </div>
                    </div>

                </div>
                @endslot
            @endcomponent

                <div class="row">
                    <div class="" style="margin-top: 20px!important">
                        <div class="card-header" style="padding: 15px!important">
                            <h3>{{ __('lang.permissions') }}</h3>
                            <label class="d-block" for="CheckAllPerm">
                                <input type="checkbox" class="w3-check checkbox_animated" id="CheckAllPerm"> {{ __('lang.select_all') }}
                            </label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($permissions as $category => $listPermissions)
                                <div class="col-md-4" >

                                    @component('superadmin::layouts.includes.card', ['title' => __('lang.'.$category ),'class'=>'  d-flex justify-content-between'])
                                    @slot('tool')
                                    <input type="checkbox" class="w3-check me-2 ms-2 checkbox_animated selectedBoxPerm" onchange="checkAll(this )" data-category="{{ $category }}" id="{{ $category }}">
                                    @endslot

                                    @slot('content')
                                    <ul class="w3-ul sub-list">
                                        @foreach($listPermissions as $permission)
                                        <li style="border-bottom: 0px" >
                                            <label class=""></label>
                                                @php $old = old('permissions') @endphp
                                                <label class="d-block" for="chk-ani-{{ $permission->id }}">
                                                    <input class="checkbox_animated selectedBoxPerm {{ $category }} checkbox w3-check" id="chk-ani-{{ $permission->id }}"  type="checkbox"name="permissions[]" value="{{ $permission->id }}" {{ isset($old) ? (in_array($permission->id , old('permissions')) ? 'checked' : '') : '' }} {{ isset($rolePermissions) ? (in_array($permission->id , $rolePermissions) ? 'checked' : '') : '' }} data-bs-original-title="" title=""> <b>{{ app()->getLocale() == 'ar' ? $permission->description : $permission->display_name }}</b>
                                                  </label>
                                                {{-- <input type="checkbox" class="w3-check selectedBoxPerm checkbox" > --}}
                                                <span></span>
                                            </label>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endslot
                                    @endcomponent
                                </div>
                                @endforeach
                            </div>


                        </div>
                    </div>


                </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">
                    @if ($resource->id)
                    {{ __('lang.update') }}
                    @else
                    {{ __('lang.save') }}
                    @endif
                  </button>
              </div>
          </form>
        </div>



    </div>
    {{-- <div class="modal fade role-model" id="vendor-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div> --}}
@endsection

@section('js')
<script>
    $('#CheckAllPerm').on('click', function() {
            if($(this).prop('checked') === true) {
                $('.selectedBoxPerm').prop('checked', true);

            }else {
                $('.selectedBoxPerm').prop('checked', false);
            }
        });

        function checkAll(el ){
            var category = $(el).data('category');
            if($(el).prop('checked') === true) {
                $('.'+category).prop('checked', true);
            }else {
                $('.'+category).prop('checked', false);
            }
        }
    </script>
@endsection






