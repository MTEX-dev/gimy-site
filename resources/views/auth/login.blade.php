@extends('layouts.auth')

@section('title', __('auth.login_title'))

@section('auth-content')
    <h2 class="text-2xl font-bold text-center text-gray-200">{{ __('auth.login_title') }}</h2>
    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-400">{{ __('auth.email_label') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
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

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox"
                       class="w-4 h-4 text-indigo-600 bg-gray-700 border-gray-600 rounded focus:ring-indigo-500">
                <label for="remember_me" class="block ml-2 text-sm text-gray-300">{{ __('auth.remember_me') }}</label>
            </div>

            @if (Route::has('password.request'))
                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-indigo-400 hover:text-indigo-300">{{ __('auth.forgot_password') }}</a>
                </div>
            @endif
        </div>

        <div>
            <button type="submit"
                    class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('auth.login_button') }}
            </button>
        </div>
    </form>
    <p class="mt-8 text-sm text-center text-gray-400">
        {{ __('auth.no_account_yet') }}
        <a href="{{ route('register') }}" class="font-medium text-indigo-400 hover:text-indigo-300">{{ __('auth.register_now') }}</a>
    </p>
@endsection
