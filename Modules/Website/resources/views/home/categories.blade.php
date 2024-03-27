<div class="container pt-4 mb-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="d-flex ">
                <b class=" text-dark border--title p{{ isRtl() ? 'e' : 's' }}-2"
                   >
                    {{ __('front.products') }}</b>
            </div>
        </div>



        <div class="col-md-12 pt-5">
            <div class="row pt-3">
                @foreach ($products as $item)
                    <div class="col-lg-3 col-md-6 col-12">
                        @component('website::includes.product-card', ['item' => $item])
                        @endcomponent
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-12 text-center pt-5">
            <a href="{{ route('front.categories') }}" class="main-color btn btn--custom" style="color:#000 !important;background: #E8CFCE !important" id="see_more">
                <b class="fs-3">

                    {{ __('front.see_all_products') }}
                </b>
            </a>

        </div>
    </div>
</div>
