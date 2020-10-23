
@extends('layouts.app')

@section('title', 'Page not found !')

@section('content')

    <h1 class="uk-text-center uk-text-danger">
	<span uk-icon="icon: warning; ratio: 1.7"></span>
	Not found !</h1>

	<div uk-grid>

		<div class="uk-width-1-1@s">
			<div class="uk-card uk-card-default uk-card-large uk-card-body uk-text-center">

				<h3>
				<span uk-icon="icon: link; ratio: 1.5"></span>
				You are already to {!! config('app.name') !!}</h3>
				<p class="uk-text-lead">The page you searched doesn't found !</p>
				<p>Its olded or deleted, please refer other link.</p>

			</div>
		</div>

	</div>

@endsection
