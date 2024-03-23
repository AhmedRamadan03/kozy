@php
    $title = $resource->id ?  __('lang.edit') .' ' . __('lang.color')   : __('lang.add') .' ' . __('lang.color');
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

        <form class="form" action="{{ $resource->id?route('admin.color.update',$resource->id):route('admin.color.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('name', __('lang.name')) !!}
                        {!! Form::text('name', $resource->name, ['class' => 'form-control', 'placeholder' => __('lang.name')]) !!}

                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('value', __('lang.value')) !!}
                        {!! Form::color('value', $resource->value, ['class' => 'form-control', 'placeholder' => __('lang.value')]) !!}
                    </div>
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
