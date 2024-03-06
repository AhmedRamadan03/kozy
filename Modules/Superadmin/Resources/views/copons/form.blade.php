@php
    $title = $resource->id ?  __('lang.edit') .' ' . __('lang.copon')   : __('lang.add') .' ' . __('lang.copon');
@endphp

<div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">
          {{ $title }}
        </h5>
        <button type="button" class="btn-close {{ isRtl() ? 'ms-1' : '' }}" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form class="form" action="{{ $resource->id?route('admin.copon.update',$resource->id):route('admin.copon.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 pt-2">
                        <div class="form-group">
                            <label for="code">{{ __('lang.code') }}</label>
                            {!! Form::text("code", old("code", $resource->code), ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="discount_type">{{ __('lang.discount_type') }}</label>
                            {!! Form::select("discount_type", $discount_types, old("discount_type", $resource->discount_type), ['class' => 'form-select select2', 'required', 'placeholder' => __('lang.select') . ' ' . __('lang.discount_type')]) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="discount">{{ __('lang.discount') }}</label>
                            {!! Form::number("discount", old("discount", $resource->discount ?? 0), ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="expired_at">{{ __('lang.expired_at') }}</label>
                            {!! Form::date("expired_at", old("expired_at", $resource->expired_at), ['class' => 'form-control', 'required']) !!}
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
  <script>
    $('.select2').select2({
        dropdownParent: $('#table-modal')
    });
</script>
