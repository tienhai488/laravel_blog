<div class="form-group {{ $class }}">
    <label for="{{ $name }}">{{ $title }}</label>
    <input id="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}"
        class="form-control @if ($errors->has($name)) is-invalid @endif" name="{{ $name }}"
        value="{{ $value }}" autocomplete="{{ $name }}" autofocus spellcheck="false" @readonly($readonly)>
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
