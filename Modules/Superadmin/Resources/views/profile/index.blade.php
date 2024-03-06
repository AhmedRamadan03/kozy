@php
    $title = __('lang.profile') ;
@endphp

@extends('superadmin::layouts.master')

@section('title')
    {{ $title }}
@stop


@section('content')

    <!-- Page Header -->
    @include('superadmin::layouts.includes.breadcrumb', ['title' => $title])
    <!-- /Page Header -->


    <div class="edit-profile">
        <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="row">
            <div class="col-xl-4">
                @component('superadmin::layouts.includes.card', ['title' =>  __('lang.profile') ])
                    @slot('content')
                    <div class="row mb-2">
                        <div  class="text-center">
                            <img width="150" height="150" class=" w3-border rounded-circle image-preview position-relative" alt="" src="{{ asset($resource->image??'icons/admin.png') }}">
                            <label for="fileid" class="position-absolute " style="right: 43.3%;top: 51%;background: gray;padding: 1px 13px;border-radius: 4px 4px 26% 26%;">
                                <i class="ti ti-cloud-upload h3 text-white"></i>
                            </label>
                            <input type="file" id="fileid" style="display: none" class="image form-control" name="image">

                        </div>
                        <div class="profile-title text-center mb-3">
                        <div class=" text-center">
                            <div class="media-body text-center">
                            <b class="mb-1 h3">{{ $resource->username }}</b>
                            {{-- <p>DESIGNER</p> --}}
                            </div>
                        </div>
                        </div>
                        <div class="mb-3">
                            <b class="form-label">{{ __('lang.email') }} :</b>
                            <span>{{ $resource->email }}</span>
                        </div>
                        <div class="mb-3">
                            <b class="form-label">{{ __('lang.phone') }} :</b>
                            <span>{{ $resource->phone }}</span>
                        </div>
                    </div>
                    @endslot
                @endcomponent

            </div>
            <div class="col-xl-8">
                @component('superadmin::layouts.includes.card', ['title' =>  __('lang.update_profile') ])
                    @slot('content')
                    <div class="row">

                        <div class="col-sm-12 col-md-6 ">
                        <div class="mb-3">
                            <label class="form-label">{{ __('lang.username') }}</label>
                            <input class="form-control" type="text" name="username" value="{{ $resource->username }}" placeholder="Username">
                        </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('lang.email') }}</label>
                            <input class="form-control" name="email" value="{{ $resource->email }}" type="email" placeholder="Email">
                        </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('lang.phone') }}</label>
                            <input class="form-control" name="phone" value="{{ $resource->phone }}" type="number" step="any" placeholder="0123456789">
                        </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('lang.password') }}</label>
                                <input class="form-control" name="password" type="password"  autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-sm-12 ">
                            <div class="mb-3">
                               <button class="btn btn-primary btn-block" type="submit">{{ __('lang.update_profile') }}</button>
                            </div>
                        </div>


                    </div>
                    @endslot
                @endcomponent

            </div>

            </div>
        </form>
      </div>

@stop
