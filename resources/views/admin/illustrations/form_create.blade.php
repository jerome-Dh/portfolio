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
    
    @component('components.file', [
        'name' => 'image',
        'value' => old('image') ?? ($image ?? ''),
        'optional' => true,
        'taille' => 1,
        'label' => 'Image',
        'others' => '',
        'adds' => [],
    ])
    @endcomponent
    
    @component('components.select', [
       'name' => 'experience_id',
       'value' => old('experience_id') ?? ($experience_id ?? ''),
       'optional' => false,
       'taille' => 1,
       'label' => 'Experience',
       'values' => $experiences,
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