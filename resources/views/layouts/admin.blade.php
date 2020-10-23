{{-- Admin layout --}}

@extends('layouts.app')

@section('title', __('Personnal space !'))

@section('header')
    @include('auth.head')
@endsection

@section('content')

    <div class="match-height" uk-grid>

        <div class="uk-width-1-4@m">

			<div>

				<div class="menu-admin uk-card uk-card-default uk-card-body">

					<div class="menu-up">

						<nav class="uk-navbar uk-navbar-container uk-margin">
							<div class="uk-navbar-left vert">
								<span uk-icon="grid"></span>
								<span class="uk-margin-small-left">
									{{ __('Menu') }}
									<small class="date">{{ __("Admin") }}</small>
								</span>
							</div>
						</nav>

						@include('auth.menu')

					</div>

				</div>

			</div>
        </div>

        <div class="uk-width-3-4@m">

            @if (session('status'))
                <div class="uk-alert uk-alert-success uk-margin-small-top" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @yield('contenu')

        </div>
    </div>

@endsection
