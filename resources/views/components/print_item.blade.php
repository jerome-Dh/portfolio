
{{-- Boutons d'impression --}}

@if(Auth::check())

    @if($buttons)
        <a href="{!! route($print_route, [$item_id]) !!}" class="uk-button uk-button-secondary uk-button-small" type="button"
           uk-tooltip="Imprimer cet élément" target="_blank">
            <span uk-icon="icon: print"></span> Imprimer
        </a>
    @else
        <a href="{!! route($print_route, [$item_id]) !!}" class="uk-button-link"
           uk-tooltip="Imprimer cet élément" target="_blank">
            <span uk-icon="icon: print"></span>
        </a>
    @endif

@endif
