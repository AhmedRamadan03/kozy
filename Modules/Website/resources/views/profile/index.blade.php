@extends('website::layouts.master')

@section('title')
    {{ __('front.my_profile') }}
@endsection

@section('content')

<section class="mt-5 mb-5">

    <div class="container">
       <div class="row">
        <div class="col-md-3">
            @include('website::profile.includes.nav')
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <b class="fs-3 main-color">{{ __('front.my_profile') }}</b>
                    <form action="{{ route('front.profile.update-profile') }}" enctype="multipart/form-data" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">{{ __("front.image") }}</label>
                                    @if (auth()->user()->image)
                                        <img src="{{ asset(auth()->user()->image) }}" width="100" alt="">
                                    @endif
                                    <input type="file" name="image" id="image" class="form-control p-3">
                                </div>
                            </div>
                            <div class="col-md-6  pt-3">
                                <div class="form-group">
                                    <label for="">{{ __("front.name") }}</label>
                                    <input type="text" name="name" id="name" class="form-control p-3"
                                        placeholder="{{ __("front.name") }}" value="{{ auth()->user()->name }}">
                                </div>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-6  pt-3">
                                <div class="form-group">
                                    <label for="">{{ __("front.email") }}</label>
                                    <input type="email" name="email" id="email" class="form-control p-3"
                                        placeholder="{{ __("front.email") }}" value="{{ auth()->user()->email }}">
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6  pt-3">
                                <div class="form-group">
                                    <label for="">{{ __("front.phone") }}</label>
                                    <input type="number" step="any" name="phone" id="phone" class="form-control p-3"
                                        placeholder="{{ __("front.phone") }}" value="{{ auth()->user()->phone }}">
                                </div>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="col-md-6 pt-3">
                                <label for="">{{ __('front.country') }}</label>
                                <select name="country_id" required id="country_id" class="form-control select2 form-select p-3 bg-white @error('country_id') is-invalid @enderror">
                                    <option value="">{{ __('front.select_country') }}</option>
                                    @foreach($countries as $country)
                                        <option {{ auth()->user()->country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->title }}</option>
                                    @endforeach

                                </select>
                                @error('country_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>







                            <div class="col-md-12 pt-3 text-center">
                                <button type="submit" class="btn btn--custom">{{ __('front.update_profile') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <br><br>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title main-color">{{ __('front.change_password') }}</h5>

                    <form action="{{ route('front.profile.change-password') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 pt-3">
                                <div class="form-group">
                                    <label for="">{{ __('front.current_password') }}</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control p-3"
                                        placeholder="{{ __('front.current_password') }}">
                                </div>
                                @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 pt-3">
                                <div class="form-group">
                                    <label for="">{{ __('front.new_password') }}</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control p-3"
                                        placeholder="{{ __('front.new_password') }}">
                                </div>
                                @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 pt-3">
                                <div class="form-group">
                                    <label for="">{{ __('front.confirm_password') }}</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control p-3"
                                        placeholder="{{ __('front.confirm_password') }}">
                                </div>
                                @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 pt-3 text-center">
                                <button type="submit" class="btn btn--custom">{{ __('front.update_password') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       </div>
    </div>
</section>

@endsection
