{{-- List --}}
@extends('layouts.admin')

@section('title', 'List of illustrations')

@section('contenu')

    <h2>
		<span uk-icon="icon:list; ratio:2"></span>
		List of illustrations
	</h2>

	<div class="uk-float-right">
        <a href="{{ route('admin.illustrations.create') }}" class="uk-button uk-button-primary"><span uk-icon="icon: plus-circle"></span> Ajouter</a>
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

    @if( ! count($illustrations))

        <h3><span uk-icon="icon: warning; ratio:1.5"></span> Not item were found !</h3>

    @else

        {!! $illustrations->links() !!}
        <div class="uk-overflow-auto">

            <table class="uk-table uk-table-hover uk-table-striped uk-table-middle">

                <thead>
                    <tr class="head-table">
                        <th class="uk-text-success uk-text-center">
							<span uk-icon="icon:thumbnails; ratio:1"></span>
						</th>
                        <th class="uk-text-success uk-text-center">Illustration</th>
                        <th class="uk-text-success uk-text-center">Experience</th>
                        <th class="uk-text-success uk-text-center">Operation</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($illustrations as $illustration)

                    <tr class="uk-text-center">

                        <td>{!! $loop->iteration !!}</td>

                        <td>
                            @if($illustration->image)
                                <img src="{{ asset('storage/'.$illustration->image) }}" width="100"/>
                            @else
                                <span uk-icon="icon: image; ratio:2"></span>
                            @endif
                        </td>

                        <td>
                            @if($illustration->experience)
                                <a href="{{ route('admin.illustrations.show', [$illustration->id]) }}" uk-tooltip="Voir tous les détails">
                                    {{ ucfirst($illustration->experience->name_en).' - '.$illustration->experience->year }}
                                </a>
                            @endif
                        </td>

                        <td>

                            @component('components.update-buttons', [
                               'id' => $illustration->id,
                               'edit_route' => 'admin.illustrations.edit',
                               'destroy_route' => 'admin.illustrations.destroy',
                               'name' => 'illustration',
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

        {!! $illustrations->links() !!}

    @endif

@endsection
