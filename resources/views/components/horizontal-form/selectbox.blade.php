<div class="form-group row {{ $rowClass ?? '' }}">
    <label for="{{ $name }}" class="{{ $labelClass ?? 'col-sm-2' }} {{  $required ?? '' }}">{{ $labelName }}</label>
    <div class="col-sm-10 {{ $col ?? '' }}">
        <select class="form-control form-control-sm {{ $class ?? '' }}" name="{{ $name }}" id="{{ $name }}" @if(!empty($onchange)) onchange="{{ $onchange }}" @endif>{{ $slot }}</select>
        @isset($error)
            @error($error)
                <small class="text-danger">{{ $message }}</small>
            @enderror
        @endisset
    </div>
</div>
