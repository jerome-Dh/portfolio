
{{-- Edit form --}}

@extends('layouts.admin')

@section('title', 'Update of '.$module_skill->module_id)

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:pencil; ratio:1.7"></span>
            Update of {{ ucfirst($module_skill->module_id) }}
        </h3>

        @component('admin.module_skills.form_create', [
            'url' => route('admin.module_skills.update', $module_skill->id),
            'type' => 1,
            'module_id' => $module_skill->module_id,
            'skill_id' => $module_skill->skill_id,

            'modules' => $modules,
            'skills' => $skills,
         ]);

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
