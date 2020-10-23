{{-- Create a module_skill --}}

@extends('layouts.admin')

@section('title', 'Save a module skill')

@section('contenu')

        <div class="uk-card uk-card-default uk-card-large uk-card-body">

            <h3 class="uk-card-title uk-text-primary">
                <span uk-icon="icon:file-edit; ratio:1.7"></span>
                New Module skill
            </h3>

            @component('admin.module_skills.form_create', [
                'url' => route('admin.module_skills.store'),
                'type' => 0,

                'modules' => $modules,
                'skills' => $skills,
            ])

                <strong>Oop's!</strong> Reload this page please !

            @endcomponent

        </div>

@endsection
