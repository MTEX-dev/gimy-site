@extends('layouts.app')
@section('content')
    @include('components.navbar')

    <div class="overflow-x-hidden">
        @yield('main-content')
    </div>

    @include('components.footer')

    <!-- Scroll to Top Button -->
    <button
        id="scroll-to-top-btn"
        class="fixed bottom-5 right-5 z-50 hidden h-12 w-12 rounded-full bg-indigo-500 text-white shadow-lg transition-opacity duration-300 hover:bg-indigo-400"
    >
        <i class="bi bi-arrow-up text-2xl"></i>
    </button>
@endsection