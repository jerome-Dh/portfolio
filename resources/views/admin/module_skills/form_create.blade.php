{{-- Form --}}
@if ($errors->any())
	<div class="uk-alert uk-alert-danger">
		<ul class="uk-list uk-list-bullet">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

@component('components.info', [])
@endcomponent

@component('components.alert', [])
@endcomponent

<form method="POST" action="{{ $url }}" id="form_create" enctype="multipart/form-data"  class="uk-grid-small" uk-grid>

    @if($type == 1)
        @method('PUT')
    @endif

    @csrf
    
    @component('components.select', [
       'name' => 'module_id',
       'value' => old('module_id') ?? ($module_id ?? ''),
       'optional' => false,
       'taille' => 1,
       'label' => 'Module',
       'values' => $modules,
       'adds' => [],
       'others' => '',
    ])
    @endcomponent
    
    @component('components.select', [
       'name' => 'skill_id',
       'value' => old('skill_id') ?? ($skill_id ?? ''),
       'optional' => false,
       'taille' => 1,
       'label' => 'Skill',
       'values' => $skills,
       'adds' => [],
       'others' => '',
    ])
    @endcomponent
    
    @component('components.submit-buttons', [
		'name' => 'Enregistrer',
		'back_button' => true,
		'others' => '',
	])
    @endcomponent

</form>