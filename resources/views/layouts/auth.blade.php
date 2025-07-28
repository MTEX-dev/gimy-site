@extends('layouts.main')

@section('main-content')
    <div class="flex flex-col items-center justify-center min-h-screen sm:pt-0">
        <div class="w-full px-6 py-8 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
            @yield('auth-content')
        </div>
    </div>
@endsection