<div class="container pt-3 mb-5">
    <div class="d-flex justify-content-center align-items-center gap-5">
        @foreach ($offers->skip(1)->take(3) as $item)
            <div class=" item flex-fill">
                <div class="d-flex gap-3  align-items-center offer--item">
                    <div class="offer--image" style="background-image: url({{ asset(optional($item->product)->image) }})">
                    </div>
                    {{-- <img src="{{asset(optional($item->product)->image)}}"  alt="{{ optional($item->product)->title }}"> --}}
                    <div class=" p-3">
                        <b class="main-color">{{ optional($item->product)->category->title }}</b>
                        <h5> <b>{{ optional($item->product)->title }}</b> </h5>
                        <span>
                            <b class="main-color">{{ optional($item->product)->after_discount }} {{ session('country')->currency }}</b>
                        @if (optional($item->product)->discount > 0)
                            <del class="text-muted">{{ round(optional($item->product)->price) }} {{ session('country')->currency }}</del>
                        @endif
                        </span>
                        <br>
                        <a href="{{ route('front.productDetails',$item->product->slug) }}" class="btn btn--custom">
                            {{ __('front.buy_now') }}
                        </a>
                        </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
