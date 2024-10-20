
@forelse ($medias as $value)
    <div class="media-item">
        <div class="h-100">
            @if (in_array($value->extension,['mp4','pdf']))
            <iframe src="{{ asset(STORAGE_PATH).'/media/'.$value->path }}" width="100%" height="100%" frameborder="0"></iframe>
            @else
            <img src="{{ asset(STORAGE_PATH).'/media/'.$value->path }}" alt="{{ $value->name }}">
            @endif
        </div>
        <div class="media-info" title="{{ $value->name }}">
            <p>File Type: {{ strtoupper($value->extension) }}</p>
            <p>Uploaded: {{ dateFormat($value->created_at) }}</p>
            <button type="button" id="delete-btn" data-id="{{ $value->id }}" class="text-danger ps-0 border-0 bg-transparent">Delete</button>
            <a href="{{ asset(STORAGE_PATH).'/media/'.$value->path }}" download class="text-success">Download</a>
        </div>
    </div>
@empty

@endforelse
