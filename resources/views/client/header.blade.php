
@php
    $about_url = url('/'.(app()->getLocale()));
    $skills_url = url('/'.(app()->getLocale()).'/skills');
    $experiencies_url = url('/'.(app()->getLocale()).'/experiencies');
    $others_url = url('/'.(app()->getLocale()).'/others');
    $blog_url = url('/'.(app()->getLocale()).'/blog');
@endphp

<div
     uk-sticky="show-on-up: true; animation: uk-animation-slide-top"
     class="uk-navbar-container tm-navbar-container uk-overflow-hidden"
     id="bg-head">

    <div class="uk-container uk-container-expand">

        <nav class="uk-navbar">

            <div class="uk-navbar-left">

                <div class="uk-margin-left uk-text-center">
                    <a href="{{ url('/') }}" class="">
                        <img src="{!! asset('storage/me_2_2019.jpg') !!}" width="80" height="80" alt="logo" class="uk-border-circle"/>
                    </a><br>
                    <span class="uk-text-small">{{ __('Jerome Dh') }}, Nov 2020</span>
                </div>

                <div class="uk-margin-small-top uk-margin-large-left uk-visible@m">
                    <p class="uk-margin-remove">
                        @component('components.to-languages')
                        @endcomponent
                    </p>
                    <h3 class="uk-h3 uk-text-bold yellow uk-margin-remove">
                        {{ __('client.head_title') }}
                    </h3>
                    <p class="uk-margin-remove">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <circle r="6" cx="6" cy="6" fill="#00ff00"></circle>
                        </svg>
                        <small>{{ __('Active') }}</small>
                    </p>

                    <div class="uk-margin-small-top uk-margin-small-left">
                        <ul class="uk-navbar-nav" id="list-menu-head">
                            <li>
                                <a href="{!! $about_url !!}">
                                    @component('components.menu-item', [
                                        'name' => __('client.about'),
                                        'active' => is_active_link('/')
                                    ])
                                    @endcomponent
                                </a>
                            </li>

                            <li class="uk-margin-small-left">
                                <a href="{!! $experiencies_url !!}">
                                    @component('components.menu-item', [
                                        'name' => __('client.experiencies'),
                                        'active' => is_active_link('experiencies')
                                    ])
                                    @endcomponent
                                </a>
                            </li>
                            <li class="uk-margin-small-left">
                                <a href="{!! $skills_url !!}">
                                    @component('components.menu-item', [
                                        'name' => __('client.skills'),
                                        'active' => is_active_link('skills')
                                    ])
                                    @endcomponent
                                </a>
                            </li>

                            <li class="uk-margin-small-left">
                                <a href="{!! $others_url !!}">
                                    @component('components.menu-item', [
                                        'name' => __('client.others'),
                                        'active' => is_active_link('others')
                                    ])
                                    @endcomponent
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

            <!-- Center -->
            <div class="uk-navbar-center ">

                <p id="head-top-language" class="uk-hidden@m">
                    @component('components.to-languages')
                    @endcomponent
                </p>

            </div>

            <div class="uk-navbar-right">

                <div class="">
                    <a href="{{ env('MY_LINKEDIN') }}" target="_blank" class="uk-icon-link" uk-icon="linkedin"></a>&nbsp;
                    <a href="{{ env('MY_GITHUB') }}" target="_blank" class="uk-icon-link" uk-icon="github"></a>&nbsp;
                    <a href="#" uk-icon="icon:world; ratio:1.2" class="uk-border-rounded icon-world"
                        title="{{ __("Change the language") }}"
                        uk-toggle="target: #change_language">
                        <span class="uk-badge lang">{!! strtoupper(app()->getLocale()) !!}</span>
                    </a> &nbsp;
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li class="uk-active"><a href="#">Active</a></li>

                        </ul>
                    </div>

                    <div class="uk-visible@m" id="design-1">
                        @component('components.design-1')
                        @endcomponent
                    </div>

                    <div class="display-middle">
                        <a uk-navbar-toggle-icon href="#offcanvas-slide" uk-toggle class="uk-navbar-toggle uk-icon uk-navbar-toggle-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="navbar-toggle-icon">
                                <rect y="9" width="20" height="2"></rect>
                                <rect y="3" width="20" height="2"></rect>
                                <rect y="15" width="20" height="2"></rect>
                            </svg>
                        </a>
                    </div>
                </div>

                <a uk-navbar-toggle-icon href="#offcanvas-slide" uk-toggle class="uk-navbar-toggle uk-hidden@m uk-icon uk-navbar-toggle-icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="navbar-toggle-icon">
                        <rect y="9" width="20" height="2"></rect>
                        <rect y="3" width="20" height="2"></rect>
                        <rect y="15" width="20" height="2"></rect>
                    </svg>
                </a>

            </div>

        </nav>

    </div>

</div>

<!-- Small screen -->
<div id="offcanvas-slide" uk-offcanvas="mode: push; overlay: true" class="uk-offcanvas">

    <div class="uk-offcanvas-bar">

        <div class="uk-panel">

            <ul class="uk-nav uk-nav-default">

                <li>
                    <a href="{{ url('/') }}" class="">
                        <img src="{!! asset('storage/favicon.png') !!}" width="80" height="80" alt="logo" class="uk-border-circle"/>
                    </a><br>
                    <span class="uk-text-small">{{ __('Main menu') }}</span>
                </li>

                <li class="uk-nav-divider"></li>

                <li class="{!! is_active_link('/') ? 'uk-active' : '' !!}">
                    <a href="{!! $about_url !!}">
                        <span uk-icon="icon: code; ratio: .9"></span> {{ __('client.about') }}</a>
                </li>
                <li class="{!! is_active_link('experiencies') ? 'uk-active' : '' !!}">
                    <a href="{!! $experiencies_url !!}">
                        <span uk-icon="icon: star; ratio: .9"></span> {{ __('client.experiencies') }}</a>
                </li>
                <li class="{!! is_active_link('skills') ? 'uk-active' : '' !!}">
                    <a href="{!! $skills_url !!}">
                        <span uk-icon="icon: bookmark; ratio: .9"></span> {{ __('client.skills') }}</a>
                </li>
                <li class="{!! is_active_link('others') ? 'uk-active' : '' !!}">
                    <a href="{!! $others_url !!}">
                        <span uk-icon="icon: link; ratio: .9"></span> {{ __('client.others') }}</a>
                </li>
                <li class="{!! is_active_link('blog') ? 'uk-active' : '' !!}">
                    <a href="{!! $blog_url !!}">
                        <span uk-icon="icon: tag; ratio: .9"></span> {{ __('client.blog') }}</a>
                </li>

            </ul>

            <div class="uk-text-center">
                <hr class="uk-divider-icon"/>
                <small class="uk-text-muted">++++ @By {{ __('Jerome Dh') }}, 2020 ++++</small><br>
                <small class="uk-text-muted">++++ Web Artisan ++++</small>
            </div>

        </div>

    </div>

</div>
