
{{-- Page Showing --}}

@extends('layouts.admin')

@section('title', ucfirst($user->name))

@section('contenu')

    <div class="uk-card uk-card-default uk-card-large uk-card-body">

        <h3 class="uk-card-title">
            <span class="uk-text-primary">{{ ucfirst($user->name) }}</span>
        </h3>

        <hr>

        <div uk-grid>

            <p class="uk-width-1-3@s">
                @if($user->image)
                    <img src="{{ asset('storage/'.$user->image) }}" width="100%" alt="logo"/>
                @else
                    <span uk-icon="icon: image; ratio:8"></span>
                @endif
            </p>

            <div class="uk-width-2-3@s">

                <p>
                    <strong>Name</strong> : {{ ucfirst($user->name) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Email</strong> : {{ strtolower($user->email) }}
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Password</strong> :
                </p>

                <hr class="uk-divider-small">
                <p>
                    <strong>Role</strong> : {{ array_search($user->role, config('custum.user_role')) }}
                </p>

                <hr class="uk-divider-small">

                <div class="uk-text-right">
                    @component('components.update-buttons', [
                        'id' => $user->id,
                        'edit_route' => 'admin.users.edit',
                        'destroy_route' => 'admin.users.destroy',
                        'name' => 'user',
                        'buttons' => true,
                        'back_button' => false,
                        'others' => '',
                    ])
                    @endcomponent
                </div>

            </div>

        </div>

    </div>

@endsection
