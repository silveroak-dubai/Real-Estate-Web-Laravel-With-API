
<div id="grid" class="list-unstyled p-0 m-0">
    @foreach ($medias as $value)
    <div class="image border rounded" style="width: 100%; height: 100px;" data-id="{{ $value->id }}">
        <img src="{{ asset(STORAGE_PATH).'/media/'.$value->path }}" width="100%" height="100%" alt="Image">
    </div>
    @endforeach
</div>
