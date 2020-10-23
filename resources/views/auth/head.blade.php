<div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-sticky uk-sticky-fixed">

    <div id="nav-entete" class="uk-container uk-container-expand">

        <nav class="uk-navbar">

            <div class="uk-navbar-left">
                <a href="{{ url('/dashboard') }}" class="uk-navbar-item uk-logo">
                    <img src="{!! asset('storage/favicon.png') !!}" width="48" alt="logo"/>
                    &nbsp;{!! config('app.name') !!}
                </a>
            </div>

            <!-- Center -->
            <div class="uk-navbar-center"></div>

            <div class="uk-navbar-right">

                <a uk-navbar-toggle-icon href="#offcanvas-slide" uk-toggle class="uk-navbar-toggle uk-icon uk-navbar-toggle-icon">
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

        <div class="uk-panel tm-nav">

            <ul class="uk-nav uk-nav-default">

                <li>
                    <a href="{!! url('/dashboard') !!}">
                        <img src="{!! asset('storage/favicon.png') !!}" width="60" alt="logo"/>
                        {!! config('app.name') !!} </a>
                </li>

                <li class="uk-nav-divider"></li>

                <li class="uk-active">
                    <a href="{!! url('/dashboard') !!}">
                        <span uk-icon="icon: home; ratio: .9"></span> Accueil</a>
                </li>

            </ul>

            @guest
                <ul class="uk-nav uk-nav-default uk-margin-top">
                    <li>
                        <a href="{{ route('login') }}">
                            <span uk-icon="icon:user; ratio:0.8"></span> &nbsp;{{ __('Connexion') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li>
                            <a href="{{ route('register') }}"><span uk-icon="icon:plus-circle; ratio:0.8"></span> &nbsp;{{ __('Nouveau Compte') }}</a>
                        </li>
                    @endif

                </ul>
            @else
                <ul class="uk-nav uk-nav-default">

                    <li class="uk-active item uk-margin-small-top">
                        {{ Auth::user()->email }}
                    </li>

                    <li class="item">
                        {{ ucfirst(Auth::user()->name) }}
                    </li>

                    <li class="item uk-margin-small-top">
                        Dernière connexion<br/>
                        <span class="uk-text-muted">{!!  (new \Datetime())->format('d-m-Y H:i') !!}</span>
                    </li>

                    <li class="uk-nav-divider"></li>

                    <li class="item">
                        <a class="uk-text-warning" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span uk-icon="icon: sign-out"></span> {{ __('Déconnexion') }}
                        </a>
                    </li>

                </ul>

            @endguest

        </div>

    </div>

</div>


<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
