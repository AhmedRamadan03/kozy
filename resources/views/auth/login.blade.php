@extends('website.layouts.master')

{{-- @section('content')

    <div class="row pt-5 mb-5">
        <div class="col-md-6 p-5">
            <div class="card border-0">
                <div class="card-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">{{ __('lang.email') }}</label>
                            <input type="email" autocomplete="new-mail" placeholder="ex@gmail.com" name="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-4">
                            <label for="exampleInputPassword1" class="form-label">{{ __('lang.password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"  name="password" placeholder="********" id="exampleInputPassword1" autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">{{ __('lang.login') }}</button>
                        <b>{{ __('lang.dont_have_account') }} </b>
                        <a href="{{ route('register') }}" class="text-center">
                             <b class="text-primary">{{ __('lang.create_account') }}</b>
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">

        </div>
    </div>
@endsection --}}
@section('css')
    <style>



        .link-border{
           border-bottom: 1px solid var(--sec-color);
           padding: 10px
        }
        .active-link{
            border-bottom: 1px solid var(--primary);
            background: #ddd;
            color: var(--primary);
            padding: 10px;
            font-weight: 700
        }
        .hide{
            display: none;
            transition: all .8s;
        }
    </style>
@endsection

@section('content')
    <section class="inner-section user-form-part bg-color-section">
        <div class="">
            <div class="row justify-content-center">

                <div class="col-12 col-md-5 pt-5">
                    <br><br>
                    <img src="{{ asset(optional($settings->where('key','login_image')->first())->value) }}" style="width: 100% ; height: 600px;" alt="">
                </div>

                <div class="col-12 col-md-7 p-lg-5 p-sm-2">
                    <br><br>
                    <div class="user-form-card p-5 pt-5" id="div-login">
                        <div class="user-form-title">
                            <h2 class="text-primary">{{ __('lang.welcome_you') }}</h2>
                            <p>{{ __('lang.login_to_your_account') }}</p>
                        </div>



                        <div class="links">
                            <div class="row text-center">
                                <div class="col-6 p-2">
                                     <a id="login" class="w3-block pe-4 ps-4 text-decoration-none link-border active-link " >{{ __(('lang.sign_in')) }}</a>
                                </div>
                                <div class="col-6 p-2">
                                    <a id="btn-register"  class="w3-block pe-4 ps-4 text-decoration-none link-border ">{{ __(('lang.register')) }}</a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="user-form-group">
                            <form method="POST" action="{{ route('login') }}" class="user-form" id="formTag">
                                @csrf
                                <div class="form-group pt-2">
                                    <input type="text" required  class="form-control {{ $errors->has('email') || $errors->has('phone') ? ' is-invalid' : '' }}" name="email" placeholder="{{ __('lang.email') }} {{ __('lang.or') }} {{ __('lang.phone') }}" value="{{ old('phone') }}" />
                                </div>
                                    <br>
                                <div class="form-group pt-2">
                                    <input required type="password" class="form-control @error('password') is-invalid @enderror"  name="password" placeholder="{{ trans('lang.password') }}" />
                                </div>

                                <div class="form-check mb-3 d-flex gap-4">
                                    <input class="form-check-input w3-check" type="checkbox" value="1" id="check" name="remember" {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label pt-2 me-2 ms-2" for="check"><b>{{ __('lang.remember') }}</b></label>

                                </div>
                                {{-- <br> --}}
                                <p><a href="{{ route('password.request') }}">{{ __('lang.forget_password') }}</a></p>
                                <div class="form-button">
                                    <button id="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" type="submit">{{ __('lang.login') }}</button>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="user-form-card hide  p-5 pt-5" id="div-register">
                        <div class="user-form-title">
                            <h2 class="text-primary">{{ __('lang.join_now') }}</h2>
                            <p>{{ __('lang.create_new_account_with_us') }}</p>
                        </div>
                        <div class="links">
                            <div class="row text-center">
                                <div class="col-6 p-2">
                                     <a id="login"  class="w3-block pe-4 ps-4 text-decoration-none link-border " >{{ __(('lang.sign_in')) }}</a>
                                </div>
                                <div class="col-6 p-2">
                                    <a id="register"  class="w3-block pe-4 ps-4 text-decoration-none link-border ">{{ __(('lang.register')) }}</a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="user-form-group">
                            <form method="post" action="{{ route('register') }}" class="user-form" id="formTag">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group pt-3">
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" required autocomplete="off" name="first_name" value="{{ old('first_name') }}" placeholder="{{ __('lang.first_name') }} *" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pt-3">
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" required autocomplete="off" name="last_name" value="{{ old('last_name') }}" placeholder="{{ __('lang.last_name') }} *" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group pt-3">
                                            <input required type="number" step="any" class="form-control phoneCountry @error('phone') is-invalid @enderror" autocomplete="off" name="phone" value="{{ old('phone') }}" placeholder="  {{ __('lang.phone') . ' *' }} " style="text-align: {{app()->getLocale() == 'ar' ? 'right' : 'left'}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pt-3">
                                            <input required type="number" step="any" class="form-control phoneCountry @error('father_phone') is-invalid @enderror" autocomplete="off" name="father_phone" value="{{ old('father_phone') }}" placeholder="  {{ __('lang.father_phone') . ' *' }} " style="text-align: {{app()->getLocale() == 'ar' ? 'right' : 'left'}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pt-3">
                                            <input required type="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" name="email" value="{{ old('email') }}" placeholder="{{ __('lang.email') }} *" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pt-3">
                                            {!! Form::select('city_id', $cities, null, ['class' => 'form-control select2', 'required', 'id' => 'cite_id','placeholder' => __('lang.choose') . ' '. __('lang.city')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pt-3">
                                            {!! Form::select('level_id', $levels, null, ['class' => 'form-control select2', 'required', 'id' => 'level_id','placeholder' => __('lang.choose') . ' '. __('lang.level')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pt-3">
                                            {!! Form::select('group_id', [], null, ['class' => 'form-control select2', 'required', 'id' => 'group_id','placeholder' => __('lang.choose') . ' '. __('lang.group')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pt-3">
                                            <input required type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder=" {{ __('lang.password') }} *" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pt-3">
                                            <input required type="password" class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password" name="password_confirmation" placeholder=" {{ __('lang.password_confirmation') }} *" />
                                        </div>
                                    </div>
                                </div>



                                <div class="form-button pt-5">
                                    <button  class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" type="submit">{{ __('lang.register') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('js')

    <script>
         $(document).on('click', '#login', function () {
            $('#div-register').addClass('hide');
            $('#div-login').removeClass('hide');
            $('#login').addClass('active-link');
            $('#register').removeClass('active-link');
        });
        $(document).on('click', '#btn-register', function () {
            $('#div-login').addClass('hide');
            $('#div-register').removeClass('hide');
            $('#register').addClass('active-link');
            $('#login').removeClass('active-link');
        });


        let defaultOption = document.createElement('option');
        defaultOption.innerHTML = "{{ __('lang.choose') }} {{ __('lang.group') }}";
        $('#level_id').on('change', function(){
        $.ajax({
            url: "{{ route('front.student.get-groups') }}",
            type: 'POST',
            dataType: 'json',
            data:{
                level_id : $(this).val(),
                _token: "{{ csrf_token() }}"
            },
            success: function (results) {
                $('#group_id').empty();
                $('#group_id').append(defaultOption);
                $.each(results.groups, function (key, value) {
                    $('#group_id').append('<option value="'+value.id+'">'+value.title+'</option>');
                })
            }
        });
    });
    </script>
@stop
