<div class="container pt-3 mb-5">
    <div class="row">
        @foreach ($features as $item)
            <div class="col-lg-3 col-md-6 col-12">
                <div class="d-flex gap-3  align-items-center feature--item">
                    <img src="{{asset($item->image)}}" width="57" height="57" alt="{{ $item->title }}">
                    <div class="">
                        <h6> <b>{{ $item->title }}</b> </h6>
                        <p>{{ $item->description }}</p>
                        </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
