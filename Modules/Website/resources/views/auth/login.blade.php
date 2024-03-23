@extends('website::layouts.master')

@section('title')
    {{ __('front.login') }}
@endsection

@section('content')
    <div class="container pt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6  ">
                <div class="card shadow p-3 border-0">
                    <div class="">
                        <b class="fs-3 text-dark">{{ __('front.login') }}</b>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">

                                <div class="col-md-12">
                                    <input id="email" type="email" placeholder="{{ __('front.email') }}"
                                           class="form-control p-3 bg-white @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group pt-5 row">

                                <div class="col-md-12">
                                    <input id="password" type="password"
                                           class="form-control p-3 @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <div class="">
                                    <div class="form-check d-flex gap-2 align-items-end">
                                        <input class="form-check-input w3-check" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label text-dark" for="remember">
                                            {{ __('front.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="form-group row mb-0 pt-4">
                                <div class="">
                                    <button type="submit" class="btn btn--custom w3-block">
                                        {{ __('front.login') }}
                                    </button>


                                </div>
                            </div>
                        </form>

                        <div class="row pt-5">
                            <div class="col-12 text-center">
                                {{ __('front.dont_have_account') }}
                                <a href="{{ route('register') }}" class="main-color">
                                    {{ __('front.register') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection
