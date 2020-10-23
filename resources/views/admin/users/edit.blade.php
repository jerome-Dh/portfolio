
{{-- Edit form --}}

@extends('layouts.admin')

@section('title', 'Update of '.$user->name)

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:pencil; ratio:1.7"></span>
            Update of {{ ucfirst($user->name) }}
        </h3>

        @component('admin.users.form_create', [
            'url' => route('admin.users.update', $user->id),
            'type' => 1,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,

         ]);

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
