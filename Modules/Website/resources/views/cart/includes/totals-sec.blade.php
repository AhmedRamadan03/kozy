<div class="d-flex justify-content-between">
    <b>{{ __('front.subtotal') }}</b>
    <b>{{ $carts['sub_total'] }} {{ session('country')->currency }}</b>
</div>
<div class="d-flex justify-content-between pt-3">
    <b>{{ __('front.shipping') }}</b>
    <b>{{ $carts['shipping'] ?? 0.0 }} {{ session('country')->currency }}</b>
</div>
<div class="d-flex justify-content-between pt-3 text-success">
    <b>{{ __('front.tax') }}( {{ session('country')->tax}} %)</b>
    <b>{{ $carts['tax'] ?? 0.0 }} {{ session('country')->currency }}</b>
</div>
<hr>
<div class="d-flex justify-content-between pt-3 main-color">
    <b>{{ __('front.total') }}</b>
    <b>{{ $carts['total'] ?? 0.0 }} {{ session('country')->currency }}</b>
</div>
