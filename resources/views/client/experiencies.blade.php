@extends('layouts.app')

@section('title', __('client.experiencyTitle'))

@section('metas')
    @parent
    <meta name="author" content="{{ __('client.experiencyAuthor') }}">
    <meta name="description" content="{{ __('client.experiencyDesc') }}">
@endsection

@section('content')

    <div class="uk-margin-top">

        <div class="experience-head uk-padding-small uk-section-muted">

            <div class="uk-grid-item-match" uk-grid>

                <div class="uk-width-auto@s">
                    <h1 class="uk-margin-small-bottom">
                        {{ __('client.experiencies') }}</h1>

                    <span class="uk-text-muted">
                        <img src="{{ asset('storage/0189-tree.png') }}" class="uk-border-circle" width="26"  alt="tree">
                        2014 - {{ __('client.today') }}</span>
                </div>

                <div class="uk-width-expand@s uk-margin-small-top">
                    {{ __('client.experiency_motivation') }}
                </div>
            </div>
        </div>

        <div>

            @foreach($experiencies as $year => $experience)

                <div class="uk-grid uk-section-muted line-deco">

                    <div class="uk-width-auto deco-name uk-text-center uk-padding-remove">
                        <div class="uk-inline">
                            <h2 class="white absolute-center uk-text-bold uk-position-absolute uk-transform-center">
                                {{ $year }}</h2>
                        </div>
                    </div>

                    <div class="uk-width-expand uk-padding-small" uk-slider="center: true">

                        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

                            <ul class="uk-slider-items uk-child-width-1-2@s uk-grid uk-grid-match">

                                @foreach($experience as $exp)

                                    <li>

                                        <div class="uk-card uk-card-default uk-padding-small experience-item">

                                            <div uk-grid>

                                                <div class="uk-width-auto@m uk-text-center">
                                                    <img src="{{ asset('storage/'.$exp->image) }}" class="uk-border-circle logo-client" width="80px" height="80px" alt="client logo">
                                                </div>

                                                <div class="uk-width-expand@m uk-overflow-auto">

                                                    <h3 class="uk-card-title uk-text-center">
                                                        <a class="experience-title" href="#modal-experiency-{{ $exp->id }}" uk-toggle>{{ ucfirst(show($exp->name_en, $exp->name_fr)) }}</a>
                                                        <a class="uk-button uk-button-default view-more" href="#modal-experiency-{{ $exp->id }}" uk-toggle>{{ __('client.view') }}</a>
                                                    </h3>

                                                    <p>{{ ucfirst(show($exp->description_en, $exp->description_fr)) }}</p>

                                                    <div>
                                                        @if($exp->technologies)
                                                            @foreach($exp->technologies as $tecno)
                                                                <img src="{{ asset('storage/'.$tecno->image) }}" title="{{ show($tecno->name_en, $tecno->name_fr) }}" class="uk-border-circle" width="32"  alt="Technology illustration">
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

