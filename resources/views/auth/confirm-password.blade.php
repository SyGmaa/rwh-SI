@extends('layouts.guest')

@section('content')
<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Confirm Password</h4>
            </div>
            <div class="card-body">
                <div class="mb-4 text-sm text-muted">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.')
                    }}
                </div>

                @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control" name="password" required
                            autocomplete="current-password" autofocus>
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary btn-lg">
                            {{ __('Confirm') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection