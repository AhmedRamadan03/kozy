<div class="card-item">
    <div class="item-header d-flex justify-content-between w3-border-bottom align-items-center">
        <b class="title main-color fs-4">{{ Str::limit($item->fullname, 25) }}</b>
            <div class="link d-flex justify-content-between align-items-center">
                <a class="form-check form-switch d-flex m-1 justify-content-between text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('lang.change_status') }}" >
                        <input class="form-check-input"   type="checkbox" role="switch" id="flexSwitchCheckChecked-{{ $item->id }}" onclick="changeStatus(this,{{ $item->id }})" {{ $item->is_active == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexSwitchCheckChecked-{{ $item->id }}"></label>
                </a>
                <a href="{{ route('admin.lecture.show',$item->id) }}" class="m-1  "><i class="h3 text-info ti ti-eye"></i></a>
                @if (request()->routeIs('admin.lecture.trashList'))
                <a href="{{ route('admin.lecture.restore',$item->id) }}" class="m-1  sw-alert " data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('lang.restore') }}"><i class="h3 text-info ti ti-login"></i></a>
                <a href="{{ route('admin.lecture.delete',$item->id) }}" class="m-1  sw-alert " data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('lang.delete') }}"><i class="h3 text-danger ti ti-trash"></i></a>

                @else
                <a href="{{ route('admin.lecture.edit',$item->id) }}" class="m-1  " data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('lang.edit') }}"><i class="h3 text-info ti ti-pencil"></i></a>
                <a href="{{ route('admin.lecture.destroy',$item->id) }}" class="m-1  sw-alert " data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('lang.delete') }}"><i class="h3 text-danger ti ti-trash"></i></a>

                @endif
            </div>
    </div>

    <div class="item-body text-center">
            <div class=" student-image-card w3-border-bottom m-auto" style="background-image: url({{ asset($item->image ?? 'assets/img/default.jpg') }});">
                {{-- <span class="label bg-lable border-8 p-2 w3-text-white position-relative" style="top: 5px">{{ $item->code }}</span> --}}
            </div>
            <b class="title main-color fs-4">
                <a href="tel:{{ $item->father->phone }}">{{ Str::limit($item->father->fullname, 25) }} -( {{ $item->father->phone }} )</a>
            </b>
            <div class="details pt-2 d-flex justify-content-between">
                {{-- <span class="label bg-light-secondary p-2 border-8 fs-3">{{ $item->lectures()->count() }} {{ __('lang.lectures') }}</span> --}}
                <span class="label w3-light-gray p-2 border-8 fs-3">{{ optional($item->level)->title }} </span>
                <span class="label w3-light-blue w3-text-white p-2 border-8 fs-3  ">{{ optional($item->city)->title }} </span>
            </div>
    </div>

</div>
