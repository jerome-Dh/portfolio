
{{-- Edit form --}}

@extends('layouts.admin')

@section('title', 'Update of '.$experience->year)

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:pencil; ratio:1.7"></span>
            Update of {{ ucfirst($experience->year) }}
        </h3>

        @component('admin.experiences.form_create', [
            'url' => route('admin.experiences.update', $experience->id),
            'type' => 1,
            'year' => $experience->year,
            'name_en' => $experience->name_en,
            'name_fr' => $experience->name_fr,
            'description_en' => $experience->description_en,
            'description_fr' => $experience->description_fr,
            'image' => $experience->image,
            'source' => $experience->source,

         ]);

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
