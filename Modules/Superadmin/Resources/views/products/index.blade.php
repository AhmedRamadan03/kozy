    @extends('superadmin::layouts.master')

@php
    $title = __('lang.products');
@endphp

@section('title')
    {{ $title }}
@endsection


@section('content')

    @include('superadmin::layouts.includes.breadcrumb' , ['title' => $title])
    <div class="row pt-4">
        <div class="col-md-12">
            @component('superadmin::layouts.includes.card' ,['title'=>__('lang.filter')])

            @slot('content')
            <form action="{{ route('admin.product.index') }}" method="get">
                @csrf
                <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('search',__('lang.search'), ['class' => 'form-label']) !!}
                                {!! Form::text('search',request()->search,['class' => 'form-control'])!!}
                            </div>
                        </div>
                            @if(auth()->user()->show_all ==1)
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('country_id', __('lang.choose') . ' ' .__('lang.country'), ['class' => 'form-label']) !!}
                                    {!! Form::select('country_id', $countries, old('country_id', request()->country_id), ['class' => 'form-control form-select select2' ,  'id' => 'country_id' , 'placeholder' => __('lang.choose') . ' ' .__('lang.country')]) !!}
                                </div>
                            </div>
                            @endif
                            <div class="col-lg-4 ">
                                <div class="form-group ">
                                    <label class="form-label" for="brand_id">{{ __('lang.brands') }}  </label>
                                    {!! Form::select('brand_id', $brands, request()->brand_id, ['class' => 'form-control select2',  'id' => 'brand_id', 'placeholder' => __('lang.choose') . ' ' . __('lang.brand')]) !!}

                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                <div class="form-group ">
                                    <label class="form-label" for="category_id">{{ __('lang.categories') }}  </label>
                                    {!! Form::select('category_id', $categories, request()->category_id, ['class' => 'form-control select2',  'id' => 'category_id', 'placeholder' => __('lang.choose') . ' ' . __('lang.category')]) !!}

                                </div>
                            </div>
                            <div class="col-lg-4 pt-2 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">{{ __('lang.status') }}  </label>
                                    {!! Form::select('hide', ['0' => __('lang.published'), '1' => __('lang.unpublished')], request()->hide, ['class' => 'form-control select2',  'id' => 'status', 'placeholder' => __('lang.choose') . ' ' . __('lang.status')]) !!}

                                </div>
                            </div>
                            <div class="col-lg-4 pt-2 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="discount">{{ __('lang.discount') }} </label>
                                    {!! Form::select('discount', ['yes' => __('lang.yes'), 'no' => __('lang.no')], request()->discount, ['class' => 'form-control select2',  'id' => 'discount', 'placeholder' => __('lang.choose')]) !!}

                                </div>
                            </div>

                            <div class="col-md-4 pt-4">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"> <i class="ti ti-filter"></i> {{ __('lang.filter') }}</button>
                                    <a href="{{ route('admin.product.index') }}" class="btn w3-light-grey"> <i class="ti ti-reload"></i>{{ __('lang.reset') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
               @endslot
           @endcomponent
        </div>
    </div>

    <div class="row pt-4">
        <div class="col-md-12">
           @component('superadmin::layouts.includes.card' )
               @slot('tool')
               <a href="{{ route('admin.mainPageForProducts') }}"  class="btn  btn-info float-end mb-2"> <i class="ti ti-arrow-back-up"></i> {{ __('lang.back')  }}</a>

                   <a href="{{ route('admin.product.create') }}"  class="btn btn-primary float-end mb-2"> <i class="ti ti-plus"></i> {{ __('lang.add') . ' ' . __('lang.product') }}</a>
               @endslot

               @slot('content')
                   @component('superadmin::layouts.includes.table')
                       @slot('headers')
                            <td>#</td>
                            <td>{{__('lang.sku')}}</td>
                           <td>{{ __('lang.image') }}</td>
                           <td>{{ __('lang.name') }}</td>
                           @if(auth()->user()->show_all ==1)
                           <td>{{ __('lang.country') }}</td>
                          @endif
                          <td>{{ __('lang.category') }}</td>
                          <td>{{ __('lang.brand') }}</td>
                          <td>{{ __('lang.price') }}</td>
                          <td>{{ __('lang.discount') }}</td>
                          <td>{{ __('lang.quantity') }}</td>
                           <td>{{ __('lang.status') }}</td>

                           <td>{{ __('lang.actions') }}</td>
                       @endslot

                       @slot('data')
                           @if (count($data)>0)
                               @foreach ($data as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->sku }}</td>
                                        <td>
                                            <img src="{{asset($item->image)}}" style="width:50px;height:50px;" class="rounded-3">

                                        </td>
                                        <td>

                                            <b> {{ Str::limit($item->title,30) }}</b>
                                        </td>
                                        @if(auth()->user()->show_all ==1)
                                        <td>{{ optional($item->country)->title }}</td>
                                        @endif
                                        <td> {{optional($item->category)->title}} </td>
                                        <td> {{optional($item->brand)->title}} </td>
                                        <td>
                                            @if ($item->discount > 0)
                                            <span
                                                class="discounted_price">{{ $item->price }}</span>
                                            - {{ $item->after_discount }}
                                            @else
                                                {{ $item->price }}
                                            @endif

                                        </td>
                                        <td><span
                                            class="badge bg-{{ $item->discount > 0 ? 'success' : 'warning' }}"><i
                                                class="ti ti-{{ $item->discount > 0 ? 'check' : 'times' }}"></i></span>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                        <td>

                                            <a class="form-check form-switch d-flex m-1 justify-content-between text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('lang.change_status') }}" >
                                                <input class="form-check-input "   type="checkbox" role="switch" id="flexSwitchCheckChecked-{{ $item->id }}" onclick="changeStatus(this,{{ $item->id }})" {{ $item->hide == 1 ? '' : 'checked' }}>
                                                <label class="form-check-label" for="flexSwitchCheckChecked-{{ $item->id }}">

                                                </label>
                                            </a>
                                        </td>
                                        <td>

                                            <a href="{{ route('admin.product.show',$item->id) }}" class="btn  btn-info btn-sm"><i class="ti ti-eye"></i></a>
                                            <a href="{{ route('admin.product.edit',$item->id) }}" class="btn  btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                            <a href="{{ route('admin.product.delete',$item->id) }}" class="btn btn-danger sw-alert btn-sm"><i class="ti ti-trash"></i></a>
                                        </td>
                                   </tr>
                               @endforeach
                           @else
                               <tr>
                                   <td colspan="{{ auth()->user()->show_all ==1 ? 12 : 11 }}">
                                    @component('superadmin::layouts.includes.alert')

                                    @endcomponent
                                   </td>
                               </tr>
                           @endif
                       @endslot
                   @endcomponent
               @endslot
           @endcomponent
        </div>
    </div>

    <div class="modal fade table-modal" id="table-model" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
</div>
@endsection

@section('js')

<script>
    function changeStatus(el , id){
        var hide = 1 ;
        if(el.checked){
            hide = 0 ;
        }
        $.ajax({
            url: "{{ route('admin.product.change-status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                is_active: hide
            },
            success: function (results) {
               if (results.success) {
                    swal.fire("", results.message, "success");
               } else {
                    swal.fire("", message, "error");
               }
            }
        });
    }
</script>
@endsection
