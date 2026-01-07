@extends('layouts.guest')
@section('content')
<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Two Factor Autentication</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('two-factor.login') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input id="code" type="text" class="form-control" name="code" tabindex="1" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="recovery_code">Recovery Code (Optional)</label>
                        <input id="recovery_code" type="text" class="form-control" name="recovery_code" tabindex="2">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
