
{{-- Edit form --}}

@extends('layouts.admin')

@section('title', 'Update of '.$skill->name_en)

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:pencil; ratio:1.7"></span>
            Update of {{ ucfirst($skill->name_en) }}
        </h3>

        @component('admin.skills.form_create', [
            'url' => route('admin.skills.update', $skill->id),
            'type' => 1,
            'name_en' => $skill->name_en,
            'name_fr' => $skill->name_fr,
            'subname_en' => $skill->subname_en,
            'subname_fr' => $skill->subname_fr,

         ]);

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
