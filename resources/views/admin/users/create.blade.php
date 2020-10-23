{{-- Create a user --}}

@extends('layouts.admin')

@section('title', 'Save a user')

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:file-edit; ratio:1.7"></span>
            New User
        </h3>

        @component('admin.users.form_create', [
            'url' => route('admin.users.store'),
            'type' => 0,

        ])

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
