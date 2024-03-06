<div class="row">
    <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('course_prefix', __('lang.course_prefix'), ['class' => 'form-label']) !!}
            {!! Form::text('course_prefix', old('course_prefix' , optional($settings->where('key','course_prefix')->first())->value), ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 pt-3">
        <div class="form-group">
            {!! Form::label('lecture_prefix', __('lang.lecture_prefix'), ['class' => 'form-label']) !!}
            {!! Form::text('lecture_prefix', old('lecture_prefix' ,optional($settings->where('key','lecture_prefix')->first())->value), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
