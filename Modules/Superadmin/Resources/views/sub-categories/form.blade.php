@php
    $title = $resource->id ?  __('lang.edit') .' ' . __('lang.category')   : __('lang.add') .' ' . __('lang.category');
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

        <form class="form" action="{{ $resource->id?route('admin.subcat.update',$resource->id):route('admin.subcat.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if (isset($mainCategory))

            <input type="hidden" name="parent_id" value="{{ $mainCategory->id }}">
            @endif
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 pt-3 text-center">

                        {!! Form::label('image', __('lang.image') , ['class' => 'form-label'] ) !!} <br>
                            <div class="student_image">
                                <img class=" image-preview-image  "    src="{{ asset($resource->image ?? 'assets/img/default.jpg' ) }}">
                            </div>

                        <br>
                        <label for="image"class="btn btn-primary text-white mt-2">
                            <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
                        </label>

                        <input type="file" onchange="changeImage(this, 'image')" id="image" class="d-none form-control mt-3" name="image" >
                    </div>
                    <div class="col-6 pt-3 text-center">

                        {!! Form::label('icon', __('lang.icon') , ['class' => 'form-label'] ) !!} <br>
                            <div class="student_image">
                                <img class=" image-preview-icon  "    src="{{ asset($resource->icon ?? 'assets/img/default.jpg' ) }}">
                            </div>

                        <br>
                        <label for="icon"class="btn btn-primary text-white mt-2">
                            <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
                        </label>

                        <input type="file" onchange="changeImage(this, 'icon')" id="icon" class="d-none form-control mt-3" name="icon" >
                    </div>
                    <hr>
                    @foreach (config('translatable.locales') as $key => $locale)
                        <div class="col-md-12 pt-2">
                            <div class="form-group">
                                <label for="name">
                                    {{ __('lang.'.$locale.'.title') }}
                                </label>
                                {!! Form::text("{$locale}[title]", old("{$locale}[title]", optional($resource->translate($locale))->title), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
        </form>

      </div>

    </div>
  </div>
