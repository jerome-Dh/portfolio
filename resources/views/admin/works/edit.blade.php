
{{-- Edit form --}}

@extends('layouts.admin')

@section('title', 'Update of '.$work->name_en)

@section('contenu')

    <div uk-grid>

        <div class="uk-width-1-1@s">

            <div class="uk-card uk-card-default uk-card-large uk-card-body">

                <h3 class="uk-card-title uk-text-primary">
					<span uk-icon="icon:pencil; ratio:1.7"></span>
					Update of {{ ucfirst($work->name_en) }}
				</h3>

                @component('admin.works.form_create', [
                    'url' => route('admin.works.update', $work->id),
                    'type' => 1,
                    'name_en' => $work->name_en,
                    'name_fr' => $work->name_fr,
                    'title_en' => $work->title_en,
                    'title_fr' => $work->title_fr,
                    'description_en' => $work->description_en,
                    'description_fr' => $work->description_fr,
                    'image' => $work->image,
                    'source' => $work->source,
                    
                 ]);

                    <strong>Oop's!</strong> Reload this page please !

                @endcomponent

            </div>

        </div>

    </div>

@endsection