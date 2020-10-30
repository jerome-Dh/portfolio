@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('metas')
    @parent
    <meta name="author" content="Home">
    <meta name="description" content="Home">
@endsection

@section('contenu')

    <div>

        @include('auth.cpanel')

    </div>

@endsection
