
{{-- Page Showing --}}

@extends('layouts.admin')

@section('title', ucfirst($technologie->name_en))

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title">
            <span class="uk-text-primary">{{ ucfirst($technologie->name_en) }}</span>
        </h3>

        <hr>

        <div uk-grid>

            <p class="uk-width-1-3@s">
                @if($technologie->image)
                    <img src="{{ asset('storage/'.$technologie->image) }}" width="100%" alt="logo"/>
                @else
                    <span uk-icon="icon: image; ratio:8"></span>
                @endif
            </p>

            <div class="uk-width-2-3@s">

                <p>
                    <strong>Name en</strong> : {{ ucfirst($technologie->name_en) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Name fr</strong> : {{ ucfirst($technologie->name_fr) }}
                </p>

                <hr class="uk-divider-small">

                <div class="uk-text-right">
                    @component('components.update-buttons', [
                        'id' => $technologie->id,
                        'edit_route' => 'admin.technologies.edit',
                        'destroy_route' => 'admin.technologies.destroy',
                        'name' => 'technologie',
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
