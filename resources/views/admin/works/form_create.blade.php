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
        'name' => 'title_en',
        'value' => old('title_en') ?? ($title_en ?? ''),
        'optional' => true,
        'taille' => 1,
        'label' => 'Title en',
        'placeholder' => 'Title en',
        'adds' => [],
    ])
    @endcomponent

    @component('components.input', [
        'type' => 'text',
        'name' => 'title_fr',
        'value' => old('title_fr') ?? ($title_fr ?? ''),
        'optional' => true,
        'taille' => 1,
        'label' => 'Title fr',
        'placeholder' => 'Title fr',
        'adds' => [],
    ])
    @endcomponent

    @component('components.input', [
        'type' => 'text',
        'name' => 'description_en',
        'value' => old('description_en') ?? ($description_en ?? ''),
        'optional' => true,
        'taille' => 1,
        'label' => 'Description en',
        'placeholder' => 'Description en',
        'adds' => [],
    ])
    @endcomponent

    @component('components.input', [
        'type' => 'text',
        'name' => 'description_fr',
        'value' => old('description_fr') ?? ($description_fr ?? ''),
        'optional' => true,
        'taille' => 1,
        'label' => 'Description fr',
        'placeholder' => 'Description fr',
        'adds' => [],
    ])
    @endcomponent

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

    @component('components.input', [
        'type' => 'url',
        'name' => 'source',
        'value' => old('source') ?? ($source ?? ''),
        'optional' => true,
        'taille' => 1,
        'label' => 'Source',
        'placeholder' => 'Source',
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
