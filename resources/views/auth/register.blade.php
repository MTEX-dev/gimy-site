@extends('layouts.auth')

@section('title', __('auth.register_title'))

@section('auth-content')
    <h2 class="text-2xl font-bold text-center text-gray-200">{{ __('auth.register_title') }}</h2>
    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
        @csrf

        <div>
            <label for="username" class="block text-sm font-medium text-gray-400">{{ __('auth.username_label') }}</label>
            <input id="username" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="block w-full px-3 py-2 mt-1 text-gray-200 placeholder-gray-500 bg-gray-700 border border-gray-600 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
            @error('username')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-400">{{ __('auth.email_label') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="block w-full px-3 py-2 mt-1 text-gray-200 placeholder-gray-500 bg-gray-700 border border-gray-600 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror">
            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-400">{{ __('auth.password_label') }}</label>
            <input id="password" type="password" name="password" required
                   class="block w-full px-3 py-2 mt-1 text-gray-200 placeholder-gray-500 bg-gray-700 border border-gray-600 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-500 @enderror">
            @error('password')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password-confirm" class="block text-sm font-medium text-gray-400">{{ __('auth.confirm_password_label') }}</label>
            <input id="password-confirm" type="password" name="password_confirmation" required
                   class="block w-full px-3 py-2 mt-1 text-gray-200 placeholder-gray-500 bg-gray-700 border border-gray-600 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <div>
            <button type="submit"
                    class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('auth.register_button') }}
            </button>
        </div>
    </form>
    <p class="mt-8 text-sm text-center text-gray-400">
        {{ __('auth.already_have_account') }}
        <a href="{{ route('login') }}" class="font-medium text-indigo-400 hover:text-indigo-300">{{ __('auth.login_now') }}</a>
    </p>
@endsection