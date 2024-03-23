@php
    $title = $data->id ? __('lang.edit') . ' ' . __('lang.product') : __('lang.add') . ' ' . __('lang.product');
@endphp
@extends('superadmin::layouts.master')
@section('title')
    {{ $title }}
@endsection

@section('content')
@include('superadmin::layouts.includes.breadcrumb' , ['title' => $title])
    @component('superadmin::layouts.includes.card')

        @slot('tool')
        <a href="{{ route('admin.product.index') }}"  class="btn  btn-info float-end mb-2"> <i class="ti ti-arrow-back-up"></i> {{ __('lang.back')  }}</a>

        @endslot
        @slot('content')
            <form action="{{ $data->id ?route('admin.product.update',$data->id):route('admin.product.store')}}"  method="post" enctype="multipart/form-data">
                @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label class="form-label" for="image">{{ __('lang.choose') }} {{ __('lang.image') }}
                            <span class="required">* {{ __('lang.best_size') }} (600 * 600)</span></label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            <div>
                                <span class="btn default btn-file">
                                    <input type="file" name="image" id="image" class="file"
                                        data-initial-preview="@isset($data->image) <img src='{{ asset($data->image ?? null) }}' class='file-preview-image file-preview-image kv-preview-data rotate-1 file-zoom-detail'> @endisset">
                                </span>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 pt-3">
                    <div class="form-group">
                        {!! Form::label('country_id', __('lang.choose') . ' ' .__('lang.country'), ['class' => 'form-label']) !!} <span  class="text-danger">: * </span>
                        {!! Form::select('country_id', $countries, old('country_id', $data->country_id ?? auth()->user()->country_id), ['class' => 'form-control form-select select2' , auth()->user()->show_all == 1? '': 'disabled', 'required' , 'id' => 'country_id' , 'placeholder' => __('lang.choose') . ' ' .__('lang.country')]) !!}
                    </div>
                </div>
                @if (auth()->user()->show_all ==1)
                <div class="col-lg-4 pt-3">
                    <div class="form-group {{ $errors->has('brand_id') ? 'has-error' : '' }}">
                        <label class="form-label" for="category">{{ __('lang.brands') }} <span class="required">*</span></label>
                        <select name="brand_id" id="brand_id" class="form-control select2">
                            @if ($data->brand_id)
                                <option value="{{ $data->brand_id }}">{{ optional($data->brand)->title }}</option>
                            @endif
                        </select>
                        {{-- {!! Form::select('brand_id', $brands, old('brand_id', $data->brand_id ?? null), ['class' => 'form-control select2', 'required', 'id' => 'brand_id', 'placeholder' => __('lang.choose') . ' ' . __('lang.brand')]) !!} --}}

                    </div>
                </div>
                <div class="col-lg-4 pt-3">
                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                        <label class="form-label" for="category">{{ __('lang.categories') }} <span class="required">*</span></label>
                        <select name="category_id" id="category_id" class="form-control select2">
                            @if ($data->category_id)
                                <option value="{{ $data->category_id }}">{{ optional($data->category)->title }}</option>
                            @endif
                        </select>
                        {{-- {!! Form::select('category_id', $categories, old('category_id', $data->category_id ?? null), ['class' => 'form-control select2', 'required', 'id' => 'category_id', 'placeholder' => __('lang.choose') . ' ' . __('lang.category')]) !!} --}}

                    </div>
                </div>
                @else
                <div class="col-lg-4 pt-3">
                    <div class="form-group {{ $errors->has('brand_id') ? 'has-error' : '' }}">
                        <label class="form-label" for="category">{{ __('lang.brands') }} <span class="required">*</span></label>

                        {!! Form::select('brand_id', $brands, old('brand_id', $data->brand_id ?? null), ['class' => 'form-control select2', 'required', 'id' => 'brand_id', 'placeholder' => __('lang.choose') . ' ' . __('lang.brand')]) !!}

                    </div>
                </div>
                <div class="col-lg-4 pt-3">
                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                        <label class="form-label" for="category">{{ __('lang.categories') }} <span class="required">*</span></label>

                        {!! Form::select('category_id', $categories, old('category_id', $data->category_id ?? null), ['class' => 'form-control select2', 'required', 'id' => 'category_id', 'placeholder' => __('lang.choose') . ' ' . __('lang.category')]) !!}

                    </div>
                </div>
                @endif

                <div class="col-lg-4 pt-3 col-md-4 col-sm-6">
                    <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                        <label class="form-label" for="price">{{ __('lang.price') }} <span
                                class="required">*</span></label>
                        <input required type="number" min="1" step="0.01" name="price" id="price"
                            value="{{ old('price', $data->price ?? '1.00') }}"
                            placeholder="{{ __('lang.enter') }} {{ __('lang.price') }}"
                            class="form-control id_number" />
                    </div>
                </div>

                <div class="col-lg-4 pt-3 col-md-4 col-sm-6">
                    <div class="form-group {{ $errors->has('discount') ? 'has-error' : '' }}">
                        <label class="form-label" for="discount">{{ __('lang.discount') }} </label>
                        <input required type="number" min="0" max="{{ old('price', $data->price ?? '1.00') }}"
                            step="0.01" name="discount" id="discount"
                            value="{{ old('discount', $data->discount ?? '0') }}"
                            placeholder="{{ __('lang.enter') }} {{ __('lang.discount') }}"
                            class="form-control id_number" />
                    </div>
                </div>

                <div class="col-lg-4 pt-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="form-label" for="after_discount">{{ __('lang.after_discount') }}</label>
                        <input readonly type="number" step="0.01" id="after_discount"
                            value="{{ number_format(old('price', $data->price ?? '1.00') - old('discount', $data->discount ?? '0'), 2, '.', '') }}"
                            class="form-control" placeholder="{{ __('lang.after_discount') }}" />
                    </div>
                </div>


                <div class="col-lg-4 pt-3 col-md-4 col-sm-6">
                    <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                        <label class="form-label" for="quantity">{{ __('lang.quantity') }} <span
                                class="required">*</span></label>
                        <input required type="number" step="1" name="quantity" id="quantity"
                            value="{{ old('quantity', $data->quantity ?? '1') }}"
                            placeholder="{{ __('lang.enter') }} {{ __('lang.quantity') }}"
                            class="form-control id_number" />
                    </div>
                </div>

                <div class="col-lg-4 pt-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="form-label" for="status">{{ __('lang.status') }} <span class="required">*</span></label>
                        {!! Form::select('hide', ['0' => __('lang.published'), '1' => __('lang.unpublished')], old('hide', $data->hide ?? null), ['class' => 'form-control select2', 'required', 'id' => 'status', 'placeholder' => __('lang.choose') . ' ' . __('lang.status')]) !!}

                    </div>
                </div>
                <div class="col-lg-4 col-md-4 pt-3 col-sm-6">
                    <div class="form-group {{ $errors->has('sku') ? 'has-error' : '' }}">
                        <label class="form-label" for="sku">{{ __('lang.sku') }}</label> <small class="text-danger">{{__('lang.leave_blank')}}</small>
                        <input type="text" name="sku" id="sku"
                            value="{{ old('sku', $data->sku ?? '') }}"
                            placeholder="{{ __('lang.enter') }} {{ __('sku') }}" class="form-control" />
                    </div>
                </div>
                <div class="clear"></div>
                <hr>
                <div class="col-sm-12 pt-3">
                    <label class="form-label" for=""><b>{{ __('lang.product_details') }} :-</b></label>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-12 pt-3">
                                    <div class="form-group {{ $errors->has('ar.title') ? 'has-error' : '' }}">
                                        <label class="form-label" for="title_ar"> أسم المنتج <span class="required">*</span></label>
                                        <input type="text" id="title_ar" name="ar[title]"
                                            value="{{ old('ar.title',  optional($data->translate('ar'))->title ?? null) }}"
                                            class="form-control" placeholder="أدخل أسم المنتج">
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3">
                                    <div class="form-group {{ $errors->has('ar.short_description') ? 'has-error' : '' }}">
                                        <label class="form-label" for="short_description_ar">وصف قصير <span class="required">*</span>
                                            <small><span
                                                    class="remChars">{{ 600 - mb_strlen(old('ar.short_description',  optional($data->translate('ar'))->short_description ?? null)) }}</span>
                                                الأحرف المتبقية</small></label>
                                        <textarea id="short_description_ar" maxlength="600" name="ar[short_description]" class="form-control max_length"
                                            placeholder="أدخل وصف قصير">{{ old('ar.short_description',  optional($data->translate('ar'))->short_description ?? null) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3">
                                    <div class="form-group {{ $errors->has('ar.description') ? 'has-error' : '' }}">
                                        <label class="form-label" for="description_ar"> الوصف </label>
                                        <textarea id="description_ar" name="ar[description]" class="form-control tinymce_ar" placeholder="أدخل الوصف">{{ old('ar.description',  optional($data->translate('ar'))->description ?? null) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3">
                                    <div class="form-group {{ $errors->has('ar.meta_keywords') ? 'has-error' : '' }}">
                                        <label class="form-label" for="meta_keywords_ar">ميتا الكلمات الدلالية <small><span
                                                    class="remChars">{{ 600 - mb_strlen(old('ar.meta_keywords',  optional($data->translate('ar'))->meta_keywords ?? null)) }}</span>
                                                الأحرف المتبقية</small></label>
                                        <textarea id="meta_keywords_ar" maxlength="600" name="ar[meta_keywords]" class="form-control max_length"
                                            placeholder="أدخل ميتا الكلمات الدلالية">{{ old('ar.meta_keywords',  optional($data->translate('ar'))->meta_keywords ?? null) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3">
                                    <div class="form-group {{ $errors->has('ar.meta_description') ? 'has-error' : '' }}">
                                        <label class="form-label" for="meta_description_ar">ميتا الوصف <small><span
                                                    class="remChars">{{ 600 - mb_strlen(old('ar.meta_description',  optional($data->translate('ar'))->meta_description ?? null)) }}</span>
                                                الأحرف المتبقية</small></label>
                                        <textarea id="meta_description_ar" maxlength="600" name="ar[meta_description]" class="form-control max_length"
                                            placeholder="أدخل ميتا الوصف">{{ old('ar.meta_description',  optional($data->translate('ar'))->meta_description ?? null) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-12 pt-3">
                                    <div class="form-group {{ $errors->has('en.title') ? 'has-error' : '' }}">
                                        <label class="form-label" for="title">Title <span class="required">*</span></label>
                                        <input type="text" id="title" name="en[title]"
                                            value="{{ old('en.title',  optional($data->translate('en'))->title ?? null) }}"
                                            class="form-control" placeholder="Enter Product Title">
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3">
                                    <div class="form-group {{ $errors->has('en.short_description') ? 'has-error' : '' }}">
                                        <label class="form-label" for="short_description">Short Description <span class="required">*</span>
                                            <small><span
                                                    class="remChars">{{ 600 - mb_strlen(old('en.short_description',  optional($data->translate('en'))->short_description ?? null)) }}</span>
                                                Characters Remaining</small></label>
                                        <textarea id="short_description" maxlength="600" name="en[short_description]" class="form-control max_length"
                                            placeholder="Enter Small Description">{{ old('en.short_description',  optional($data->translate('en'))->short_description ?? null) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3">
                                    <div class="form-group {{ $errors->has('en.description') ? 'has-error' : '' }}">
                                        <label class="form-label" for="description">Description </label>
                                        <textarea id="description" name="en[description]" class="form-control tinymce" placeholder="Enter Description">{{ old('en.description',  optional($data->translate('en'))->description ?? null) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3">
                                    <div class="form-group {{ $errors->has('en.meta_keywords') ? 'has-error' : '' }}">
                                        <label class="form-label" for="meta_keywords">Meta Keywords <small><span
                                                    class="remChars">{{ 600 - mb_strlen(old('en.meta_keywords',  optional($data->translate('en'))->meta_keywords ?? null)) }}</span>
                                                Characters Remaining</small></label>
                                        <textarea id="meta_keywords" maxlength="600" name="en[meta_keywords]" class="form-control max_length"
                                            placeholder="Enter Meta Keywords">{{ old('en.meta_keywords',  optional($data->translate('en'))->meta_keywords ?? null) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3">
                                    <div class="form-group {{ $errors->has('en.meta_description') ? 'has-error' : '' }}">
                                        <label class="form-label" for="meta_description">Meta Description <small><span
                                                    class="remChars">{{ 600 - mb_strlen(old('en.meta_description',  optional($data->translate('en'))->meta_description ?? null)) }}</span>
                                                Characters Remaining</small></label>
                                        <textarea id="meta_description" maxlength="600" name="en[meta_description]" class="form-control max_length"
                                            placeholder="Enter Meta Description">{{ old('en.meta_description',  optional($data->translate('en'))->meta_description ?? null) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 pt-4">
                    <label class="form-label" for=""><b>{{ __('lang.gallery') }} :</b></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
                                <span>{{ __('lang.best_size') }} (500 * 500)</span>
                            </div>
                            <div class="row ImageGallery">
                                @if (isset($data) && $data->images->isNotEmpty())
                                    @foreach ($data->images as $item)
                                        <div class="col-sm-3">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <a  title="{{ __('lang.delete') }}"
                                                        href="{{ route('admin.product.delete-image', ['id' => $data->id, 'it' => $item->id]) }}"
                                                        class="btn btn-danger  sw-alert"><i
                                                            class="ti ti-trash"></i></a>
                                                    <div class="preview_images prev_prod_imgs">
                                                        <a href="{{ asset($item->image) }}">
                                                            <img src="{{ asset($item->image) }}"
                                                                class="img-thumbnail img_pro_dis">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <div class="form-group @error('images') invalid @enderror">
                                <div class="file-loading">
                                    <input id="file-1" type="file" name="images[]" multiple
                                        class="filesUploads" data-show-upload="false"
                                        data-msg-placeholder="{{ __('lang.drop_images') }}"
                                        data-browse-on-zone-click="true">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row pt-4" id="SpecificationsList">
                <br>
                <div class="col-md-12 main-color">
                    <b>
                        {{ __('lang.specifications') }}:
                    </b>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('lang.color') }}</th>
                            <th>{{ __('lang.size') }}</th>
                        </tr>
                    </thead>
                    <tbody class="attribute-body">
                        @if ($data->id)
                        {{-- {{dd($data->variations)}} --}}
                            @foreach (optional($data)->colors as $item)
                                {{-- {{ dd(optional($data)->colors ) }} --}}
                                {{-- {{dd($item)}} --}}
                                <tr>

                                    {!! Form::hidden('attributes[' . $loop->iteration . '][product_id]', $item->product_id) !!}
                                    <td>
                                        {!! Form::select('attributes[' . $loop->iteration . '][color]', $colors, $item->color_id, [
                                            'class' => 'form-control select2',
                                            'placeholder' => __('lang.color'),
                                        ]) !!}
                                    </td>
                                    <td>
                                        {{-- {{ dd($item->getSizes($item->color_id)) }} --}}
                                        <select name="attributes[{{ $loop->iteration }}][size][]"
                                            class="form-control select2" multiple id="">
                                            @foreach ($sizes as $id => $name)
                                                <option
                                                    {{ in_array($id, $data->getSizes($item->color_id)) ? 'selected' : '' }}
                                                    value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>

                                    </td>

                                    <td>
                                        <button onclick="variationManager.remove(this)" type="button"
                                            class="btn btn-danger btn-sm">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="">
                    <button type="button" onclick="variationManager.add()" class="btn btn-warning"><i
                            class="icon-plus"></i>
                        {{ __('lang.add_color') }}</button>
                </div>


            </div>
            {{-- <div class="loading_request">
                <img src="{{ asset('images/loading.gif') }}">
            </div> --}}
            <hr>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-9">
                                <button type="submit" id="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
                                <a href="{{ route('admin.product.index') }}" class="btn w3-gray text-white">{{ __('lang.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endslot
    @endcomponent
@endsection
{{-- <div class="modal-dialog modal-dialog-centered">
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
                action="{{ $resource->id ? route('admin.category.update', $resource->id) : route('admin.category.store') }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 pt-3 text-center">

                            {!! Form::label('image', __('lang.image'), ['class' => 'form-label']) !!} <br>
                            <div class="student_image">
                                <img class=" image-preview-image  "
                                    src="{{ asset($resource->image ?? 'assets/img/default.jpg') }}">
                            </div>

                            <br>
                            <label for="image"class="btn btn-primary text-white mt-2">
                                <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
                            </label>

                            <input type="file" onchange="changeImage(this, 'image')" id="image"
                                class="d-none form-control mt-3" name="image">
                        </div>
                        <div class="col-6 pt-3 text-center">

                            {!! Form::label('icon', __('lang.icon'), ['class' => 'form-label']) !!} <br>
                            <div class="student_image">
                                <img class=" image-preview-icon  "
                                    src="{{ asset($resource->icon ?? 'assets/img/default.jpg') }}">
                            </div>

                            <br>
                            <label for="icon"class="btn btn-primary text-white mt-2">
                                <i class="ti ti-cloud-upload fs-6 cursor-pointer"></i>
                            </label>

                            <input type="file" onchange="changeImage(this, 'icon')" id="icon"
                                class="d-none form-control mt-3" name="icon">
                        </div>
                        <hr>
                        @foreach (config('translatable.locales') as $key => $locale)
                            <div class="col-md-12 pt-2">
                                <div class="form-group">
                                    <label for="name">
                                        {{ __('lang.' . $locale . '.title') }}
                                    </label>
                                    {!! Form::text("{$locale}[title]", old("{$locale}[title]", optional($resource->translate($locale))->title), [
                                        'class' => 'form-control',
                                    ]) !!}
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
</div> --}}
@section('css')
    <style>

    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css" media="all"
        rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput-rtl.css" media="all"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets') }}/css/magnific-popup.css" rel="stylesheet" type="text/css" />
@stop
@section('js')



    <!-- Images Delete Script -->
    <script>
        $(document).on('click', '.confirmDelImg', function() {
            if (confirm(CONFIRMATION_MSG) === true) {
                let Self = $(this);
                $.ajax({
                    url: Self.data('id'),
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.status === true) {
                            Self.parents('.col-sm-3').fadeOut(500, function() {
                                Self.parents('.col-sm-3').remove();
                            });
                        }
                    }
                });
            }
        });
    </script>
    <!-- File Input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js" type="text/javascript">
    </script>
    <script>
        $(".filesUploads").fileinput({
            theme: 'fa',
            language: 'ar',
            uploadAsync: false,
            rtl: true,
            showUpload: false,
            dropZoneTitle: '{{ __('lang.drop_images') }} <br/>',
            dropZoneClickTitle: '{{ __('lang.or_click_to_select') }} <br/>',
            showRemove: true,
            showCancel: true,
            autoReplace: false,
            allowedFileExtensions: ['jpg', 'png', 'jpeg'],
            overwriteInitial: false,
            maxFileSize: 4000,
            maxFileCount: "@isset($data) {{ 10 - $data->images_count }}) @else 10 @endisset",
            msgFilesTooMany: '{{ __('lang.num_selected_img') }} <b>({n})</b> {{ __('lang.max_num') }} <b>{m}</b>!',
            msgPlaceholder: '{{ __('lang.choose') }} {{ __('lang.image') }}',
            slugCallback: function(filename) {
                return filename.replace('(', '_').replace(']', '_');
            },
            browseLabel: '{{ __('lang.browse') }}',
            browseClass: 'btn w3-blue',
            removeLabel: '{{ __('lang.delete') }}',
            minFileCount: 0,
            validateInitialCount: true,

        });

        $(".file").fileinput({
            theme: 'bi',
            language: 'ar',
            rtl: true,
            showUpload: false,
            fileActionSettings: {
                showUpload: false,
            },
            dropZoneTitle: '{{ __('lang.drop_images') }} <br/>',
            dropZoneClickTitle: '{{ __('lang.or_click_to_select') }} <br/>',
            showRemove: true,
            allowedFileExtensions: ['jpg', 'png', 'jpeg'],
            overwriteInitial: false,
            maxFileSize: 4000,
            maxFileCount: "@isset($data) {{ 10 - $data->images_count }}) @else 10 @endisset",
            msgFilesTooMany: '{{ __('lang.num_selected_img') }} <b>({n})</b> {{ __('lang.max_num') }} <b>{m}</b>!',
            msgPlaceholder: '{{ __('lang.choose') }} {{ __('lang.image') }}',
            slugCallback: function(filename) {
                return filename.replace('(', '_').replace(']', '_');
            },
            browseLabel: '{{ __('lang.browse') }}',
            browseClass: 'btn w3-blue',
            removeLabel: '{{ __('lang.delete') }}',
        });
    </script>
    <!-- Meta & SM Desc Length -->
    <script>
        $('.max_length').keyup(function() {
            var length = $(this).attr('maxlength') - $(this).val().length;
            $(this).parent().find('.remChars').text(length);
        });
    </script>
    <script>
        var variationManager = {
            template: `
                {!! Form::hidden('attributes[{id}][product_id]', null, ['class' => 'product_id']) !!}
                <td>
                    {!! Form::select('attributes[{id}][color]', $colors, null, [
                        'class' => 'form-control color select2',
                        'placeholder' => __('lang.color'),
                    ]) !!}
                </td>
                <td>
                    {!! Form::select('attributes[{id}}][size][]', $sizes, null, [
                        'class' => 'form-control size select2',

                        'multiple' => 'multiple',
                    ]) !!}
                </td>

                <td>
                    <button onclick="variationManager.remove(this)" type="button"
                        class="btn btn-danger ">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            `,

            add: function() {
                let id = new Date().getTime() + "" + new Date().getMilliseconds();
                let row = document.createElement('tr');
                row.innerHTML = variationManager.template;
                $(row).find(".color").attr('name', 'attributes[' + id + '][color]');
                $(row).find(".size").attr('name', 'attributes[' + id + '][size][]');
                $(row).find(".product_id").attr('name', 'attributes[' + id + '][product_id]');

                $('.attribute-body').append(row);
                $('.select2').select2();
            },

            remove: function(element) {
                $(element).closest('tr').remove();
            }


        };
    </script>

    <script>
         let defaultOption = document.createElement('option');
            defaultOption.innerHTML = "{{ __('lang.choose') }} {{__('lang.brand')}}";
         let defaultOption2 = document.createElement('option');
            defaultOption2.innerHTML = "{{ __('lang.choose') }} {{__('lang.category')}}";
        $('#country_id').on('change', function() {
            $.ajax({
                url: "{{ route('admin.product.get-brands-and-categories') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    country_id: $(this).val()
                },
                success: function(res) {
                    $('#brand_id').empty();
                    $('#category_id').empty();
                    $('#category_id').append(defaultOption2);
                    $('#brand_id').append(defaultOption);

                    $.each(res.brands, function (key, value) {
                    $('#brand_id').append('<option value="'+value.id+'">'+value.title+'</option>');
                    });
                    $.each(res.categories, function (key, value) {
                    $('#category_id').append('<option value="'+value.id+'">'+value.title+'</option>');
                    });
                }
            })
        })
    </script>

@stop
