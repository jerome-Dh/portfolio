
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
            @if($value)
				<img src="{{ asset('storage/'.$value) }}" alt="logo" width="200"/>
			@endif
            <input type="file"
                   class="uk-input @error('{!! $name !!}') uk-form-danger @enderror"
                   id="{{ $name }}"
                   name="{{ $name }}"
                   value="{{ $value }}"
				   accept="image/*"
                    {{ $optional ? '' : 'required' }}

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
