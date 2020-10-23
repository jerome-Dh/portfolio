
{{-- Edit form --}}

@extends('layouts.admin')

@section('title', 'Update of '.$experience_technologie->experience_id)

@section('contenu')

    <div uk-grid>

        <div class="uk-width-1-1@s">

            <div class="uk-card uk-card-default uk-card-large uk-card-body">

                <h3 class="uk-card-title uk-text-primary">
					<span uk-icon="icon:pencil; ratio:1.7"></span>
					Update of {{ ucfirst($experience_technologie->experience_id) }}
				</h3>

                @component('admin.experience_technologies.form_create', [
                    'url' => route('admin.experience_technologies.update', $experience_technologie->id),
                    'type' => 1,
                    'experience_id' => $experience_technologie->experience_id,
                    'technologie_id' => $experience_technologie->technologie_id,
                    
                    'experiences' => $experiences,
                    'technologies' => $technologies,
                 ]);

                    <strong>Oop's!</strong> Reload this page please !

                @endcomponent

            </div>

        </div>

    </div>

@endsection