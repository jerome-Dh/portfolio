
{{-- Créer un radio pour le formulaire --}}

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
            @foreach($values as $key => $val)
                <label>
                     <input id="{{ $name }}" name="{{ $name }}"
                            type="radio" class="uk-radio"
                            value="{{ $key }}" {{ $value == $key ? 'checked' : '' }}
                             {{ $optional ? '' : 'required' }}
                            @foreach($adds as $elt)
                                {!! $elt !!}
                            @endforeach
                     >
                    {{ $val }}</label> &nbsp; &nbsp;
            @endforeach

            @error($name)
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
