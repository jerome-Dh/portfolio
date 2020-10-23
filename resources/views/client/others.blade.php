@extends('layouts.app')

@section('title', __('client.othersTitle'))

@section('metas')
    @parent
    <meta name="author" content="{{ __('client.othersAuthor') }}">
    <meta name="description" content="{{ __('client.othersDesc') }}">
@endsection

@section('content')

    <!-- Books -->
    <div id="books" class="border-solid-lightgray uk-padding uk-margin-small-top books">

        <h2 class="pancard-title">{{ __('client.books_read') }}</h2>

        <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-text-center" uk-grid uk-lightbox="animation: slide">

            @foreach($books as $book)

                @php
                    $book_name = substr($book, 6, strlen($book) - 10);
                @endphp

                <div>
                    <a class="uk-inline" href="{{ asset($book) }}" title="{{ $book_name }}" data-caption="{{ $book_name }}">
                        <img class="book-cover" src="{{ asset($book) }}" width="260" height="360" alt="{{ $book_name }}">
                    </a>
                </div>

            @endforeach

        </div>

    </div>

    <div class="border-solid-lightgray uk-padding uk-margin-small-top others">

        <div>
            <h3 class="pancard-title">{{ __('client.others_related') }}</h3>
            <span uk-icon="linkedin"></span>
            <a href="{{ env('MY_LINKEDIN') }}" target="_blank" class="uk-link">
                Linkedin
            </a><br>
            <span uk-icon="github-alt"></span>
            <a href="{{ env('MY_GITHUB') }}" target="_blank" class="uk-link">
                Github
            </a>
        </div>

        <div class="uk-margin-top">
            <h3 class="pancard-title">{{ __('client.blog') }}</h3>
            <span uk-icon="users"></span>
            <a href="{{ url('/'.(app()->getLocale()).'/blog') }}">Blog</a>
        </div>

    </div>

@endsection