{{--                                        Show detail in modal--}}
                                        <div id="modal-experiency-{{ $exp->id }}" uk-modal>
                                            <div class="uk-modal-dialog">

                                                <button class="uk-modal-close-default" type="button" uk-close></button>

                                                <div class="uk-modal-header">
                                                    <h2 class="uk-modal-title experience-title">{{ ucfirst(show($exp->name_en, $exp->name_fr)) }}</h2>
                                                </div>

                                                <div class="uk-modal-body" uk-overflow-auto>

                                                    <h4>
                                                        <img src="{{ asset('storage/'.$exp->image) }}" width="80px" height="80px" alt="logo client">
                                                        {{ ucfirst(show($exp->name_en, $exp->name_fr)) }}
                                                    </h4>

                                                    <h4>{{ __('client.description') }}</h4>
                                                    <p>{{ ucfirst(show($exp->description_en, $exp->description_fr)) }}</p>

                                                    <h4>{{ __('client.techno_used') }}</h4>
                                                    <div>
                                                        @if($exp->technologies)
                                                            @foreach($exp->technologies as $tecno)
                                                                <img src="{{ asset('storage/'.$tecno->image) }}" title="{{ show($tecno->name_en, $tecno->name_fr) }}" width="80"  alt="Technology illustration">
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                    <h4>{{ __('client.medias') }}</h4>
                                                    @if($exp->illustrations)
                                                        <div class="uk-child-width-1-3 uk-child-width-1-4@m" uk-grid uk-lightbox="animation: slide">

                                                            @foreach($exp->illustrations as $illus)
                                                            <div>
                                                                <a class="uk-inline" href="{{ asset('storage/'.$illus->image) }}" data-caption="Illustration {!! $loop->iteration !!}">
                                                                    <img src="{{ asset('storage/'.$illus->image) }}" title="" width="120"  alt="Media illustration">
                                                                </a>
                                                            </div>
                                                            @endforeach

                                                        </div>
                                                    @endif

                                                    <h4>{{ __('client.source') }}</h4>
                                                    @if($exp->source)
                                                        <a class="uk-link" target="_blank" href="{{ $exp->source }}">{{ $exp->source }}</a>
                                                    @endif

                                                </div>

                                                <div class="uk-modal-footer uk-text-right">
                                                    <button class="uk-button uk-button-primary uk-modal-close" type="button">{{ __('client.ok') }}</button>
                                                </div>

                                            </div>
                                        </div>


                                    </li>

                                @endforeach

                            </ul>

                            <a class="uk-slidenav-large uk-position-center-left uk-position-small uk-hidden-hover fleche" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                            <a class="uk-slidenav-large uk-position-center-right uk-position-small uk-hidden-hover fleche" href="#" uk-slidenav-next uk-slider-item="next"></a>

                        </div>

                        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    {{-- Show works --}}
    <div id="works" class="uk-margin-large-top works">

        <div class="experience-head uk-padding-small uk-section-muted">

            <div class="uk-grid-item-match" uk-grid>

                <div class="uk-width-auto@s">
                    <h1 class="uk-margin-small-bottom">
                        {{ __('client.works') }}</h1>

                    <span class="uk-text-muted">
                        <img src="{{ asset('storage/0034-library.png') }}" class="uk-border-circle" width="26"  alt="library">
                        {{ __('client.related') }}</span>
                </div>

                <div class="uk-width-expand@s uk-margin-small-top">
                    {{ __('client.works_motivation') }}
                </div>
            </div>
        </div>

        <div class="uk-padding-small uk-section-muted works-list">

            <ul class="uk-child-width-1-2@m uk-child-width-1-3@l uk-grid uk-grid-match">

                @foreach($works as $work)

                    <li class="uk-margin-small-bottom">

                        <div class="uk-card uk-card-default works-item">

                            <div class="uk-card-media-top">
                                <h3 class="uk-text-center uk-margin-top">
                                    <a class="work-title" title="{{ __('client.see_more') }}" href="#modal-works-{{ $work->id }}" uk-toggle>
                                        <img src="{{ asset('storage/'.$work->image) }}" class="uk-border-circle work-logo uk-margin-small-right" width="80px" height="80px" alt="work logo">
                                        {{ show($work->name_en, $work->name_fr) }}
                                    </a>
                                </h3>
                            </div>

                            <div class="uk-card-body uk-section-muted">

                                <p>{{ show($work->description_en, $work->description_fr) }}</p>

                                <p>
                                    <span class="" uk-icon="icon: github-alt"></span>
                                    <a href="{{ $work->source }}" target="_blank">Source</a>
                                    <span class="uk-margin-small-left uk-margin-small-right">|</span>
                                    <a class="uk-link view-more" title="{{ __('client.see_more') }}" href="#modal-works-{{ $work->id }}" uk-toggle>{{ __('client.more') }}</a>
                                </p>
                            </div>
                        </div>

                        {{-- Show detail in modal--}}
                        <div id="modal-works-{{ $work->id }}" uk-modal>

                            <div class="uk-modal-dialog">

                                <button class="uk-modal-close-default" type="button" uk-close></button>

                                <div class="uk-modal-header">
                                    <h2 class="uk-modal-title experience-title">{{ ucfirst(show($work->name_en, $work->name_fr)) }}</h2>
                                </div>

                                <div class="uk-modal-body" uk-overflow-auto>

                                    <h4>
                                        <img src="{{ asset('storage/'.$work->image) }}" width="80px" height="80px" alt="work logo">
                                        {{ ucfirst(show($work->name_en, $work->name_fr)) }}
                                    </h4>

                                    <h4>{{ __('client.title') }}</h4>
                                    <p>{{ show($work->title_en, $work->title_fr) }}</p>

                                    <h4>{{ __('client.description') }}</h4>
                                    <p>{{ ucfirst(show($work->description_en, $work->description_fr)) }}</p>

                                    <h4>{{ __('client.source') }}</h4>
                                    @if($work->source)
                                        <a class="uk-link" target="_blank" href="{{ $work->source }}">{{ $work->source }}</a>
                                    @endif

                                </div>

                                <div class="uk-modal-footer uk-text-right">
                                    <button class="uk-button uk-button-primary uk-modal-close" type="button">{{ __('client.ok') }}</button>
                                </div>

                            </div>

                        </div>

                    </li>

                @endforeach

            </ul>

        </div>

    </div>

@endsection
