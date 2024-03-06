<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                @if (isset($headers))
                    {!! $headers !!}
                @endif
            </tr>
        </thead>
        <tbody>
            @if (isset($data))
                {!! $data !!}
            @endif
        </tbody>
    </table>
</div>
