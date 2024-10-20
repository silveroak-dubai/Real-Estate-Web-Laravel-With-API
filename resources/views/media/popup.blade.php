
<ul class="list-unstyled p-0 m-0">
    @foreach ($medias as $value)
    <li id="select-media" class="border rounded" data-id="{{ $value->id }}" data-src="{{ asset(STORAGE_PATH).'/media/'.$value->path }}">
    <img width="100%" height="100%" class="rounded" src="{{ asset(STORAGE_PATH).'/media/'.$value->path }}" alt="{{ $value->name }}">
    </li>
    @endforeach
</ul>
