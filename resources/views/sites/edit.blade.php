@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit Site</h1>
                <form action="{{ route('sites.update', $site) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $site->name }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control">{{ $site->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="domain">Domain</label>
                        <input type="text" name="domain" id="domain" class="form-control" value="{{ $site->domain }}">
                    </div>
                    <div class="form-group">
                        <label for="github_url">Github URL</label>
                        <input type="text" name="github_url" id="github_url" class="form-control" value="{{ $site->github_url }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
