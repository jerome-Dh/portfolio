{{-- List --}}
@extends('layouts.admin')

@section('title', 'List of works')

@section('contenu')

    <h2>
		<span uk-icon="icon:list; ratio:2"></span>
		List of works
	</h2>

	<div class="uk-float-right">
        <a href="{{ route('admin.works.create') }}" class="uk-button uk-button-primary"><span uk-icon="icon: plus-circle"></span> Ajouter</a>
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

    @if( ! count($works))

        <h3><span uk-icon="icon: warning; ratio:1.5"></span> Not item were found !</h3>

    @else

        {!! $works->links() !!}
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
                @foreach($works as $work)

                    <tr class="uk-text-center">

                        <td>{!! $loop->iteration !!}</td>

                        <td>
                            @if($work->image)
                                <img src="{{ asset('storage/'.$work->image) }}" width="100"/>
                            @else
                                <span uk-icon="icon: image; ratio:2"></span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.works.show', [$work->id]) }}" uk-tooltip="Voir tous les détails">
                                {{ ucfirst($work->name_en) }}
                            </a>
                        </td>

                        <td>{{ ucfirst($work->name_fr) }}</td>

                        <td>

                            @component('components.update-buttons', [
                               'id' => $work->id,
                               'edit_route' => 'admin.works.edit',
                               'destroy_route' => 'admin.works.destroy',
                               'name' => 'work',
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

        {!! $works->links() !!}

    @endif

@endsection
