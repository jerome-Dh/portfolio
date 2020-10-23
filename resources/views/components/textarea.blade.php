
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
            <textarea cols="20" rows="10"
                      class="uk-textarea @error('{{ $name }}') uk-form-danger @enderror"
                      id="{{ $name }}"
                      name="{{ $name }}"
                      autocomplete="{{ $name }}"
                      placeholder="{{ $placeholder }}"
                      minlength="3"
                      {{ $optional ? '' : 'required' }}
                      @foreach($adds as $elt)
                        {!! $elt !!}
                     @endforeach
            >{!! $value !!}</textarea>
            @error($name)
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
