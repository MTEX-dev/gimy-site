{{-- resources/views/pages/home/_feedback-form.blade.php --}}
<div class="py-24 sm:py-32">
    <div class="mx-auto max-w-4xl px-6 lg:px-8">
        <div class="relative isolate overflow-hidden bg-gray-800/40 ring-1 ring-white/10 rounded-3xl px-6 py-20 text-center shadow-2xl sm:px-16 zoom-in">
            <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('home.feedback.title') }}</h2>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">{{ __('home.feedback.subtitle') }}</p>
            
            @if (session('feedback_success'))
                <div class="mt-8 mx-auto max-w-xl">
                    <div class="rounded-md bg-green-500/10 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-check-circle-fill text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-300">{{ session('feedback_success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <form action="{{ route('feedback.submit') }}" method="POST" class="mx-auto mt-8 max-w-xl">
                    @csrf
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-semibold leading-6 text-white text-left">{{ __('home.feedback.email_label') }}</label>
                            <div class="mt-2.5">
                                <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md border-0 bg-white/5 py-2 px-3.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message_type" class="block text-sm font-semibold leading-6 text-white text-left">{{ __('home.feedback.type_label') }}</label>
                            <div class="mt-2.5">
                                <select name="message_type" id="message_type" class="block w-full rounded-md border-0 bg-white/5 py-2 px-3.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                    <option value="feedback">{{ __('home.feedback.type_feedback') }}</option>
                                    <option value="suggestion">{{ __('home.feedback.type_suggestion') }}</option>
                                    <option value="bug">{{ __('home.feedback.type_bug') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-semibold leading-6 text-white text-left">{{ __('home.feedback.message_label') }}</label>
                            <div class="mt-2.5">
                                <textarea name="message" id="message" rows="4" required class="block w-full rounded-md border-0 bg-white/5 py-2 px-3.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">{{ __('home.feedback.submit_btn') }}</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
