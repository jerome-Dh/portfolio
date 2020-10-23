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
        'name' => 'name',
        'value' => old('name') ?? ($name ?? ''),
        'optional' => false,
        'taille' => 1,
        'label' => 'Name',
        'placeholder' => 'Name',
        'adds' => [],
    ])
    @endcomponent

    @component('components.input', [
        'type' => 'email',
        'name' => 'email',
        'value' => old('email') ?? ($email ?? ''),
        'optional' => false,
        'taille' => 1,
        'label' => 'Email',
        'placeholder' => 'Email',
        'adds' => [],
    ])
    @endcomponent

    @component('components.input', [
        'type' => 'password',
        'name' => 'password',
        'value' => old('password') ?? ($password ?? ''),
        'optional' => false,
        'taille' => 1,
        'label' => 'Password',
        'placeholder' => 'Password',
        'adds' => [],
    ])
    @endcomponent

    @component('components.input', [
        'type' => 'number',
        'name' => 'role',
        'value' => old('role') ?? ($role ?? ''),
        'optional' => false,
        'taille' => 1,
        'label' => 'Role',
        'placeholder' => 'Role',
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
