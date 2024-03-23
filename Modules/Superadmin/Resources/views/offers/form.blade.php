@php
    $title = $resource->id ? __('lang.edit') . ' ' . __('lang.offer') : __('lang.add') . ' ' . __('lang.offer');
@endphp

@extends('superadmin::layouts.master')
@section('css')

@endsection
@section('title')
    {{ $title }}
@endsection

@section('content')
{{-- breadcrumb component --}}
    @component('superadmin::layouts.includes.breadcrumb', [
        'title' => $title,
        'pagetitle' => __('lang.categories'),
        'url' => route('admin.offer.index'),
    ])
    @endcomponent
    @component('superadmin::layouts.includes.card', ['title' => $title])
        @slot('content')
            <form class="form"
                action="{{ $resource->id ? route('admin.offer.update', $resource->id) : route('admin.offer.store') }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-{{ auth()->user()->show_all == 1 ? '6' : '12' }}">
                        <label for="product" class="form-label">{{ __('lang.product') }}</label> <br>
                        <select name="product_id" id="product_select" class="form-control product_select {{ $errors->has('product_id') ? 'is-invalid' : '' }}">
                            @if ($resource->id)
                                <option value="{{ $resource->product_id }}">{{  optional($resource->product)->title }}</option>
                            @endif
                        </select>
                        @error('product_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @if(auth()->user()->show_all == 1)
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('country_id', __('lang.choose') . ' ' .__('lang.country'), ['class' => 'form-label']) !!} <span  class="text-danger">: * </span>
                                {!! Form::select('country_id', $countries, old('country_id', $resource->country_id), ['class' => 'form-control form-select select2' , 'required' , 'id' => 'country_id' , 'placeholder' => __('lang.choose') . ' ' .__('lang.country')]) !!}
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="country_id" value="{{auth()->user()->country_id}}" >
                    @endif

                    <div class="col-md-6 pt-3">
                        <label for="start_date" class="form-label">{{ __('lang.start_date') }}</label> <br>
                        <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $resource?->start_date) }}" id="">
                        @error('start_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 pt-3">
                        <label for="end_date" class="form-label">{{ __('lang.end_date') }}</label> <br>
                        <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $resource?->end_date) }}" id="">
                        @error('end_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
                </div>
            </form>
        @endslot
    @endcomponent

@endsection
@section('js')
<script>
     $(document).ready(function() {
    $('#product_select').select2({
           language: {
               searching: function() {
                   return "Something else...";
               }
           },
           ajax: {
               url: "{{ route('admin.offer.searchProduct') }}",
               type: "get",
               dataType: 'json',
               delay: 250,
               data: function(params) {
                   return {
                       _token: '{{ csrf_token() }}',
                       search: params.term // search term
                   };
               },
               processResults: function(response) {
                   return {
                       results: response
                   };
               },
               cache: true
           }
       });
       });
</script>
@endsection
