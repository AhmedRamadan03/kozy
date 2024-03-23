@extends('website::layouts.master')
@section('css')
@endsection
@section('title')
    {{ __('front.return_rules') }}
@endsection

@section('content')
    <div class="container pt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                {!! getSettingValue('return_rules_'.app()->getLocale()) !!}
            </div>
        </div>
    </div>
@endsection

