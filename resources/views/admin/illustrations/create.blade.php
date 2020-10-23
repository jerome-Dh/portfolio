{{-- Create a illustration --}}

@extends('layouts.admin')

@section('title', 'Save a illustration')

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:file-edit; ratio:1.7"></span>
            New Illustration
        </h3>

        @component('admin.illustrations.form_create', [
            'url' => route('admin.illustrations.store'),
            'type' => 0,

            'experiences' => $experiences,
        ])

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
