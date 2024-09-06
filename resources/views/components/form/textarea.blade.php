<div class="mb-3 {{ $groupClass ?? '' }}">
    <label for="{{ $name }}" class="form-label {{ $required ?? '' }}">{{ $labelName }}</label>
    <textarea class="form-control shadow-none rounded-0 {{ $class ?? '' }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" rows="{{ $rows ?? '3' }}">{{ $value ?? '' }}</textarea>
    @if (!empty($optional))
        <p class="optional-text mb-0">{{ $optional }}</p>
    @endif
    @isset($error)
        @error($error)
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    @endisset
</div>
