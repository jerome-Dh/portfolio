
{{-- Créer un input pour le formulaire --}}

<div class="uk-width-1-{{ $taille }}@s">
    <div class="uk-margin">
        <label class="uk-form-label" for="{{ $name }}">
            {{ $label }}
            @if($optional)
                <span class="uk-text-muted">(Optionnel)</span>
            @endif
        </label>
        <div class="uk-form-controls">
            {!! $others ?? '' !!}
            <input type="{{ $type }}"
                   class="uk-input @error('{!! $name !!}') uk-form-danger @enderror"
                   id="{{ $name }}"
                   name="{{ $name }}"
                   value="{{ $value }}"
                   autocomplete="{{ $name }}"
                   placeholder="{{ $placeholder }}"
                   minlength="3"
                   maxlength="100"
                   {!! $optional ? '' : 'required' !!}

                   @isset($datalist)
                   {!! 'list="'.$datalist.'"' !!}
                   @endisset

                @foreach($adds as $elt)
                     {!! $elt !!}
                @endforeach
            />
            @error($name)
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>