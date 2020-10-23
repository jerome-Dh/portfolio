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
    
    @component('components.input', [
        'type' => 'text',
        'name' => 'name_en',
        'value' => old('name_en') ?? ($name_en ?? ''),
        'optional' => false,
        'taille' => 1,
        'label' => 'Name en',
        'placeholder' => 'Name en',
        'adds' => [],
    ])
    @endcomponent
    
    @component('components.input', [
        'type' => 'text',
        'name' => 'name_fr',
        'value' => old('name_fr') ?? ($name_fr ?? ''),
        'optional' => false,
        'taille' => 1,
        'label' => 'Name fr',
        'placeholder' => 'Name fr',
        'adds' => [],
    ])
    @endcomponent
    
    @component('components.input', [
        'type' => 'text',
        'name' => 'subname_en',
        'value' => old('subname_en') ?? ($subname_en ?? ''),
        'optional' => true,
        'taille' => 1,
        'label' => 'Subname en',
        'placeholder' => 'Subname en',
        'adds' => [],
    ])
    @endcomponent
    
    @component('components.input', [
        'type' => 'text',
        'name' => 'subname_fr',
        'value' => old('subname_fr') ?? ($subname_fr ?? ''),
        'optional' => true,
        'taille' => 1,
        'label' => 'Subname fr',
        'placeholder' => 'Subname fr',
        'adds' => [],
    ])
    @endcomponent
    
    @component('components.submit-buttons', [
		'name' => 'Enregistrer',
		'back_button' => true,
		'others' => '',
	])
    @endcomponent

</form>