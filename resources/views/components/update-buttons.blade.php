
{{-- Boutons de modifications et suppréssion --}}

    @if($back_button)
        <button class="uk-button uk-button-default uk-button-small" type="button"
                onclick="window.history.back();" uk-tooltip="Rétourner">
            <span uk-icon="icon:history; ratio:1"></span>
        </button> &nbsp;
    @endif

    {{-- @if(Auth::check() and Auth::user()->admin) --}}

        {{-- Mettre à jour --}}
        @if($buttons)
            <a class="uk-button uk-button-primary uk-button-small" href="{!! route($edit_route, [$id]) !!}" uk-tooltip="Modifier">
                Modifier
            </a>
        @else
            <a href="{!! route($edit_route, [$id]) !!}" class="uk-button-link" uk-tooltip="Modifier">
             _<span class="uk-text-primary" uk-icon="icon: pencil"></span></a>
        @endif

        &nbsp; &nbsp;

        {{-- Supprimer --}}

        @if($buttons)
            <button class="uk-button uk-button-danger uk-button-small" type="button"
				uk-tooltip="Supprimer"
                    onclick="if(confirm('Souhaitez-vous vraiment supprimer cet élement ?'))
                            document.querySelector('#destroy-{!!  $name !!}-{!! $id !!}').submit();">
                <span uk-icon="icon: trash"></span></a>
            </button>
        @else
            <a href="javascript:void(0)" class="uk-button-link" 
				uk-tooltip="Supprimer"
               onclick="if(confirm('Souhaitez-vous vraiment supprimer cette {{ $name }} ?'))
                       document.querySelector('#destroy-{{ $name }}-{{ $id }}').submit();">
                <span uk-icon="icon: trash" class="uk-text-danger"></span></a>
        @endif

		&nbsp; &nbsp;
        <!-- Autres html -->
        {!! $others ?? '' !!}

        <form id="destroy-{!! $name !!}-{!! $id !!}" action="{!! route($destroy_route, [$id]) !!}" method="POST">
			@csrf
            @method('DELETE')
        </form>

		{{-- @endif --}}
