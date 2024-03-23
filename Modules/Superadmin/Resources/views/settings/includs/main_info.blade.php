<div class="row">
    @foreach (config('translatable.locales') as $key => $locale)
        <div class="col-md-6 pt-3">
            <div class="form-group">
                <label for="name">
                    {{ __('lang.site_name_'.$locale) }}
                </label>
                {!! Form::text("site_name_".$locale, old("site_name_{$locale}", optional($settings->where('key','site_name_'.$locale)->first())->value), ['class' => 'form-control']) !!}
            </div>
        </div>
    @endforeach
    @foreach (config('translatable.locales') as $key => $locale)
        <div class="col-md-6 pt-3">
            <div class="form-group">
                <label for="name">
                    {{ __('lang.address_'.$locale) }}
                </label>
                {!! Form::text("address_".$locale, old("address_{$locale}", optional($settings->where('key','address_'.$locale)->first())->value), ['class' => 'form-control']) !!}
            </div>
        </div>
    @endforeach
    @foreach (config('translatable.locales') as $key => $locale)
        <div class="col-md-6 pt-3">
            <div class="form-group">
                <label for="name">
                    {{ __('lang.short_description_'.$locale) }}
                </label>
                {!! Form::textarea("short_description_".$locale, old("short_description_{$locale}", optional($settings->where('key','short_description_'.$locale)->first())->value), ['class' => 'form-control ']) !!}
            </div>
        </div>
    @endforeach


    {{-- <div class="col-md-12 pt-3">
        <div class="form-group">
            <label
                for="google_analytics">{{ __('lang.google_analytics') }}</label>
                {!! Form::textarea('google_analytics', old('google_analytics', optional($settings->where('key','google_analytics')->first())->value ),  ['class' => 'form-control ']) !!}


        </div>
    </div> --}}
    <div class="col-md-3 pt-3">
        <div class="form-group">
           <label for="logo">{{ __('lang.logo') }}</label>
            <div style="width: 100%;border: 1px dashed #ccc; padding: 10px">
                <img class=" image-preview-logo" width="100%"  src="{{ asset(optional($settings->where('key','logo')->first())->value ?? 'assets/img/default.jpg' ) }}">
            </div>
        <br>
        <label for="logo"class="btn btn-primary text-white mt-2">
            <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
        </label>

        <input type="file" onchange="changeImage(this, 'logo')" id="logo" class="d-none form-control mt-3" name="logo" >


        </div>

    </div>
    <div class="col-md-3 pt-3">
        <div class="form-group">
           <label for="logo_white">{{ __('lang.logo_white') }}</label>
            <div style="width: 100%;border: 1px dashed #ccc; padding: 10px">
                <img class=" image-preview-logo_white" width="100%"  src="{{ asset(optional($settings->where('key','logo_white')->first())->value ?? 'assets/img/default.jpg' ) }}">
            </div>
        <br>
        <label for="logo_white"class="btn btn-primary text-white mt-2">
            <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
        </label>

        <input type="file" onchange="changeImage(this, 'logo_white')" id="logo_white" class="d-none form-control mt-3" name="logo_white" >
        </div>

    </div>
    <div class="col-md-3 pt-3">
        <div class="form-group">
           <label for="fav_icon">{{ __('lang.fav_icon') }}</label>
            <div style="width: 100%;border: 1px dashed #ccc; padding: 10px">
                <img class=" image-preview-favicon" width="100%"  src="{{ asset(optional($settings->where('key','favicon')->first())->value ?? 'assets/img/default.jpg' ) }}">
            </div>
        <br>
        <label for="favicon"class="btn btn-primary text-white mt-2">
            <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
        </label>

        <input type="file" onchange="changeImage(this, 'favicon')" id="favicon" class="d-none form-control mt-3" name="favicon" >
        </div>

    </div>


    {{-- <div class="col-md-3 pt-3">
        <div class="form-group">
           <label for="main_color">{{ __('lang.main_color') }}</label>
           <input type="color" id="main_color" name="main_color" value="{{ optional($settings->where('key','main_color')->first())->value ?? '#ff0000' }}" class="form-control">
           <br><label for="sec_color">{{ __('lang.sec_color') }}</label>
           <input type="color" id="sec_color" name="sec_color" value="{{ optional($settings->where('key','sec_color')->first())->value ?? '#ff0000' }}" class="form-control">
        </div>
    </div>

    <div class="col-md-3 pt-3">
        <div class="form-group">
           <label for="login_image">{{ __('lang.login_image') }}</label>
            <div style="width: 100%;border: 1px dashed #ccc; padding: 10px">
                <img class=" image-preview-login_image" width="100%"  src="{{ asset(optional($settings->where('key','login_image')->first())->value ?? 'assets/img/default.jpg' ) }}">
            </div>
        <br>
        <label for="login_image"class="btn btn-primary text-white mt-2">
            <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
        </label>

        <input type="file" onchange="changeImage(this, 'login_image')" id="login_image" class="d-none form-control mt-3" name="login_image" >
        </div>

    </div> --}}
</div>
