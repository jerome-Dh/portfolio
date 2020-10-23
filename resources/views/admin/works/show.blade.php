
{{-- Page Showing --}}

@extends('layouts.admin')

@section('title', ucfirst($work->name_en))

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title">
            <span class="uk-text-primary">{{ ucfirst($work->name_en) }}</span>
        </h3>

        <hr>

        <div uk-grid>

            <p class="uk-width-1-3@s">
                @if($work->image)
                    <img src="{{ asset('storage/'.$work->image) }}" width="100%" alt="logo"/>
                @else
                    <span uk-icon="icon: image; ratio:8"></span>
                @endif
            </p>

            <div class="uk-width-2-3@s">

                <p>
                    <strong>Name en</strong> : {{ ucfirst($work->name_en) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Name fr</strong> : {{ ucfirst($work->name_fr) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Title en</strong> : {{ ucfirst($work->title_en) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Title fr</strong> : {{ ucfirst($work->title_fr) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Description en</strong> : {{ ucfirst($work->description_en) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Description fr</strong> : {{ ucfirst($work->description_fr) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Source</strong> :
                    @if($work->source)
                        <a href="{{ $work->source }}" target="_blank">{{ $work->source }}</a>
                    @endif
                </p>

                <hr class="uk-divider-small">

                <div class="uk-text-right">
                    @component('components.update-buttons', [
                        'id' => $work->id,
                        'edit_route' => 'admin.works.edit',
                        'destroy_route' => 'admin.works.destroy',
                        'name' => 'work',
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
