@php
    $title =$product->title ;
@endphp

@extends('superadmin::layouts.master')

@section('title')
    {{ $title }}
@stop


@section('content')

    <!-- Page Header -->
    @include('superadmin::layouts.includes.breadcrumb', ['title' => $title,'new_item' => __('lang.products'), 'url' => route('admin.product.index')])
    <!-- /Page Header -->


    <div class="edit-profile">

            <div class="row">

                @component('superadmin::layouts.includes.card')
                    @slot('tool')
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="main-info-tab" data-bs-toggle="tab" data-bs-target="#main-info" type="button" role="tab" aria-controls="main-info" aria-selected="true">{{ __('lang.main_info') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="false">{{ __('lang.gallery') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">{{ __('lang.specifications') }}</button>
                        </li>

                    </ul>
                    @endslot
                    @slot('content')
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="main-info" role="tabpanel" aria-labelledby="main-info-tab">
                              <div class="row">
                                <div class="col-lg-4 col-md-6 col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.image') }}</b>:<br>
                                        <img src="{{ asset($product->image ?? null) }}" alt="{{ $product->title }}" class="w-100">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-4 col-md-6 col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.title') }} :  {{ $product->title }}</b>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.category') }} :  {{ optional($product->category)->title }}</b>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.brand') }} :  {{ optional($product->brand)->title }}</b>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.price') }} :  {{ $product->price }} {{ auth()->user()->country->currency }}</b>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.discount') }} :  {{ $product->discount }} {{ auth()->user()->country->currency }}</b>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.after_discount') }} :  {{ $product->after_discount }} {{ auth()->user()->country->currency }}</b>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.quantity') }} :  {{ $product->quantity }}</b>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.status') }} :  </b> <span class="badge bg-{{ $product->hide == 0 ? 'success' : 'warning' }}">{{$product->hide == 0 ? __('lang.published') : __('lang.unpublished')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.sku') }} :  {{ $product->sku }}</b>
                                    </div>
                                </div>
                                <div class="  col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.short_description') }}  </b>
                                        <p>{{ $product->short_description }}</p>
                                    </div>
                                </div>
                                <div class="  col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.description') }}  </b>
                                        <p>{!! $product->description !!}</p>
                                    </div>
                                </div>
                                <div class=" col-md-6  col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.meta_keywords') }}  </b>
                                        <p>{!! $product->meta_keywords !!}</p>
                                    </div>
                                </div>
                                <div class=" col-md-6  col-12 pt-3">
                                    <div class="item border-dash w3-round-large p-3">
                                        <b>{{ __('lang.meta_description') }}  </b>
                                        <p>{!! $product->meta_description !!}</p>
                                    </div>
                                </div>
                              </div>
                        </div>
                        <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                            <div class="row ImageGallery">
                                @if (isset($product) && $product->images->isNotEmpty())
                                    @foreach ($product->images as $item)
                                        <div class="col-sm-3">
                                            <div class="card">
                                                <div class="card-body text-center">

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
                        <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                            <div class="col-md-12 pt-3">

                                @if (isset($product) )
                                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>{{ __('lang.color') }}</th>
                                                <th>{{ __('lang.size') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- {{ dd($product->productColors()->get()) }} --}}
                                            @foreach ($product->productColors()->get() as  $item)
                                                <tr>
                                                    <td>{{optional($item->color)->name }}</td>
                                                    <td>{{ implode(' , ', $product->getProductSizes($item->color_id)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                @endif
                            </div>
                        </div>

                    </div>
                    @endslot
                @endcomponent
            </div>
      </div>

@stop
