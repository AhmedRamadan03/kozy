@php
    $title = $resource->id ?  __('lang.edit') .' ' . __('lang.student')   : __('lang.add') .' ' . __('lang.student');
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

        <form class="form" action="{{ $resource->id?route('admin.board.update',$resource->id):route('admin.board.store') }}" method="post" enctype="multipart/form-data">
            @csrf

           <div class="container">

            {{-- admin info --}}
            <div class="row mb-5">
                <div class="col-lg-12  pt-3 text-center">

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
                <div class="col-lg-12  pt-3 text-center">
                    <label for="name" class="form-label">{{ __('lang.student') }}</label>
                    {!! Form::text('name', old('name', $resource->name), ['class' => 'form-control']) !!}
                </div>
                {{-- <div class="col-lg-12  pt-3 text-center">
                    <label for="user_id" class="form-label">{{ __('lang.student') }}</label>
                    {!! Form::select('user_id', $users, old('user_id', $resource->user_id), ['class' => 'form-select select2', 'placeholder' => __('lang.choose') . ' ' . __('lang.student')]) !!}
                </div> --}}
            </div>


           </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
        </form>

      </div>

    </div>
  </div>
