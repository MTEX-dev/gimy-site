@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>New Deployment for {{ $site->name }}</h1>
                <p>Click the button below to create a new deployment.</p>
                <form action="{{ route('sites.deployments.store', $site) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Deploy</button>
                </form>
            </div>
        </div>
    </div>
@endsection
