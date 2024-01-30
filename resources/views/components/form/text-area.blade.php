<div class="form-group {{ $class }}">
    <label for="{{ $name }}">{{ $title }}</label>
    <textarea id="{{ $name }}" placeholder="{{ $placeholder }}"
        class="form-control @if ($errors->has($name)) is-invalid @endif" name="{{ $name }}"
        value="{{ $value }}" autocomplete="{{ $name }}" autofocus cols="30" rows="5"
        spellcheck="false">{{ $value }}</textarea>
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
