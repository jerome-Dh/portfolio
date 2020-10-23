{{-- Create a experience_technologie --}}

@extends('layouts.admin')

@section('title', 'Save a experience technologie')

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:file-edit; ratio:1.7"></span>
            New Experience technologie
        </h3>

        @component('admin.experience_technologies.form_create', [
            'url' => route('admin.experience_technologies.store'),
            'type' => 0,

            'experiences' => $experiences,
            'technologies' => $technologies,
        ])

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
