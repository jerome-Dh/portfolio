{{-- List --}}
@extends('layouts.admin')

@section('title', 'List of experience technologies')

@section('contenu')

    <h2>
		<span uk-icon="icon:list; ratio:2"></span>
		List of experience technologies
	</h2>

	<div class="uk-float-right">
        <a href="{{ route('admin.experience_technologies.create') }}" class="uk-button uk-button-primary"><span uk-icon="icon: plus-circle"></span> Ajouter</a>
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

    @if( ! count($experience_technologies))

        <h3><span uk-icon="icon: warning; ratio:1.5"></span> Not item were found !</h3>

    @else

        {!! $experience_technologies->links() !!}
        <div class="uk-overflow-auto">

            <table class="uk-table uk-table-hover uk-table-striped uk-table-middle">

                <thead>
                    <tr class="head-table">
                        <th class="uk-text-success uk-text-center">
							<span uk-icon="icon:thumbnails; ratio:1"></span>
						</th>
                        <th class="uk-text-success uk-text-center">Illustration</th>
                        <th class="uk-text-success uk-text-center">Experience</th>
                        <th class="uk-text-success uk-text-center">Technologie</th>
                        <th class="uk-text-success uk-text-center">Operation</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($experience_technologies as $experience_technologie)

                    <tr class="uk-text-center">

                        <td>{!! $loop->iteration !!}</td>

                        <td>
                            @if($experience_technologie->image)
                                <img src="{{ asset('storage/'.$experience_technologie->image) }}" width="100"/>
                            @else
                                <span uk-icon="icon: image; ratio:2"></span>
                            @endif
                        </td>

                        <td>
                            @if($experience_technologie->experience)
                                <a href="{{ route('admin.experience_technologies.show', [$experience_technologie->id]) }}" uk-tooltip="Voir tous les détails">
                                    {{ ucfirst($experience_technologie->experience->name_en).' - '.$experience_technologie->experience->year }}
                                </a>
                            @endif
                        </td>

                        <td>
                            @if($experience_technologie->technologie)
                                <a href="{{ route('admin.technologies.show', [$experience_technologie->technologie->id])}}" uk-tooltip="Voir cet élément">
                                    {{ ucfirst($experience_technologie->technologie->name_en) }}
                                </a>
                            @endif
                        </td>


                        <td>

                            @component('components.update-buttons', [
                               'id' => $experience_technologie->id,
                               'edit_route' => 'admin.experience_technologies.edit',
                               'destroy_route' => 'admin.experience_technologies.destroy',
                               'name' => 'experience_technologie',
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

        {!! $experience_technologies->links() !!}

    @endif

@endsection
