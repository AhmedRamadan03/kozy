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
            {!! Form::label('facebook_link', __('lang.facebook_link'), ['class' => 'form-label']) !!}
            {!! Form::url('facebook_link', old('facebook_link' , optional($settings->where('key','facebook_link')->first())->value), ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('youtube_link', __('lang.youtube_link'), ['class' => 'form-label']) !!}
            {!! Form::url('youtube_link', old('youtube_link' ,optional($settings->where('key','youtube_link')->first())->value), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
