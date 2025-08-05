@extends('layouts.app') @section('title', __('strings.settings.title'))
@section('content')
  <div class="container mx-auto px-4 py-10">
    <header class="mb-8">
      <h1 class="text-3xl font-bold">{{ __('strings.settings.title') }}</h1>
    </header>

    <div class="max-w-2xl mx-auto space-y-8">
      <!-- Locale Settings -->
      <div class="bg-slate-800 rounded-xl shadow-lg p-8">
        <h2 class="text-xl font-bold mb-1">
          {{ __('strings.settings.locale.heading') }}
        </h2>
        <p class="text-slate-400 mb-4">
          {{ __('strings.settings.locale.description') }}
        </p>

        @if (session('status') === 'settings-updated')
          <div
            class="bg-green-500/20 text-green-300 p-3 rounded-lg mb-4 text-sm"
          >
            {{ __('strings.settings.alerts.updated') }}
          </div>
        @endif

        <form
          method="POST"
          action="{{ route('user.settings.update') }}"
          class="space-y-4"
        >
          @csrf @method('PATCH')
          <div>
            <label for="locale" class="block mb-2 text-sm font-medium">
              {{ __('strings.settings.locale.label') }}
            </label>
            <select
              id="locale"
              name="locale"
              class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2.5 focus:ring-cyan-500 focus:border-cyan-500"
            >
              <option value="en" {{ $user->locale == 'en' ? 'selected' : '' }}>
                English
              </option>
              <option value="de" {{ $user->locale == 'de' ? 'selected' : '' }}>
                Deutsch
              </option>
              <option value="fr" {{ $user->locale == 'fr' ? 'selected' : '' }}>
                Français
              </option>
            </select>
          </div>
          <div class="flex justify-end">
            <button
              type="submit"
              class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded-lg"
            >
              {{ __('strings.settings.buttons.save') }}
            </button>
          </div>
        </form>
      </div>

      <!-- Danger Zone -->
      <div class="bg-slate-800 border border-red-500/50 rounded-xl shadow-lg p-8">
        <h2 class="text-xl font-bold text-red-400 mb-1">
          {{ __('strings.settings.danger_zone.heading') }}
        </h2>
        <p class="text-slate-400 mb-4">
          {{ __('strings.settings.danger_zone.delete_warning') }}
        </p>
        <form
          method="POST"
          action="{{ route('user.settings.destroy') }}"
          class="space-y-4"
        >
          @csrf @method('DELETE')
          <div>
            <label for="password" class="block mb-2 text-sm font-medium">
              {{ __('strings.settings.danger_zone.password_label') }}
            </label>
            <input
              type="password"
              id="password"
              name="password"
              class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2.5 focus:ring-red-500 focus:border-red-500"
              required
            />
            @error('password')
              <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-end">
            <button
              type="submit"
              class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg"
            >
              {{ __('strings.settings.danger_zone.delete_account') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
