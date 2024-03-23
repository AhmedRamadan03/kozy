@extends('superadmin::layouts.master')

@php
    $title = __('lang.main_settings');
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
                 <form action="{{ route('admin.setting.update') }}"  method="post" enctype="multipart/form-data">
                    @csrf

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="main-info-tab" data-bs-toggle="tab" data-bs-target="#main-info" type="button" role="tab" aria-controls="main-info" aria-selected="true">{{ __('lang.main_info') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">{{ __('lang.contact') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="meta-tag-tab" data-bs-toggle="tab" data-bs-target="#meta-tag" type="button" role="tab" aria-controls="meta-tag" aria-selected="false">{{ __('lang.meta_tag') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="return_rules-tab" data-bs-toggle="tab" data-bs-target="#return_rules" type="button" role="tab" aria-controls="return_rules" aria-selected="false">{{ __('lang.return_rules') }}</button>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="main-info" role="tabpanel" aria-labelledby="main-info-tab">
                                @include('superadmin::settings.includs.main_info' ,['settings' => $settings])
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            @include('superadmin::settings.includs.contacts' ,['settings' => $settings])
                        </div>
                        <div class="tab-pane fade" id="meta-tag" role="tabpanel" aria-labelledby="meta-tag-tab">
                            <div class="col-md-12 pt-3">
                                <div class="form-group">
                                   <label for="meta_banner">{{ __('lang.meta_banner') }}</label>
                                    <div style="width: 100%;border: 1px dashed #ccc; padding: 10px">
                                        <img class=" image-preview-mata_banner" width="100%"  src="{{ asset(optional($settings->where('key','mata_banner')->first())->value) }}">
                                    </div>
                                <br>
                                <label for="mata_banner"class="btn btn-primary text-white mt-2">
                                    <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
                                </label>

                                <input type="file" onchange="changeImage(this, 'mata_banner')" id="mata_banner" class="d-none form-control mt-3" name="mata_banner" >


                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="return_rules" role="tabpanel" aria-labelledby="return_rules-tab">
                            @foreach (config('translatable.locales') as $key => $locale)
                            <div class="col-md-12 pt-3">
                                <div class="form-group">
                                    <label for="name">
                                        {{ __('lang.return_rules_'.$locale) }}
                                    </label>
                                    {!! Form::textarea("return_rules_".$locale, old("return_rules_{$locale}", optional($settings->where('key','return_rules_'.$locale)->first())->value), ['class' => 'form-control tinymce']) !!}
                                </div>
                            </div>
                        @endforeach
                        </div>

                    </div>
                    @if (auth()->user()->isAbleTo('admin_update-settings'))

                    <div class="modal-footer pt-5 text-center">
                        <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
                    </div>
                    @endif
                 </form>
               @endslot
           @endcomponent
        </div>
    </div>

    <div class="modal fade table-modal" id="table-model" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
</div>
@endsection

@section('js')

@endsection
