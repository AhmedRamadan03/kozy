@php
    $title = $resource->id ?  __('lang.edit') .' ' . __('lang.feature')   : __('lang.add') .' ' . __('lang.feature');
@endphp

@extends('superadmin::layouts.master')

@section('title')
    {{ $title }}
@endsection


@section('content')
    @include('superadmin::layouts.includes.breadcrumb' , ['title' => $title ,'new_item'=>__('lang.features'), 'url'=>route('admin.feature.index')])

    <div class="row pt-4">
        <div class="col-md-12">
            @component('superadmin::layouts.includes.card' )
                @slot('content')
                <form class="form" action="{{ $resource->id?route('admin.feature.update',$resource->id):route('admin.feature.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                   <div class="container">

                    {{-- admin info --}}
                    <div class="row mb-5">
                        <div class="col-6 pt-3 text-center">

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
                        <div class="col-6 pt-3 text-center">

                            {!! Form::label('icon', __('lang.icon') , ['class' => 'form-label'] ) !!} <br>
                                <div class="student_icon">
                                    <img class=" image-preview-icon rounded-circle" width="30" height="30"   src="{{ asset($resource->icon ?? 'assets/img/default.jpg' ) }}">
                                </div>

                            <br>
                            <label for="icon"class="btn btn-primary text-white mt-2">
                                <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
                            </label>

                            <input type="file" onchange="changeImage(this, 'icon')" id="icon" class="d-none form-control mt-3" name="icon" >
                        </div>
                        <hr>

                        @foreach (config('translatable.locales') as $key => $locale)
                            <div class="col-md-12 pt-2">
                                <div class="form-group">
                                    <label for="name">
                                        {{ __('lang.'.$locale.'.title') }}
                                    </label>
                                    {!! Form::text("{$locale}[title]", old("{$locale}[title]", optional($resource->translate($locale))->title), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        @endforeach

                        @foreach (config('translatable.locales') as $key => $locale)
                            <div class="col-md-12 pt-2">
                                <div class="form-group">
                                    <label for="name">
                                        {{ __('lang.'.$locale.'.description') }}
                                    </label>
                                    {!! Form::textarea("{$locale}[description]", old("{$locale}[description]", optional($resource->translate($locale))->description), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        @endforeach

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

