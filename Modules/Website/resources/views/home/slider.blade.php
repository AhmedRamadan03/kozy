<section class="" style="position: relative;top:-90px">
    <div class="">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-warp="true">
            <div class="carousel-indicators">
                @foreach ($sliders as $item)
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $loop->index }}"
                        class="active" aria-current="true" aria-label="Slide {{ $loop->index }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($sliders as $item)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ $item->image_url }}" class="mx-auto d-block"
                                    height="{{ isMobile() ? '100%' : '700' }}"
                                    width="100%" alt="...">
                    </div>
                @endforeach


            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>


    </div>
</section>
