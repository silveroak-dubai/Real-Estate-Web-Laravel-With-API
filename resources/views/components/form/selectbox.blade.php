<div class="mb-3 {{ $groupClass ?? '' }}">
    @if (!empty($labelName))
    <label for="{{ $name }}" class="form-label {{ $required ?? '' }}">{{ $labelName }}</label>
    @endif
    <select name="{{ $name }}" id="{{ $id ?? $name }}" class="form-control form-control-sm rounded-0 shadow-none rounded-0 {{ $class ?? '' }}" @if(!empty($onchange)) onchange="{{ $onchange }}" @endif @if (!empty($multiple)) {{ $multiple }} @endif>
        {{ $slot }}
    </select>
    @isset($error)
        @error($error)
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    @endisset
</div>
