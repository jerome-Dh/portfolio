
{{-- Boutons de modification & suppression --}}
<div class="uk-width-1-1@s uk-text-right">

    <hr class="uk-divider-icon">

	@if($back_button)
		<a href="#" class="uk-button uk-button-default" type="button"
            onclick="window.history.back();">Quitter</a>
	@endif

    <button class="uk-button uk-button-primary" type="submit" name="action" value="save">
        {{ $name }}
    </button>

    <!-- Button d'impression  -->
    @isset($print)
        <button class="uk-button uk-button-secondary" type="submit" name="action" value="print" uk-tooltip="Imprimer">
            {{ $print }}
        </button>
    @endisset

	<!-- Autres html -->
	{!! $others ?? '' !!}

</div>
