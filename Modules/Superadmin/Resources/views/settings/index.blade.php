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
                          <button class="nav-link" id="short-tab" data-bs-toggle="tab" data-bs-target="#short" type="button" role="tab" aria-controls="short" aria-selected="false">{{ __('lang.prefixes') }}</button>
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
                                   <label for="courses_meta_tag">{{ __('lang.courses_meta_tag') }}</label>
                                    <div style="width: 100%;border: 1px dashed #ccc; padding: 10px">
                                        <img class=" image-preview-courses_bannar" width="100%"  src="{{ asset(optional($settings->where('key','courses_bannar')->first())->value) }}">
                                    </div>
                                <br>
                                <label for="courses_bannar"class="btn btn-primary text-white mt-2">
                                    <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
                                </label>

                                <input type="file" onchange="changeImage(this, 'courses_bannar')" id="courses_bannar" class="d-none form-control mt-3" name="courses_bannar" >


                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="short" role="tabpanel" aria-labelledby="short-tab">
                            @include('superadmin::settings.includs.shorts' ,['settings' => $settings])
                        </div>
                    </div>

                    <div class="modal-footer pt-5 text-center">
                        <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
                    </div>
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
<script src="https://cdn.tiny.cloud/1/npf26nqjnyh7ns7o68ybgruxr9duvrn2hvyhjwege3uc4ofy/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
    selector: ".tinymce",

    });
    </script>
@endsection
