{{-- List --}}
@extends('layouts.admin')

@section('title', 'List of users')

@section('contenu')

    <h2>
		<span uk-icon="icon:list; ratio:2"></span>
		List of users
	</h2>

	<div class="uk-float-right">
        <a href="{{ route('admin.users.create') }}" class="uk-button uk-button-primary"><span uk-icon="icon: plus-circle"></span> Ajouter</a>
    </div>

    @if(isset($info))
        <div class="uk-alert uk-alert-primary" uk-alert>
			<a class="uk-alert-close" uk-close></a>
			<p>
				{{ $info }}
			</p>
        </div>
    @endif

	  <!-- Information zone -->
    @component('components.alert', [])
    @endcomponent

    @if( ! count($users))

        <h3><span uk-icon="icon: warning; ratio:1.5"></span> Not item were found !</h3>

    @else

        {!! $users->links() !!}
        <div class="uk-overflow-auto">

            <table class="uk-table uk-table-hover uk-table-striped uk-table-middle">

                <thead>
                    <tr class="head-table">
                        <th class="uk-text-success uk-text-center">
							<span uk-icon="icon:thumbnails; ratio:1"></span>
						</th>
                        <th class="uk-text-success uk-text-center">Illustration</th>
                        <th class="uk-text-success uk-text-center">Name</th>
                        <th class="uk-text-success uk-text-center">Email</th>
                        <th class="uk-text-success uk-text-center">Operation</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($users as $user)

                    <tr class="uk-text-center">

                        <td>{!! $loop->iteration !!}</td>

                        <td>
                            @if($user->image)
                                <img src="{{ asset('storage/'.$user->image) }}" width="100"/>
                            @else
                                <span uk-icon="icon: image; ratio:2"></span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.users.show', [$user->id]) }}" uk-tooltip="Voir tous les détails">
                                {{ ucfirst($user->name) }}
                            </a>
                        </td>

                        <td>{{ $user->email }}</td>

                        <td>

                            @component('components.update-buttons', [
                               'id' => $user->id,
                               'edit_route' => 'admin.users.edit',
                               'destroy_route' => 'admin.users.destroy',
                               'name' => 'user',
                               'buttons' => false,
                               'back_button' => false,
							   'others' => '',
                            ])
                            @endcomponent

                        </td>

                    </tr>

                @endforeach
                </tbody>

            </table>

        </div>

        {!! $users->links() !!}

    @endif

@endsection
