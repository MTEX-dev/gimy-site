@extends('layouts.auth')

@section('auth-content')
    <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">
        Log In
    </h1>

    @error('email')
        <div class="mb-4 text-sm font-medium text-center text-red-600">
            {{ $message }}
        </div>
    @enderror

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="email">
                Email
            </label>
            <input
                id="email"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label
                class="block font-medium text-sm text-gray-700"
                for="password"
            >
                Password
            </label>
            <input
                id="password"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                type="password"
                name="password"
                required
            />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="text-indigo-600 border-gray-300 rounded shadow-sm"
                    name="remember"
                />
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a
                class="text-sm text-gray-600 underline hover:text-gray-900"
                href="{{ route('register') }}"
            >
                Need an account?
            </a>

            <button
                type="submit"
                class="inline-flex items-center px-4 py-2 ml-4 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 border border-transparent rounded-md hover:bg-gray-700"
            >
                Log in
            </button>
        </div>
    </form>
@endsection