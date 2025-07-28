@extends('layouts.auth')

@section('auth-content')
    <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">
        Create Account
    </h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="name">
                Name
            </label>
            <input
                id="name"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
            />
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

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
            />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
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
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label
                class="block font-medium text-sm text-gray-700"
                for="password_confirmation"
            >
                Confirm Password
            </label>
            <input
                id="password_confirmation"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                type="password"
                name="password_confirmation"
                required
            />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a
                class="text-sm text-gray-600 underline hover:text-gray-900"
                href="{{ route('login') }}"
            >
                Already registered?
            </a>

            <button
                type="submit"
                class="inline-flex items-center px-4 py-2 ml-4 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 border border-transparent rounded-md hover:bg-gray-700"
            >
                Register
            </button>
        </div>
    </form>
@endsection