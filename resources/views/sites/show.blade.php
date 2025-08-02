@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $site->name }}</h1>
                <p>{{ $site->description }}</p>
                <p>Domain: {{ $site->domain }}</p>
                <p>Github URL: {{ $site->github_url }}</p>

                <h2>Files</h2>
                <a href="{{ route('sites.files.create', $site) }}" class="btn btn-primary">Add File</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Path</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($site->siteFiles as $file)
                            <tr>
                                <td>{{ $file->path }}</td>
                                <td>
                                    <a href="{{ route('files.edit', $file) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('files.destroy', $file) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h2>Deployments</h2>
                <a href="{{ route('sites.deployments.create', $site) }}" class="btn btn-primary">New Deployment</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Commit Hash</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($site->siteDeployments as $deployment)
                            <tr>
                                <td>{{ $deployment->status }}</td>
                                <td>{{ $deployment->commit_hash }}</td>
                                <td>{{ $deployment->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
