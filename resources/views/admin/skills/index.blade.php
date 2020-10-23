{{-- List --}}
@extends('layouts.admin')

@section('title', 'List of skills')

@section('contenu')

    <h2>
		<span uk-icon="icon:list; ratio:2"></span>
		List of skills
	</h2>

	<div class="uk-float-right">
        <a href="{{ route('admin.skills.create') }}" class="uk-button uk-button-primary"><span uk-icon="icon: plus-circle"></span> Ajouter</a>
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

    @if( ! count($skills))

        <h3><span uk-icon="icon: warning; ratio:1.5"></span> Not item were found !</h3>

    @else

        {!! $skills->links() !!}
        <div class="uk-overflow-auto">

            <table class="uk-table uk-table-hover uk-table-striped uk-table-middle">

                <thead>
                    <tr class="head-table">
                        <th class="uk-text-success uk-text-center">
							<span uk-icon="icon:thumbnails; ratio:1"></span>
						</th>
                        <th class="uk-text-success uk-text-center">Illustration</th>
                        <th class="uk-text-success uk-text-center">Name en</th>
                        <th class="uk-text-success uk-text-center">Name fr</th>
                        <th class="uk-text-success uk-text-center">Operation</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($skills as $skill)

                    <tr class="uk-text-center">

                        <td>{!! $loop->iteration !!}</td>

                        <td>
                            @if($skill->image)
                                <img src="{{ asset('storage/'.$skill->image) }}" width="100"/>
                            @else
                                <span uk-icon="icon: image; ratio:2"></span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.skills.show', [$skill->id]) }}" uk-tooltip="Voir tous les détails">
                                {{ ucfirst($skill->name_en) }}
                            </a>
                        </td>

                        <td>{{ ucfirst($skill->name_fr) }}</td>

                        <td>

                            @component('components.update-buttons', [
                               'id' => $skill->id,
                               'edit_route' => 'admin.skills.edit',
                               'destroy_route' => 'admin.skills.destroy',
                               'name' => 'skill',
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

        {!! $skills->links() !!}

    @endif

@endsection
