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
