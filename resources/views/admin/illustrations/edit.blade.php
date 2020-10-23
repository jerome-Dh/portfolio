
{{-- Edit form --}}

@extends('layouts.admin')

@section('title', 'Update of '.$illustration->image)

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title uk-text-primary">
            <span uk-icon="icon:pencil; ratio:1.7"></span>
            Update of {{ ucfirst($illustration->image) }}
        </h3>

        @component('admin.illustrations.form_create', [
            'url' => route('admin.illustrations.update', $illustration->id),
            'type' => 1,
            'image' => $illustration->image,
            'experience_id' => $illustration->experience_id,

            'experiences' => $experiences,
         ]);

            <strong>Oop's!</strong> Reload this page please !

        @endcomponent

    </div>

@endsection
