@extends('layouts.app')

@section('title', 'API Tokens')

@section('content')
<div class="section-body">
    <h2 class="section-title">{{ __('API Tokens') }}</h2>
    <p class="section-lead">Manage your API tokens for secure access.</p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @livewire('api.api-token-manager')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection