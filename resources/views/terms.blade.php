@extends('layouts.guest')

@section('content')
<div class="row">
    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
        <div class="card card-primary">
            <div class="card-header justify-content-center">
                <h4>Terms of Service</h4>
            </div>
            <div class="card-body">
                <div class="prose">
                    {!! $terms !!}
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ url('/') }}" class="btn btn-outline-primary">Back to Home</a>
            </div>
        </div>
    </div>
</div>
@endsection