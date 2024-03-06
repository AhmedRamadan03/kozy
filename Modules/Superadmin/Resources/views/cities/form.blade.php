@php
    $title = $resource->id ?  __('lang.edit') .' ' . __('lang.city')   : __('lang.add') .' ' . __('lang.city');
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

        <form class="form" action="{{ $resource->id?route('admin.city.update',$resource->id):route('admin.city.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 pt-4">
                        <div class="form-group">
                            {!! Form::label('country_id', __('lang.choose') . ' ' .__('lang.accademy_years'), ['class' => 'form-label']) !!} <span  class="text-danger">: * </span>
                            {!! Form::select('country_id', $countries, old('country_id', $resource->country_id), ['class' => 'form-control form-select select2' , 'required' , 'id' => 'country_id' , 'placeholder' => __('lang.choose') . ' ' .__('lang.country')]) !!}
                        </div>
                    </div>
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
  <script>
    $('.select2').select2({
        dropdownParent: $('#table-model')
    });

</script>
