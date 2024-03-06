<a href="{{ $item['url'] }}">
    <div class="card shadow">
        <div class="card-body p-2 text-center position-relative">
           <img width="50px" src="{{ asset($item['image']) }}" alt=""> <br>
            <b class="card-title main-color fs-4">{{ $item['title'] }}</b>
            <p class="text-muted">
                {{ $item['description'] }}
            </p>
            @if (isset($item['count']))
                <span class="badge position-absolute btn-primary" style="top: -7px;
                right: -10px;">{{$item['count']}}</span>
            @endif
        </div>
    </div>
</a>
