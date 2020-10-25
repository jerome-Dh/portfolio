@php
    $about_url = url('/'.(app()->getLocale()));
    $skills_url = url('/'.(app()->getLocale()).'/skills');
    $experiences_url = url('/'.(app()->getLocale()).'/experiences');
    $others_url = url('/'.(app()->getLocale()).'/others');
    $blog_url = url('/'.(app()->getLocale()).'/blog');
@endphp

@extends('layouts.app')

@section('title', __('client.about'))

@section('metas')
    @parent
    <meta name="description" content="{{ __('client.welcome_portfolio') }}">
    <meta name="author" content="{{ __('Jerome Dh') }}">
@endsection

@section('content')

    <div class="uk-section-muted border-solid-lightgray uk-padding uk-margin-small-top">

        <h3 class="pancard-title">{!! __('client.about_h3_1') !!}</h3>
        <p>
            <img src="{{ asset('storage/logo4.png') }}" class="uk-border-circle uk-float-left uk-margin-small uk-margin-small-right" width="90">
            <p class='uk-text-lead uk-dropcap'>{!! __('client.about_p1', [
                    'skills_url' => $skills_url,
                    'works_url' => $experiences_url.'#works',
                    'experiences_url' => $experiences_url]) !!}</p>
        </p>

        <p>{!! __('client.about_p6') !!}</p>

        <h3 class="pancard-title">{!! __('client.about_h3_2') !!}</h3>
        <p>
            {!! __('client.about_p2') !!}
        </p>
        <p>
            {!! __('client.about_p3') !!}
        </p>

        <h3 class="pancard-title">{!! __('client.about_h3_3') !!}</h3>
        <p>{!! __('client.about_p4') !!}</p>
        <ul>
            {!! __('client.about_ul_1', [
                    'skills_url' => $skills_url,
                    'experiences_url' => $experiences_url,
                    'works_url' => $experiences_url.'#works',
                    'books_url' => $others_url.'#books',
                    'blog_url' => $blog_url,
                  ]) !!}
        </ul>
        <p>{!! __('client.about_p5') !!}</p>

        <p class="uk-text-right">{!! __('client.about_em1') !!}</p>

    </div>

@endsection
