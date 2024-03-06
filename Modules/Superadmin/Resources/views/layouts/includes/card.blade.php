<div class="card">
    @if (isset($title) || isset($tool))
    <div class="card-header  {{ isset($class)?$class :'' }} p-1 " @if(isset($action)) onclick="$('#filter_body').slideToggle()" @endif >

        @if (isset($title))
        <h4>
            @if (isset($icon))
            <i class=" ti ti-filter"></i>
            @endif
            {{ isset($title)?$title :'' }}
        </h4>
        @endif
        <div class="text-start  " >
            @if (isset($tool))
                {!! $tool !!}
            @endif
        </div>
    </div>
    @endif
    @if (isset($content)||isset($id))
        <div class="card-body p-3" id="{{ isset($id)?'filter_body' :'' }}">
            {!! isset($content)? $content:'' !!}
        </div>
    @endif
</div>
