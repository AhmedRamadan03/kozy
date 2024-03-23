@extends('website::layouts.master')

@section('title')
    {{ __('front.sign_up') }}
@endsection

@section('content')
    <div class="container pt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6  ">
                <div class="card shadow p-3 border-0">
                    <div class="">
                        <b class="fs-3 text-dark">{{ __('front.sign_up') }}</b>
                        <p class="text-muted pt-2">
                            {{ __('front.enter_the_required_details') }}
                        </p>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <b class="fs-5 text-dark">{{ __('front.personal_information') }}</b>
                                <div class="col-md-12 pt-2">
                                    <input required id="name" type="text" placeholder="{{ __('front.name') }}"
                                           class="form-control p-3 bg-white @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 pt-3">
                                    <select name="country_id" required id="country_id" class="form-control select2 form-select p-3 bg-white @error('country_id') is-invalid @enderror">
                                        <option value="">{{ __('front.select_country') }}</option>
                                        @foreach($countries as $country)
                                            <option {{ old('country_id') == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->title }}</option>
                                        @endforeach

                                    </select>
                                    @error('country_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                            </div>
                            <div class="form-group row pt-3">
                                <b class="fs-5 text-dark">{{ __('front.contact_info') }}</b>
                                <div class="col-md-12 pt-2">
                                    <input required id="email" type="email" placeholder="{{ __('front.email') }}"
                                           class="form-control p-3 bg-white @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 pt-3">

                                            <div class=" ">
                                                <input required id="phone" type="number" placeholder="{{ __('front.phone') }}"
                                                       class="form-control p-3 bg-white @error('phone') is-invalid @enderror" name="phone"
                                                       value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>


                                </div>



                            </div>

                            <div class="form-group pt-4 row">
                                <b class="fs-5 text-dark">{{ __('front.security') }}</b>
                                <div class="col-md-12">
                                    <input required id="password" type="password" placeholder="{{ __('front.password') }}"
                                           class="form-control p-3 @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 pt-3">
                                    <input required id="password-confirm" type="password" placeholder="{{ __('front.confirm_password') }}"
                                           class="form-control p-3" name="password_confirmation" required
                                           autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row mb-0 pt-4">
                                <div class="">
                                    <button type="submit" class="btn btn--custom w3-block">
                                        {{ __('front.sign_up') }}
                                    </button>


                                </div>
                            </div>
                        </form>

                        <div class="row pt-5">
                            <div class="col-12 text-center">
                                {{ __('front.have_account') }}
                                <a href=" {{ route('login') }}" class="main-color">
                                    {{ __('front.login') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection
