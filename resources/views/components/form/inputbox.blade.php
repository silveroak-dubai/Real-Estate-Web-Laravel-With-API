<div class="{{ $groupClass ?? '' }} mb-3">
    @if (!empty($labelName))
    <label for="{{ $name }}" class="form-label {{ $required ?? '' }}">{{ $labelName }}</label>
    @endif
    <input type="{{ $type ?? 'text' }}" class="form-control form-control-sm shadow-none rounded-0 {{ $class ?? '' }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" value="{{ $value ?? '' }}" autocomplete="off" @if (!empty($multiple)) multiple @endif>
    @if (!empty($optional))
        <p class="optional-text mb-0">{{ $optional }}</p>
    @endif
    @isset($name)
        @error($name)
            <small class="text-danger d-block fw-bold">{{ $message }}</small>
        @enderror
    @endisset
</div>
