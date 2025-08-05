@extends('layouts.app') @section('title', __('strings.app.name'))
@section('content')
  <div class="container mx-auto px-4 py-24 text-center">
    <h1
      class="text-5xl md:text-7xl font-extrabold leading-tight mb-4 bg-gradient-to-r from-cyan-400 to-purple-500 text-transparent bg-clip-text"
    >
      Create and publish your website in seconds.
    </h1>
    <p class="text-xl text-slate-300 max-w-2xl mx-auto mb-8">
      No code, no hassle. Just your ideas, live on the web.
    </p>
    <a
      href="{{ route('register') }}"
      class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-8 rounded-lg text-lg"
    >
      Get Started Now
    </a>
  </div>
@endsection
