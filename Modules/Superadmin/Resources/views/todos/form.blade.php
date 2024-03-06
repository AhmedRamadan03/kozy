@php
    $title = $resource->id ? __('lang.edit') . ' ' . __('lang.todo') : __('lang.add') . ' ' . __('lang.todo');
@endphp

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
        <div class="modal-header">
            <h5 class="modal-title">
                {{ $title }}
            </h5>
            <button type="button" class="btn-close {{ isRtl() ? 'ms-1' : '' }}" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form class="form"
                action="{{ $resource->id ? route('admin.todo.update', $resource->id) : route('admin.todo.store') }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12 pt-2">
                            <div class="form-group">
                                <label class="form-lable" for="subject">
                                    {{ __('lang.subject') }}
                                </label>
                                {!! Form::text('subject', old('subject', $resource->subject), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-12 pt-2">
                            <div class="form-group">
                                <label class="form-lable" for="end_date">
                                    {{ __('lang.end_date') }}
                                </label>
                                {!! Form::date('end_date', old('end_date', $resource->end_date), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        @if ($resource->id)
                            <div class="col-md-12 pt-2">
                                <div class="form-group">
                                    <label class="form-lable" for="user_id"></label>
                                    <select name="status" id="status"
                                        class="form-control select2">
                                        @foreach ($status as $key => $st)
                                            <option {{ $resource->status == $st ? 'selected' : '' }}
                                                value="{{ $st }}"> {{ __('lang.' . $st) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-12 pt-2">
                            <div class="form-group">
                                <label class="form-lable" for="user_id"></label>
                                {!! Form::select('user_id', $members, old('user_id', $resource->user_id), [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.select') . ' ' . __('lang.user'),
                                ]) !!}
                            </div>
                        </div>


                        <div class="col-md-12 pt-2">
                            <div class="form-group">
                                <label for="task" class="form-lable"> {{ __('lang.todo') }}</label>
                                {!! Form::textarea('task', old('task', $resource->task), ['class' => 'form-control', 'rows' => '4']) !!}
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
<script>
    $('.select2').select2({
        dropdownParent: $('#table-model')
    });
</script>
