{{-- List --}}
@extends('layouts.admin')

@section('title', 'List of experiences')

@section('contenu')

    <h2>
		<span uk-icon="icon:list; ratio:2"></span>
		List of experiences
	</h2>

	<div class="uk-float-right">
        <a href="{{ route('admin.experiences.create') }}" class="uk-button uk-button-primary"><span uk-icon="icon: plus-circle"></span> Ajouter</a>
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

    @if( ! count($experiences))

        <h3><span uk-icon="icon: warning; ratio:1.5"></span> Not item were found !</h3>

    @else

        {!! $experiences->links() !!}
        <div class="uk-overflow-auto">

            <table class="uk-table uk-table-hover uk-table-striped uk-table-middle">

                <thead>
                    <tr class="head-table">
                        <th class="uk-text-success uk-text-center">
							<span uk-icon="icon:thumbnails; ratio:1"></span>
						</th>
                        <th class="uk-text-success uk-text-center">Illustration</th>
                        <th class="uk-text-success uk-text-center">Year</th>
                        <th class="uk-text-success uk-text-center">Name en</th>
                        <th class="uk-text-success uk-text-center">Operation</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($experiences as $experience)

                    <tr class="uk-text-center">

                        <td>{!! $loop->iteration !!}</td>

                        <td>
                            @if($experience->image)
                                <img src="{{ asset('storage/'.$experience->image) }}" width="100"/>
                            @else
                                <span uk-icon="icon: image; ratio:2"></span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.experiences.show', [$experience->id]) }}" uk-tooltip="Voir tous les détails">
                                {{ ucfirst($experience->year) }}
                            </a>
                        </td>

                        <td>{{ ucfirst($experience->name_en) }}</td>


                        <td>

                            @component('components.update-buttons', [
                               'id' => $experience->id,
                               'edit_route' => 'admin.experiences.edit',
                               'destroy_route' => 'admin.experiences.destroy',
                               'name' => 'experience',
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

        {!! $experiences->links() !!}

    @endif

@endsection
