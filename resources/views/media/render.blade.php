
@forelse ($medias as $value)
    <div class="media-item">
        <div class="h-100">
            <img src="{{ asset('uploads').'/media/'.$value->path }}" alt="{{ $value->name }}">
        </div>
        <div class="media-info" title="{{ $value->name }}">
            <p>File Type: {{ strtoupper($value->extension) }}</p>
            <p>Uploaded: {{ dateFormat($value->created_at) }}</p>
            <button type="button" id="delete-btn" data-id="{{ $value->id }}" class="text-danger pl-0 border-0 bg-transparent">Delete</button>
        </div>
    </div>
@empty

@endforelse
