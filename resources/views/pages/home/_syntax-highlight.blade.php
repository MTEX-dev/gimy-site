<div class="bg-gray-900 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-x-12 gap-y-16 lg:grid-cols-2">
            <div class="fade-in-up">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    {{ __('home.syntax_highlight.title') }}
                </h2>
                <p class="mt-4 text-lg text-gray-400">
                    {{ __('home.syntax_highlight.subtitle') }}
                </p>
            </div>

            <div x-data="codeDisplay" class="relative min-h-[32rem] rounded-2xl shadow-2xl zoom-in">
                <div class="absolute top-0 left-0 right-0 z-10 flex p-2 bg-gray-800/60 backdrop-blur-sm rounded-t-2xl">
                    <button @click="tab = 'html'"
                        :class="{'bg-indigo-500 text-white': tab === 'html', 'text-gray-300 hover:bg-gray-700': tab !== 'html'}"
                        class="px-4 py-2 text-sm font-medium rounded-md transition-colors">
                        HTML
                    </button>
                    <button @click="tab = 'css'"
                        :class="{'bg-indigo-500 text-white': tab === 'css', 'text-gray-300 hover:bg-gray-700': tab !== 'css'}"
                        class="ml-2 px-4 py-2 text-sm font-medium rounded-md transition-colors">
                        CSS
                    </button>
                    <button @click="tab = 'js'"
                        :class="{'bg-indigo-500 text-white': tab === 'js', 'text-gray-300 hover:bg-gray-700': tab !== 'js'}"
                        class="ml-2 px-4 py-2 text-sm font-medium rounded-md transition-colors">
                        JavaScript
                    </button>
                </div>

                <div class="absolute inset-0 pt-14 bg-gray-800 rounded-2xl overflow-hidden">
                    <div x-show="tab === 'html'" class="h-full" x-cloak>
                        <textarea id="html-editor-display">
&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;Gimy.site&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div class="card"&gt;
        &lt;h2&gt;Feature-Rich Editor&lt;/h2&gt;
        &lt;p&gt;Edit HTML, CSS, and JS with syntax highlighting.&lt;/p&gt;
        &lt;button id="my-button"&gt;Click Me&lt;/button&gt;
    &lt;/div&gt;
&lt;/body&gt;
&lt;/html&gt;
                        </textarea>
                    </div>
                    <div x-show="tab === 'css'" class="h-full" x-cloak>
                        <textarea id="css-editor-display">
body {
    font-family: sans-serif;
    background-color: #111827;
    color: #e5e7eb;
    margin: 0;
    padding: 2rem;
}

.card {
    background: #1f2937;
    padding: 2rem;
    border-radius: 0.75rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
    text-align: center;
    max-width: 400px;
    margin: 0 auto;
}

.card h2 {
    margin-top: 0;
    color: #6366f1;
}

button {
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    background-color: #4f46e5;
    color: white;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #6366f1;
}
                        </textarea>
                    </div>
                    <div x-show="tab === 'js'" class="h-full" x-cloak>
                        <textarea id="js-editor-display">
document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('my-button');
    button.addEventListener('click', () => {
        alert('Button clicked!');
    });
});
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('codeDisplay', () => ({
            tab: 'html',
            editors: {
                html: null,
                css: null,
                js: null
            },
            init() {
                this.editors.html = this.createEditor('html-editor-display', 'htmlmixed');
                this.editors.css = this.createEditor('css-editor-display', 'css');
                this.editors.js = this.createEditor('js-editor-display', 'javascript');

                this.$watch('tab', (newTab) => {
                    this.$nextTick(() => {
                        if (this.editors[newTab]) {
                            this.editors[newTab].refresh();
                        }
                    });
                });

                this.$nextTick(() => {
                    if (this.editors.html) {
                        this.editors.html.refresh();
                    }
                });
            },
            createEditor(id, mode) {
                const textarea = document.getElementById(id);
                if (!textarea) return null;
                const editor = CodeMirror.fromTextArea(textarea, {
                    lineNumbers: true,
                    mode: mode,
                    theme: 'dracula',
                    readOnly: true,
                    lineWrapping: true,
                });
                editor.setSize("100%", "100%");
                return editor;
            }
        }));
    });
</script>
@endpush