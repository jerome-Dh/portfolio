{{-- List --}}
@extends('layouts.admin')

@section('title', 'List of module skills')

@section('contenu')

    <h2>
		<span uk-icon="icon:list; ratio:2"></span>
		List of module skills
	</h2>

	<div class="uk-float-right">
        <a href="{{ route('admin.module_skills.create') }}" class="uk-button uk-button-primary"><span uk-icon="icon: plus-circle"></span> Ajouter</a>
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

    @if( ! count($module_skills))

        <h3><span uk-icon="icon: warning; ratio:1.5"></span> Not item were found !</h3>

    @else

        {!! $module_skills->links() !!}
        <div class="uk-overflow-auto">

            <table class="uk-table uk-table-hover uk-table-striped uk-table-middle">

                <thead>
                    <tr class="head-table">
                        <th class="uk-text-success uk-text-center">
							<span uk-icon="icon:thumbnails; ratio:1"></span>
						</th>
                        <th class="uk-text-success uk-text-center">Illustration</th>
                        <th class="uk-text-success uk-text-center">Module</th>
                        <th class="uk-text-success uk-text-center">Skill</th>
                        <th class="uk-text-success uk-text-center">Operation</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($module_skills as $module_skill)

                    <tr class="uk-text-center">

                        <td>{!! $loop->iteration !!}</td>

                        <td>
                            @if($module_skill->image)
                                <img src="{{ asset('storage/'.$module_skill->image) }}" width="100"/>
                            @else
                                <span uk-icon="icon: image; ratio:2"></span>
                            @endif
                        </td>

                        <td>
                            @if($module_skill->module)
                                <a href="{{ route('admin.module_skills.show', [$module_skill->id]) }}" uk-tooltip="Voir tous les détails">
                                    {{ ucfirst($module_skill->module->name_en) }}
                                </a>
                            @endif
                        </td>

                        <td>
                            @if($module_skill->skill)
                                <a href="{{ route('admin.skills.show', [$module_skill->skill->id])}}" uk-tooltip="Voir cet élément">
                                    {{ ucfirst($module_skill->skill->name_en) }}
                                </a>
                            @endif
                        </td>


                        <td>

                            @component('components.update-buttons', [
                               'id' => $module_skill->id,
                               'edit_route' => 'admin.module_skills.edit',
                               'destroy_route' => 'admin.module_skills.destroy',
                               'name' => 'module_skill',
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

        {!! $module_skills->links() !!}

    @endif

@endsection
