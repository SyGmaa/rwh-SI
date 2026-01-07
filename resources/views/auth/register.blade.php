@extends('layouts.guest')
@section('content')
<div class="row">
    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Register</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                            required>
                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="password" class="d-block">Password</label>
                            <input id="password" type="password" class="form-control pwstrength"
                                data-indicator="pwindicator" name="password" required>
                            <div id="pwindicator" class="pwindicator">
                                <div class="bar"></div>
                                <div class="label"></div>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="password_confirmation" class="d-block">Password Confirmation</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="terms" class="custom-control-input" id="terms" required>
                            <label class="custom-control-label" for="terms">I agree with the terms and
                                conditions</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            Register
                        </button>
                    </div>
                </form>
            </div>
            <div class="mb-4 text-muted text-center">
                Already Registered? <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
