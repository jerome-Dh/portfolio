@php
    $about_url = url('/'.(app()->getLocale()));
    $skills_url = url('/'.(app()->getLocale()).'/skills');
    $experiencies_url = url('/'.(app()->getLocale()).'/experiencies');
    $others_url = url('/'.(app()->getLocale()).'/others');
    $blog_url = url('/'.(app()->getLocale()).'/blog');
@endphp

<div class="uk-container-expand uk-margin-top"  id="bg-footer">

    <a class="uk-margin-top uk-position-absolute"
       style="right: 0" href="#" title="{{ __('client.up') }}" uk-totop uk-scroll>
        {{ __('client.up') }} </a>

    <div class="uk-margin-auto uk-padding uk-grid-match uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>

        <div class="uk-margin-auto">

            <ul class="uk-list">
                <li>&copy; 2020 - <a href="{!! $about_url !!}">Jerome Dh</a>
                </li>
                <li><a href="{{ env('MY_EMAIL1') }}" target="_blank">
                    <span uk-icon="mail"></span> {{ env('MY_EMAIL1') }}</a></li>

            </ul>

        </div><div class="uk-margin-auto">

            <h5 class="uk-text-muted uk-margin-remove-bottom">{{ __('client.navigation') }}</h5>

            <ul class="uk-list uk-margin-small-top">
                <li>
                    <span class="uk-icon uk-icon-image uk-margin-small-right"
                          style="background-image: url({{ asset('storage/0055-price-tags-2.png') }});"></span>
                    <a href="{!! $experiencies_url !!}">{{ __('client.experiencies') }}</a>
                </li><li>
                    <span class="uk-icon uk-icon-image uk-margin-small-right"
                          style="background-image: url({{ asset('storage/0076-map-1.png') }});"></span>
                    <a href="{!! $experiencies_url !!}#works">{{ __('client.works') }}</a>
                </li><li>
                    <span class="uk-icon uk-icon-image uk-margin-small-right"
                          style="background-image: url({{ asset('storage/0163-mug-1.png') }});"></span>
                    <a href="{!! $skills_url !!}">{{ __('client.skills') }}</a>
                </li><li>
                    <span class="uk-icon uk-icon-image uk-margin-small-right"
                          style="background-image: url({{ asset('storage/0175-briefcase-2.png') }});"></span>
                    <a href="{!! $others_url !!}">{{ __('client.others') }}</a>
                </li><li>
                    <span uk-icon="social" class="uk-margin-small-right"></span>
                    <a href="{!! $blog_url !!}">{{ __('client.blog') }}</a></li>
            </ul>
        </div><div class="uk-margin-auto@m">

            <h5 class="uk-text-muted uk-margin-remove-bottom">{{ __('client.usefull_link') }}</h5>

            <ul class="uk-list uk-margin-small-top">

                <li>
                    {{ __('client.socials') }} &nbsp;
                    <a href="{{ env('MY_LINKEDIN') }}" target="_blank" class="uk-icon-link" uk-icon="linkedin"></a>&nbsp;
                    <a href="{{ env('MY_GITHUB') }}" target="_blank" class="uk-icon-link" uk-icon="github"></a>&nbsp;

                </li><li>
                    {{ __('client.language') }} &nbsp;
                    <select name="change_language">
                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                        <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Francais</option>
                    </select>
                </li>

            </ul>

        </div>

    </div>

</div>

<!-- Modal to select language -->
<div id="change_language" uk-modal>

    <div class="uk-modal-dialog uk-modal-body">

        <button class="uk-modal-close-default" type="button" uk-close></button>

        <h2 class="uk-modal-title">{{ __('client.change_language') }}</h2>

        <p>{{ __('client.change_lang_text') }}</p>

        <ul class="uk-list">

            <li>
                <span class="uk-icon uk-icon-image uk-margin-small-right"
                      style="background-image: url({{ asset('storage/United_Kingdom.png') }});"></span>
                <a title="Engish" href="{{ url('/settings/en?url='.request()->fullUrl()) }}">English</a>
            </li>

            <li>
                <span class="uk-icon uk-icon-image uk-margin-small-right"
                      style="background-image: url({{ asset('storage/France.png') }});"></span>
                <a title="Francais" href="{{ url('/settings/fr?url='.request()->fullUrl()) }}">Francais</a>
            </li>

        </ul>

    </div>

</div>
