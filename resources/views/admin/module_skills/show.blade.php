
{{-- Page Showing --}}

@extends('layouts.admin')

@section('title', ucfirst($module_skill->module_id))

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title">
            <span class="uk-text-primary">{{ ucfirst($module_skill->module_id) }}</span>
        </h3>

        <hr>

        <div uk-grid>

            <p class="uk-width-1-3@s">
                @if($module_skill->image)
                    <img src="{{ asset('storage/'.$module_skill->image) }}" width="100%" alt="logo"/>
                @else
                    <span uk-icon="icon: image; ratio:8"></span>
                @endif
            </p>

            <div class="uk-width-2-3@s">

                <p>
                    <strong>Module</strong> :
                    @if($module_skill->module)
                        <a href="{{ route('admin.modules.show', [$module_skill->module->id])}}" uk-tooltip="Voir cet élément">
                            {{ ucfirst($module_skill->module->name_en) }}
                        </a>
                    @endif
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Skill</strong> :
                    @if($module_skill->skill)
                        <a href="{{ route('admin.skills.show', [$module_skill->skill->id])}}" uk-tooltip="Voir cet élément">
                            {{ ucfirst($module_skill->skill->name_en) }}
                        </a>
                    @endif
                </p>

                <hr class="uk-divider-small">

                <div class="uk-text-right">
                    @component('components.update-buttons', [
                        'id' => $module_skill->id,
                        'edit_route' => 'admin.module_skills.edit',
                        'destroy_route' => 'admin.module_skills.destroy',
                        'name' => 'module_skill',
                        'buttons' => true,
                        'back_button' => false,
                        'others' => '',
                    ])
                    @endcomponent
                </div>

            </div>

        </div>

    </div>

@endsection
