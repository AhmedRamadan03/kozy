@php
    $title = $resource->subject;
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


            <div class="modal-body">
                <div class="row">


                    <div class="col-md-12 pt-2">
                        <div class="item border-dash w3-round-large p-3">
                            <b>{{ __('lang.end_date') }} :  {{ $resource->end_date }}</b>
                        </div>
                    </div>
                    <div class="col-md-12 pt-2">
                        <div class="item border-dash w3-round-large p-3">
                            <b>{{ __('lang.task') }} :  {{ $resource->task }}</b>
                        </div>
                    </div>
                    <div class="col-md-12 pt-2">
                        <div class="item border-dash w3-round-large p-3">
                            <b>{{ __('lang.status') }} </b>
                            @if ($resource->status == 'complet')
                                <span class="badge bg-success"> {{ __('lang.'. $resource->status) }}</span>
                            @else
                           <form action="{{ route('admin.todo.change-status') }}" method="post" id="form-status">
                            @csrf
                            <input type="hidden" name="id" value="{{ $resource->id }}">
                            <select name="status" id="status" onchange="$('#form-status').submit()" class="form-control select2">
                                @foreach ($status as $key =>$st)
                                    <option {{ $resource->status == $st ?'selected':'' }} value="{{ $st }}"> {{ __('lang.'.$st) }}</option>
                                @endforeach
                            </select>
                           </form>
                            @endif
                        </div>
                    </div>



                </div>
            </div>


      </div>

    </div>
  </div>
  <script>
    $('.select2').select2({
        dropdownParent: $('#table-model')
    });

</script>
