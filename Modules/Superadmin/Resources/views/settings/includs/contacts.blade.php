<div class="row">
    <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('phone', __('lang.phone'), ['class' => 'form-label']) !!}
            {!! Form::number('phone', old('phone' , optional($settings->where('key','phone')->first())->value), ['class' => 'form-control','setp'=>'any']) !!}
        </div>

    </div>
    <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('whatsapp', __('lang.whatsapp'), ['class' => 'form-label']) !!}
            {!! Form::number('whatsapp', old('whatsapp' , optional($settings->where('key','whatsapp')->first())->value), ['class' => 'form-control','setp'=>'any']) !!}
        </div>
    </div>
    <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('email_1', __('lang.email'). ' 1', ['class' => 'form-label']) !!}
            {!! Form::email('email_1', old('email_1' , optional($settings->where('key','email_1')->first())->value), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('email_2', __('lang.email') .' 2', ['class' => 'form-label']) !!}
            {!! Form::email('email_2', old('email_2' , optional($settings->where('key','email_2')->first())->value), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('instagram', __('lang.instagram'), ['class' => 'form-label']) !!}
            {!! Form::url('instagram', old('instagram' , optional($settings->where('key','instagram')->first())->value), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('linkedin', __('lang.linkedin'), ['class' => 'form-label']) !!}
            {!! Form::url('linkedin', old('linkedin' , optional($settings->where('key','linkedin')->first())->value), ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('facebook', __('lang.facebook'), ['class' => 'form-label']) !!}
            {!! Form::url('facebook', old('facebook' ,optional($settings->where('key','facebook')->first())->value), ['class' => 'form-control']) !!}
        </div>
    </div>
    {{-- <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('youtube_link', __('lang.youtube_link'), ['class' => 'form-label']) !!}
            {!! Form::url('youtube_link', old('youtube_link' ,optional($settings->where('key','youtube_link')->first())->value), ['class' => 'form-control']) !!}
        </div>
    </div> --}}

    <hr>
    @foreach (config('translatable.locales') as $key => $locale)
        <div class="col-md-6 pt-3">
            <div class="form-group">
                <label for="name">
                    {{ __('lang.contact_us_title1_'.$locale) }}
                </label>
                {!! Form::text("contact_us_title1_".$locale, old("contact_us_title1_{$locale}", optional($settings->where('key','contact_us_title1_'.$locale)->first())->value), ['class' => 'form-control']) !!}
            </div>
        </div>
    @endforeach
    @foreach (config('translatable.locales') as $key => $locale)
        <div class="col-md-6 pt-3">
            <div class="form-group">
                <label for="name">
                    {{ __('lang.contact_us_description1_'.$locale) }}
                </label>
                {!! Form::textarea("contact_us_description1_".$locale, old("contact_us_description1_{$locale}", optional($settings->where('key','contact_us_description1_'.$locale)->first())->value), ['class' => 'form-control']) !!}
            </div>
        </div>
    @endforeach
    <hr>
    @foreach (config('translatable.locales') as $key => $locale)
        <div class="col-md-6 pt-3">
            <div class="form-group">
                <label for="name">
                    {{ __('lang.contact_us_title2_'.$locale) }}
                </label>
                {!! Form::text("contact_us_title2_".$locale, old("contact_us_title2_{$locale}", optional($settings->where('key','contact_us_title2_'.$locale)->first())->value), ['class' => 'form-control']) !!}
            </div>
        </div>
    @endforeach
    @foreach (config('translatable.locales') as $key => $locale)
        <div class="col-md-6 pt-3">
            <div class="form-group">
                <label for="name">
                    {{ __('lang.contact_us_description2_'.$locale) }}
                </label>
                {!! Form::textarea("contact_us_description2_".$locale, old("contact_us_description2_{$locale}", optional($settings->where('key','contact_us_description2_'.$locale)->first())->value), ['class' => 'form-control']) !!}
            </div>
        </div>
    @endforeach
</div>
