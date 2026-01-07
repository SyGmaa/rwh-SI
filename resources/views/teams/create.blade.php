@extends('layouts.app')

@section('title', 'Create Team')

@section('content')
<div class="section-body">
    <h2 class="section-title">{{ __('Create Team') }}</h2>
    <p class="section-lead">Create a new team to manage your projects.</p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @livewire('teams.create-team-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection