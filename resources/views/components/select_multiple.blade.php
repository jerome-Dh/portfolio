<div class="uk-width-1-1@s uk-margin" id="{{ $id }}">

    <label class="uk-form-label" >

        {{ $label }}

        @if($optional)
            <span class="uk-text-muted">(Optionnel)</span>
        @endif
    </label>

	<table class="uk-table uk-table-hover uk-table-striped uk-table-middle">

		<tr class="uk-form-controls uk-margin-small" item="item-0">
			<td>
				1
			</td>
			<td>
				<label>

					<select
						class="uk-select @error('{!! $name !!}') uk-form-danger @enderror"
						name="{{ $name }}"
						{{ $optional ? '' : 'required' }}
					>

						<option></option>

						{{-- Show the values --}}
						@foreach($values as $key => $val)
							<option value="{!! $key !!}">{!! $val !!}</option>
						@endforeach

					</select>

				</label>
				@error($name)
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</td>
			<td>
				<a href="javascript:void(0)" +
				class="uk-icon-link uk-float-right red"
				uk-icon="minus-circle"
				uk-tooltip="Rétirer cette ligne"
				></a>
			</td>
		</tr>

	</table>

	<div class="uk-width-1-1@s">
		<a href="javascript:void(0)"
		   class="uk-link uk-float-right vert"
		   onclick="return {!! $scriptCodeAdd.'(\''.$id.'\')' !!}"
		   uk-tooltip="Ajouter une ligne"
		><span uk-icon="plus-circle"></span> Nouvelle ligne</a> 
	</div>

</div>


