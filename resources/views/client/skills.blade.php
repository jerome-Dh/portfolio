@extends('layouts.app')

@section('title', __('client.skillTitle'))

@section('metas')
    @parent
    <meta name="description" content="{{ __('client.skillDesc') }}">
    <meta name="author" content="{{ __('client.skillAuthor') }}">
@endsection

@section('content')

    <div class="uk-margin-top skills">

        <div class="skill-head uk-padding-small uk-section-muted">

            <div class="uk-grid-item-match" uk-grid>

                <div class="uk-width-auto@s">

                    <h1 class="uk-margin-small-bottom">
                        {{ __('client.skills') }}</h1>

                    <span class="uk-text-muted">
                        <img src="{{ asset('storage/0175-briefcase-2.png') }}" class="uk-border-circle" width="26"  alt="tree">
                        Web, Mobile</span>
                </div>

                <div class="uk-width-expand@s uk-margin-small-top">
                    {{ __('client.skills_motivation') }}
                </div>

            </div>

        </div>

        <div>

            @foreach($skills as $skill)

                <div class="uk-grid uk-section-muted line-deco">

                    <div class="uk-width-auto deco-name uk-text-center uk-padding-remove">

                        <div class="uk-inline">

                            <div class="uk-position-absolute absolute-center uk-transform-center">

                                @switch(strtolower($skill->name_en))

                                    @case('php')
                                        <img src="{{ asset('storage/php1.png') }}" class="uk-border-circle" width="80px" alt="php logo">
                                        @break

                                    @case('java')
                                        <img src="{{ asset('storage/java2.png') }}" class="uk-border-circle" width="80px" alt="java logo">
                                        @break

                                    @case('javascript')
                                        <img src="{{ asset('storage/js3.png') }}" class="uk-border-circle" width="80px" alt="javaScript logo">
                                        @break

                                    @default
                                        <h2 class="white uk-text-bold">
                                            {{ show($skill->name_en, $skill->name_fr) }}</h2>
                                @endswitch

                                <p class="white uk-text-bold">{{ show($skill->subname_en, $skill->subname_fr) }}</p>

                            </div>

                        </div>

                    </div>

                    <div class="uk-width-expand uk-padding-small">

                        <div>

                            <ul class="uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-grid uk-grid-match">

                                @if($skill->modules)

                                    @foreach($skill->modules as $module)

                                    <li>

                                        <div class="skill-item uk-text-center uk-overflow-hidden bg-color-deco-{{ ($loop->iteration % 3) + 1 }}"
                                            title="{{ show($module->name_en, $module->name_fr).' - '. __('client.average').' '.$module->leved.'/5' }}">

                                            @if($module->image)
                                                <img src="{{ asset('storage/'.$module->image) }}" class="uk-border-circle work-logo" width="48px" height="48px" alt="skill logo">
                                                <br>
                                            @endif

                                            <span class="module-name uk-text-bold white uk-text-large">{{ show($module->name_en, $module->name_fr) }}</span><br>

                                            <!-- Progress bar -->
                                            <progress id="js-progressbar-{{ $module->id }}" class="uk-progress" value="{{ $module->leved }}" max="5"></progress>
{{--                                            <script>--}}
{{--                                                UIkit.util.ready(function () {--}}
{{--                                                    let bar_{{ $module->id }} = document.getElementById('js-progressbar-{{ $module->id }}');--}}
{{--                                                    let animate_{{ $module->id }} = setInterval(function () {--}}
{{--                                                        bar_{{ $module->id }}.value += 1;--}}
{{--                                                        if (bar_{{ $module->id }}.value >= bar_{{ $module->id }}.max) {--}}
{{--                                                            clearInterval(animate_{{ $module->id }});--}}
{{--                                                        }--}}
{{--                                                    }, 10);--}}
{{--                                                });--}}
{{--                                            </script>--}}

                                        </div>

                                    </li>



                                    @endforeach

                                @endif

                            </ul>

                        </div>

                    </div>
                </div>

            @endforeach

        </div>

    </div>

@endsection
