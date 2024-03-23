@extends('superadmin::layouts.master')

@php
    $title = __('lang.about_us');
@endphp

@section('title')
    {{ $title }}
@endsection


@section('content')

    @include('superadmin::layouts.includes.breadcrumb' , ['title' => $title])

    <div class="row pt-4">
        <div class="col-md-12">
           @component('superadmin::layouts.includes.card' )


               @slot('content')
               <form class="form" action="{{route('admin.about.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4  pt-3 text-center">

                            {!! Form::label('image', __('lang.image') , ['class' => 'form-label'] ) !!} <br>
                            <img class=" image-preview-image border-8 " width="100%" height="200"   src="{{ asset($resource->image ?? 'assets/img/default.jpg' ) }}">
                            <br>
                            <label for="image"class="btn btn-primary text-white mt-2">
                                <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
                            </label>

                            <input type="file"  onchange="changeImage(this, 'image')" id="image" class="d-none form-control mt-3" name="image" >
                        </div>
                        <div class="clearfix"></div>
                        @foreach (config('translatable.locales') as $key => $locale)
                            <div class="col-md-12 pt-2">
                                <div class="form-group">
                                    <label for="name">
                                        {{ __('lang.'.$locale.'.title') }}
                                    </label>
                                    {!! Form::text("{$locale}[title]", old("{$locale}[title]", optional($resource->translate($locale))->title ??''), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        @endforeach
                        @foreach (config('translatable.locales') as $key => $locale)
                            <div class="col-md-6 pt-2">
                                <div class="form-group">
                                    <label for="name">
                                        {{ __('lang.'.$locale.'.short_description') }}
                                    </label>
                                    {!! Form::textarea("{$locale}[short_description]",old("{$locale}[short_description]", optional($resource->translate($locale))->short_description ??''), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        @endforeach
                        @foreach (config('translatable.locales') as $key => $locale)
                            <div class="col-md-6 pt-2">
                                <div class="form-group">
                                    <label for="name">
                                        {{ __('lang.'.$locale.'.description') }}
                                    </label>
                                    {!! Form::textarea("{$locale}[description]",old("{$locale}[description]", optional($resource->translate($locale))->description ??''), ['class' => 'form-control tinymce']) !!}
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

</div>
@endsection


@section('js')

@endsection
