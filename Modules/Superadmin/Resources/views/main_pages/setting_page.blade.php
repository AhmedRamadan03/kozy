@extends('superadmin::layouts.master')

@section('title')
    {{ __('lang.settings') }}
@endsection

@section('content')

    @include('superadmin::layouts.includes.breadcrumb' , ['title' => __('lang.settings')])

    <div class="row pt-3">
        @foreach ($pages as $item)
        @if ($item['show'])
        {{-- {{ dd($item)}} --}}
         <div class="col-md-3">
            @include('superadmin::layouts.includes.card_page', ['item' => $item])
         </div>
     @endif
     @endforeach
    </div>
@endsection

@section('js')

@endsection
