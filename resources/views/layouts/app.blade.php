<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @section('metas')
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:site" content="@jeromedh_cm">
        <meta name="twitter:image" content="{!! asset('storage/favicon.png') !!}">

        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Portfolio Jerome Dh">
        <meta property="og:description" content="{{ __("client.og_description") }}">
        <meta property="og:url" content="{!! url('/') !!}">
        <meta property="og:site_name" content="{{ __("Jerome Dh Portfolio") }}">
        <meta property="og:image" content="{!! asset('storage/favicon.png') !!}">
        <meta property="og:image:width" content="200">
        <meta property="og:image:height" content="200">

        <link rel="shortcut icon" href="{!! asset('storage/favicon.png') !!}">
        <link rel="icon" href="{!! asset('storage/favicon.png') !!}" type="image/png" sizes="200x200">
        <link rel="apple-touch-icon" href="{!! asset('storage/favicon.png') !!}">
        <link rel="preload" href="{!! asset('fonts/Beautiful.ttf') !!}" as="font" type="font/truetype" crossorigin>
        <link rel="preload" href="{!! asset('fonts/BLACK.ttf') !!}" as="font" type="font/truetype" crossorigin>
        <link rel="preload" href="{!! asset('fonts/Vegan.ttf') !!}" as="font" type="font/truetype" crossorigin>

        <meta name="author" content="{{ __("Jerome Dh") }}">
        <meta name="description" content="{{ __("client.og_description") }}">
        <link rel="author" href="mailto:{{ env('MY_EMAIL1') }}" />
        <link rel="author" type="text/html" href="{{ url('/') }}" />
	@show

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- The timestamp -->
    <meta name="timestamp" content="{{ time() }}">

    <title>@yield('title') - {!! config('app.name') !!}</title>

    <!-- The stylesheets -->
    @section('styles')
        <link rel="stylesheet" href="{!! asset('css/uikit.min.css') !!}" />
        <link rel="stylesheet" href="{!! asset('css/main.css') !!}" />
    @show

	<script src="{!! asset('js/uikit.min.js') !!}"></script>
	<script src="{!! asset('js/uikit-icons.min.js') !!}"></script>

</head>
<body>

    <!-- Head -->
    <header>
        @section('header')
            @include('client.header')
         @show
    </header>

    <!-- Body -->
    <main class="uk-container uk-container-large">

        @yield('content')

    </main>

    <!-- Footer -->
    <footer>

        @include('footer')

    </footer>

    <!-- The scripts -->
    @section('scripts')
    <script src="{!! asset('js/jquery-3.1.1.min.js') !!}"></script>
    <script src="{!! asset('js/main.js') !!}"></script>
    @show

</body>
</html>
