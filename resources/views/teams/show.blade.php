@extends('layouts.app')

@section('title', 'Team Settings')

@section('content')
<div class="section-body">
    <h2 class="section-title">{{ __('Team Settings') }}</h2>
    <p class="section-lead">Manage your team settings and members.</p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @livewire('teams.update-team-name-form', ['team' => $team])
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    @livewire('teams.team-member-manager', ['team' => $team])
                </div>
            </div>

            @if (Gate::check('delete', $team) && ! $team->personal_team)
            <div class="card mt-4 border-danger">
                <div class="card-body">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection