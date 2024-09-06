<div class="form-group row {{ $rowClass ?? '' }}">
    <label for="{{ $name }}" class="{{ $labelClass ?? 'col-sm-2' }} {{ $required ?? '' }}">{{ $labelName }}</label>
    <div class="col-sm-10 {{ $col ?? '' }}">
        <textarea class="form-control form-control-sm {{ $class ?? '' }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" rows="{{ $rows ?? '4' }}">{{ $value ?? '' }}</textarea>
        @isset($error)
            @error($error)
                <small class="text-danger">{{ $message }}</small>
            @enderror
        @endisset
    </div>
</div>  
