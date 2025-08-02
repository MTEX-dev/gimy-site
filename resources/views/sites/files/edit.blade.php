@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit File: {{ $file->path }}</h1>
                <form action="{{ route('files.update', $file) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" class="form-control" rows="20">{{ $file->content }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update File</button>
                </form>
            </div>
        </div>
    </div>
@endsection
