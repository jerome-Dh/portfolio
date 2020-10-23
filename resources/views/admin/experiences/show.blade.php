
{{-- Page Showing --}}

@extends('layouts.admin')

@section('title', ucfirst($experience->name_en))

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title">
            <span class="uk-text-primary">{{ ucfirst($experience->name_en) }}</span>
        </h3>

        <hr>

        <div uk-grid>

            <p class="uk-width-1-3@s">
                @if($experience->image)
                    <img src="{{ asset('storage/'.$experience->image) }}" width="100%" alt="logo"/>
                @else
                    <span uk-icon="icon: image; ratio:8"></span>
                @endif
            </p>

            <div class="uk-width-2-3@s">

                <p>
                    <strong>Year</strong> : {{ ucfirst($experience->year) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Name en</strong> : {{ ucfirst($experience->name_en) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Name fr</strong> : {{ ucfirst($experience->name_fr) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Description en</strong> : {{ ucfirst($experience->description_en) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Description fr</strong> : {{ ucfirst($experience->description_fr) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Source</strong> :
                    @if($experience->source)
                        <a href="{{ ($experience->source) }}" target="_blank">{{ $experience->source }}</a>
                    @endif
                </p>

                <hr class="uk-divider-small">

                <div class="uk-text-right">
                    @component('components.update-buttons', [
                        'id' => $experience->id,
                        'edit_route' => 'admin.experiences.edit',
                        'destroy_route' => 'admin.experiences.destroy',
                        'name' => 'experience',
                        'buttons' => true,
                        'back_button' => false,
                        'others' => '',
                    ])
                    @endcomponent
                </div>

            </div>

        </div>

    </div>

@endsection
