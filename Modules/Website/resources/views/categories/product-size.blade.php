@foreach ($productSizes as $item)
<input onclick="getValue()" class="btn-check" id="size-{{ $item->size_id }}" type="radio" value="{{  $item->size_id }}" data-size="{{ $item->size->value }}" class="size" name="attr_size_id" id="size-{{ $item->size_id }}" >
<label class="btn btn-outline-danger" for="size-{{ $item->size_id }}">
    {{ ($item->size->value) }}
        {{-- {{ $item->size->name}} --}}
    </label>
@endforeach
