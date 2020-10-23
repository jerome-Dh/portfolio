
{{-- Créer un select pour le formulaire --}}

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
            <select
                   class="uk-select @error('{!! $name !!}') uk-form-danger @enderror"
                   id="{{ $name }}"
                   name="{{ $name }}"
                    {{ $optional ? '' : 'required' }}

            @foreach($adds as $elt)
                {!! $elt !!}
            @endforeach
            >
				<option></option>
                {{-- Afficher les valeurs --}}
                @foreach($values as $key => $val)
                    <option {{ $value == $key ? 'selected' : '' }} value="{!! $key !!}">{!! $val !!}</option>
                @endforeach
            </select>
            @error($name)
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>