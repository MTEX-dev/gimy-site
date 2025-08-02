@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Sites</h1>
                <a href="{{ route('sites.create') }}" class="btn btn-primary">Create Site</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Domain</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sites as $site)
                            <tr>
                                <td>{{ $site->name }}</td>
                                <td>{{ $site->domain }}</td>
                                <td>
                                    <a href="{{ route('sites.show', $site) }}" class="btn btn-secondary">View</a>
                                    <a href="{{ route('sites.edit', $site) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('sites.destroy', $site) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
