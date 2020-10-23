{{-- Create a technologie --}}

@extends('layouts.admin')

@section('title', 'Save a technologie')

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:file-edit; ratio:1.7"></span>
            New Technologie
        </h3>

        @component('admin.technologies.form_create', [
            'url' => route('admin.technologies.store'),
            'type' => 0,

        ])

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
