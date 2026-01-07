@extends('layouts.guest')

@section('content')
<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Verify Email</h4>
            </div>
            <div class="card-body">
                <div class="mb-4 text-sm text-muted">
                    {{ __('Before continuing, could you verify your email address by clicking on the link we just
                    emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success mt-4">
                    {{ __('A new verification link has been sent to the email address you provided in your profile
                    settings.') }}
                </div>
                @endif

                <div class="mt-4 d-flex align-items-center justify-content-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <div class="d-flex align-items-center">
                        <a href="{{ route('profile.show') }}" class="text-small text-muted mr-3">
                            {{ __('Edit Profile') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection