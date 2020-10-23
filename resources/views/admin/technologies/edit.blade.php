
{{-- Edit form --}}

@extends('layouts.admin')

@section('title', 'Update of '.$technologie->name_en)

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:pencil; ratio:1.7"></span>
            Update of {{ ucfirst($technologie->name_en) }}
        </h3>

        @component('admin.technologies.form_create', [
            'url' => route('admin.technologies.update', $technologie->id),
            'type' => 1,
            'name_en' => $technologie->name_en,
            'name_fr' => $technologie->name_fr,
            'image' => $technologie->image,

         ]);

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
