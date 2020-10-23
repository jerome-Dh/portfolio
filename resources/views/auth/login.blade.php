@extends('layouts.app')

@section('title', 'Page de connexion')

@section('content')

    <div class="uk-container">

        <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>

            <div class="uk-card-media-left uk-cover-container">
                <img src="{!! asset('storage/logo1.png') !!}" alt="logo" oncontextmenu="return false" uk-cover/>
            </div>

            <div>
                <div class="uk-card-body">
                    <div class="uk-padding">
                        <h2>Connexion</h2>

                        <!-- Zone d'information -->
                        <div id="connexion-info">
							@if ($errors->any())
								<div class="uk-alert uk-alert-danger">
									<ul class="uk-list uk-list-bullet">
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="uk-form-stacked" id="form_connexion">
                            @csrf

                            <div class="uk-margin">
                                <div class="uk-inline">
                                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                                    <input type="email"
                                           class="uk-input uk-width-1-1@s @error('email') uk-form-danger  @enderror"
                                           id="connexion-email"
                                           name="email" value="{{ old('email') }}"
                                           required autocomplete="email"
                                           placeholder="Email ou Login"
                                    >
                                </div>
                            </div>

                            <div class="uk-margin">
                                <div class="uk-inline">
                                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                    <input type="password"
                                           class="uk-input uk-width-1-1@s @error('password') uk-form-danger @enderror"
                                           id="connexion-password"
                                           name="password"
                                           autocomplete="current-password"
                                           placeholder="Mot de passe"
                                           required>
                                </div>
                            </div>

                            <hr class="uk-divider-icon">

                            <div class="uk-float-left">
                                <label>
                                    <input type="checkbox"
                                           class="uk-checkbox"
                                           id="remember"
                                           name="remember"
                                            {{ old('remember') ? 'checked' : '' }}
                                    >
                                    {{ __('Se souvenir de moi') }}
                                </label>
                            </div>

                            <div class="uk-text-right">
                                <button type="submit"  class="uk-button uk-button-primary">
                                    {{ __('Connexion') }}
                                </button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
