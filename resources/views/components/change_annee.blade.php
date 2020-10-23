
{{-- Créer un select pour le formulaire --}}

<div class="uk-width-1-{{ $taille }}@s">
    
	<div class="uk-margin">

        <div class="uk-form-controls">
			Année <select class="uk-select" id="choix-annee" onchange="choix_annee('#choix-annee')">
				{{-- Afficher les valeurs --}}
				@for($i = 2019; $i < 2050; $i++)
					<option
							{{ $i == session('annee_en_cours') ? 'selected' : '' }}
							value="{!! $i !!}"
					>{!! $i !!}</option>
				@endfor
			</select>
        </div>
    </div>
</div>