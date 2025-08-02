@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Add File to {{ $site->name }}</h1>
                <form action="{{ route('sites.files.store', $site) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="path">Path</label>
                        <input type="text" name="path" id="path" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" class="form-control" rows="20"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add File</button>
                </form>
            </div>
        </div>
    </div>
@endsection
