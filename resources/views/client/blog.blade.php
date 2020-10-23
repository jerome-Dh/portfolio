@extends('layouts.app')

@section('title', __('client.blog'))

@section('metas')
    @parent
    <meta name="description" content="{{ __('client.blogDesc') }}">
    <meta name="author" content="{{ __('client.blogAuthor') }}">
@endsection

@section('content')

    <div class="border-solid-lightgray uk-padding uk-margin-small-top">

        <h2 class="pancard-title">{{ __('client.blog') }}</h2>

        <p>Coming soon..</p>

    </div>

@endsection
