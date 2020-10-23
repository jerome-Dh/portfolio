
{{-- Page Showing --}}

@extends('layouts.admin')

@section('title', ucfirst($experience_technologie->experience_id))

@section('contenu')

    <div uk-grid>

        <div class="uk-width-1-1@s">

            <div class="uk-card uk-card-default uk-card-large uk-card-body">

                <h3 class="uk-card-title">
					<span class="uk-text-primary">{{ ucfirst($experience_technologie->experience_id) }}</span>
				</h3>

                <hr>

                <div uk-grid>

                    <p class="uk-width-1-3@s">
                        @if($experience_technologie->image)
                            <img src="{{ asset('storage/'.$experience_technologie->image) }}" width="100%" alt="logo"/>
                        @else
                            <span uk-icon="icon: image; ratio:8"></span>
                        @endif
                    </p>

                    <div class="uk-width-2-3@s">

                        <p>
                            <strong>Experience</strong> :
                            @if($experience_technologie->experience)
                                <a href="{{ route('admin.experiences.show', [$experience_technologie->experience->id])}}" uk-tooltip="Voir cet élément">
                                    {{ ucfirst($experience_technologie->experience->name_en).' - '.$experience_technologie->experience->year }}
                                </a>
                            @endif
                        </p>

                        <hr class="uk-divider-small">
                        <p>
                            <strong>Technologie</strong> :
                            @if($experience_technologie->technologie)
                                <a href="{{ route('admin.technologies.show', [$experience_technologie->technologie->id])}}" uk-tooltip="Voir cet élément">
                                    {{ ucfirst($experience_technologie->technologie->name_en) }}
                                </a>
                            @endif
                        </p>

                        <hr class="uk-divider-small">

						<div class="uk-text-right">
							@component('components.update-buttons', [
								'id' => $experience_technologie->id,
								'edit_route' => 'admin.experience_technologies.edit',
								'destroy_route' => 'admin.experience_technologies.destroy',
								'name' => 'experience_technologie',
								'buttons' => true,
								'back_button' => false,
								'others' => '',
							])
							@endcomponent
						</div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
