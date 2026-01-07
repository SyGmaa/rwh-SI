@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="section-body">
    <h2 class="section-title">{{ __('Profile') }}</h2>
    <p class="section-lead">Manage your account settings and security.</p>

    <div class="row">
        <div class="col-12">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            <div class="card">
                <div class="card-body">
                    @livewire('profile.update-profile-information-form')
                </div>
            </div>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="card mt-4">
                <div class="card-body">
                    @livewire('profile.update-password-form')
                </div>
            </div>
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="card mt-4">
                <div class="card-body">
                    @livewire('profile.two-factor-authentication-form')
                </div>
            </div>
            @endif

            <div class="card mt-4">
                <div class="card-body">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <div class="card mt-4 border-danger">
                <div class="card-body">
                    @livewire('profile.delete-user-form')
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection