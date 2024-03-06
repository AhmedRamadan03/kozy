@php
    $title = $resource->id ?  __('lang.edit') .' ' . __('lang.admin')   : __('lang.add') .' ' . __('lang.admin');
@endphp

@extends('superadmin::layouts.master')

@section('title')
    {{ $title }}
@endsection


@section('content')
    @include('superadmin::layouts.includes.breadcrumb' , ['title' => $title ,'new_item'=>__('lang.admins'), 'url'=>route('admin.admin.index')])

    <div class="row pt-4">
        <div class="col-md-12">
            @component('superadmin::layouts.includes.card' )
                @slot('content')
                <form class="form" action="{{ $resource->id?route('admin.admin.update',$resource->id):route('admin.admin.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                   <div class="container">

                    {{-- admin info --}}
                    <div class="row mb-5">
                        <div class="col-12 pt-3 text-center">

                            {!! Form::label('image', __('lang.image') , ['class' => 'form-label'] ) !!} <br>
                                <div class="student_image">
                                    <img class=" image-preview-image  "    src="{{ asset($resource->image ?? 'assets/img/default.jpg' ) }}">
                                </div>

                            <br>
                            <label for="image"class="btn btn-primary text-white mt-2">
                                <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
                            </label>

                            <input type="file" onchange="changeImage(this, 'image')" id="image" class="d-none form-control mt-3" name="image" >
                        </div>
                        <hr>
                        <div class="col-md-6 pt-4">
                            <div class="form-group">
                                {!! Form::label('country_id', __('lang.choose') . ' ' .__('lang.country'), ['class' => 'form-label']) !!} <span  class="text-danger">: * </span>
                                {!! Form::select('country_id', $countries, old('country_id', $resource->country_id), ['class' => 'form-control form-select select2' , 'required' , 'id' => 'country_id' , 'placeholder' => __('lang.choose') . ' ' .__('lang.country')]) !!}
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                {!! Form::label('username', __('lang.username') , ['class' => 'form-label'] ) !!} <span  class="text-danger">*</span>
                                {!! Form::text('username', $resource->username, ['class' => 'form-control' , 'required']) !!}
                            </div>
                        </div>

                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                {!! Form::label('email', __('lang.email') , ['class' => 'form-label'] ) !!} <span  class="text-danger">*</span>
                                {!! Form::email('email', old('email', $resource->email), ['class' => 'form-control' , 'required' , 'autocomplete' => 'new-email' , 'placeholder' => 'ex@gmail.com']) !!}
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                {!! Form::label('phone', __('lang.phone') , ['class' => 'form-label'] ) !!} <span  class="text-danger">*</span>
                                {!! Form::number('phone', old('phone', $resource->phone), ['class' => 'form-control' , 'required' ,  'placeholder' => '01********']) !!}
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                {!! Form::label('role', __('lang.role') , ['class' => 'form-label'] ) !!} <span  class="text-danger">*</span>
                                <select name="role_id" id="" class="form-control form-select select2">
                                    <option value="">{{ __('lang.choose') . ' ' .__('lang.role') }}</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == optional($resource->roles()->first())->id? 'selected' : '' }}>{{ isRtl()?$role->name :$role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group">
                                {!! Form::label('password', __('lang.password') ,  ['class' => 'form-label'] ) !!}   <span  class="text-danger">*</span>
                                {!! Form::password('password', ['class' => 'form-control' ,  'autocomplete' => 'new-password' , 'placeholder' => '********']) !!}
                            </div>
                        </div>


                    </div>


                   </div>
                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
                    </div>
                </form>
                @endslot
            @endcomponent
        </div>

    </div>
@endsection

