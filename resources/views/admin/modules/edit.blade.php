
{{-- Edit form --}}

@extends('layouts.admin')

@section('title', 'Update of '.$module->name_en)

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:pencil; ratio:1.7"></span>
            Update of {{ ucfirst($module->name_en) }}
        </h3>

        @component('admin.modules.form_create', [
            'url' => route('admin.modules.update', $module->id),
            'type' => 1,
            'name_en' => $module->name_en,
            'name_fr' => $module->name_fr,
            'leved' => $module->leved,
            'image' => $module->image,

         ]);

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
