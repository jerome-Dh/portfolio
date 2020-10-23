
	{{-- Create a form to update the status of a commande --}}

	<div class="uk-margin">

        <div class="uk-form-controls">
			<select class="uk-select" id="change-statut" 
			onchange="change_statut_command('#change-statut', {!! $id !!})"
			uk-tooltip="Cliquer pour changer le statut">

				{{-- Afficher les valeurs --}}
				@foreach(config('custum.list_statuts') as $key => $val)
					<option {{ $value == $key ? 'selected' : '' }} value="{!! $key !!}">{!! $val !!}</option>
				@endforeach

			</select>
        </div>
    </div>