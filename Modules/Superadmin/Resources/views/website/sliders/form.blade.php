@php
    $title = $resource->id ?  __('lang.edit') .' ' . __('lang.slider')   : __('lang.add') .' ' . __('lang.slider');
@endphp

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">
          {{ $title }}
        </h5>
        <button type="button" class="btn-close {{ isRtl() ? 'ms-1' : '' }}" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form class="form" action="{{ $resource->id?route('admin.slider.update',$resource->id):route('admin.slider.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    @if(auth()->user()->show_all == 1)
                    <div class="col-md-12 pt-4">
                        <div class="form-group">
                            {!! Form::label('country_id', __('lang.choose') . ' ' .__('lang.country'), ['class' => 'form-label']) !!} <span  class="text-danger">: * </span>
                            {!! Form::select('country_id', $countries, old('country_id', $resource->country_id), ['class' => 'form-control form-select select2' , 'required' , 'id' => 'country_id' , 'placeholder' => __('lang.choose') . ' ' .__('lang.country')]) !!}
                        </div>
                    </div>
                @else
                    <input type="hidden" name="country_id" value="{{auth()->user()->country_id}}" >
                @endif
                    <div class="col-12  pt-3 text-center">

                        {!! Form::label('image', __('lang.image') , ['class' => 'form-label'] ) !!} <br>
                        <img class=" image-preview-image  " width="100%" height="200"   src="{{ asset($resource->image ?? 'assets/img/default.jpg' ) }}">
                        <br>
                        <label for="image"class="btn btn-primary text-white mt-2">
                            <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
                        </label>

                        <input type="file"  onchange="changeImage(this, 'image')" id="image" class="d-none form-control mt-3" name="image" >
                    </div>

                </div>
            </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
        </form>

      </div>

    </div>
  </div>
