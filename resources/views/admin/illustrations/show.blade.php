
{{-- Page Showing --}}

@extends('layouts.admin')

@section('title', ucfirst($illustration->image))

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title">
            <span class="uk-text-primary">{{ ucfirst($illustration->image) }}</span>
        </h3>

        <hr>

        <div uk-grid>

            <p class="uk-width-1-3@s">
                @if($illustration->image)
                    <img src="{{ asset('storage/'.$illustration->image) }}" width="100%" alt="logo"/>
                @else
                    <span uk-icon="icon: image; ratio:8"></span>
                @endif
            </p>

            <div class="uk-width-2-3@s">

                <p>
                    <strong>Experience</strong> :
                    @if($illustration->experience)
                        <a href="{{ route('admin.experiences.show', [$illustration->experience->id])}}" uk-tooltip="View">
                            {{ ucfirst($illustration->experience->name_en).' - '.$illustration->experience->year }}
                        </a>
                    @endif
                </p>

                <hr class="uk-divider-small">

                <div class="uk-text-right">
                    @component('components.update-buttons', [
                        'id' => $illustration->id,
                        'edit_route' => 'admin.illustrations.edit',
                        'destroy_route' => 'admin.illustrations.destroy',
                        'name' => 'illustration',
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
