<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{ __('lang.notes_for_order') }}
                {{ $data->ref . ' - ' . $data->name }}
            </h5>
            <button type="button" class="btn-close {{ isRtl() ? 'ms-1' : '' }}" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>
        <form action="{{ route('admin.order.saveAdminNotes') }}" method="post">
        @csrf

        <div class="modal-body">
            <input type="hidden" name="id" value="{{ $data->id }}">
            <textarea name="notes" id="description_ar" class="form-control tinymce_ar" placeholder="{{ __('lang.notes') }}"
                cols="30" rows="10">{{  $data->admin_notes }}</textarea>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
        </div>
    </form>
    </div>
</div>
<script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/js/tinymce/tiny-init.js') }}"></script>

