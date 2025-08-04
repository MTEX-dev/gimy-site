<div class="bg-gray-900 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-x-12 gap-y-16 lg:grid-cols-2">
            <div class="fade-in-up">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Write Code with Clarity
                </h2>
                <p class="mt-4 text-lg text-gray-400">
                    Our built-in editor supports syntax highlighting for HTML, CSS, and
                    JavaScript, making it easier to read, write, and manage your code
                    directly in the browser.
                </p>
            </div>

            <div x-data="codeDisplay" class="relative min-h-[32rem] rounded-2xl shadow-2xl zoom-in">
                <!-- Tabs -->
                <div
                    class="absolute left-0 right-0 top-0 z-10 flex rounded-t-2xl bg-gray-800/60 p-2 backdrop-blur-sm"
                >
                    <button
                        @click="tab = 'html'"
                        :class="{'bg-indigo-500 text-white': tab === 'html', 'text-gray-300 hover:bg-gray-700': tab !== 'html'}"
                        class="rounded-md px-4 py-2 text-sm font-medium transition-colors"
                    >
                        HTML
                    </button>
                    <button
                        @click="tab = 'css'"
                        :class="{'bg-indigo-500 text-white': tab === 'css', 'text-gray-300 hover:bg-gray-700': tab !== 'css'}"
                        class="ml-2 rounded-md px-4 py-2 text-sm font-medium transition-colors"
                    >
                        CSS
                    </button>
                    <button
                        @click="tab = 'js'"
                        :class="{'bg-indigo-500 text-white': tab === 'js', 'text-gray-300 hover:bg-gray-700': tab !== 'js'}"
                        class="ml-2 rounded-md px-4 py-2 text-sm font-medium transition-colors"
                    >
                        JavaScript
                    </button>
                </div>

                <!-- Code Editors -->
                <div class="absolute inset-0 overflow-hidden rounded-2xl bg-gray-800 pt-14">
                    <div x-show="tab === 'html'" class="h-full" x-cloak>
                        <textarea id="html-editor-display">
&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;My Awesome Gimy Site&lt;/title&gt;
    &lt;link rel="stylesheet" href="style.css"&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div class="container"&gt;
        &lt;h1&gt;Hello Gimy.site!&lt;/h1&gt;
        &lt;p&gt;This is a simple static page.&lt;/p&gt;
        &lt;button id="myButton"&gt;Click Me&lt;/button&gt;
    &lt;/div&gt;
    
    &lt;script src="script.js"&gt;&lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
                        </textarea>
                    </div>
                    <div x-show="tab === 'css'" class="h-full" x-cloak>
                        <textarea id="css-editor-display">
/* Basic Styling for the Gimy.site example */
body {
    font-family: 'Arial', sans-serif;
    background-color: #1a202c; /* Dark background */
    color: #e2e8f0; /* Light text */
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

.container {
    background-color: #2d3748; /* Slightly lighter dark background */
    padding: 2rem;
    border-radius: 0.75rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h1 {
    color: #63b3ed; /* A nice blue heading */
    margin-bottom: 1rem;
}

p {
    margin-bottom: 1.5rem;
}

button {
    background-color: #667eea; /* Purple button */
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #5a67d8; /* Darker purple on hover */
}
                        </textarea>
                    </div>
                    <div x-show="tab === 'js'" class="h-full" x-cloak>
                        <textarea id="js-editor-display">
document.addEventListener('DOMContentLoaded', () => {
    const myButton = document.getElementById('myButton');
    if (myButton) {
        myButton.addEventListener('click', () => {
            alert('Button clicked! Your JavaScript is running on Gimy.site.');
            console.log('User clicked the example button.');
        });
    }
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
            editors: { html: null, css: null, js: null },
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
                editor.setSize('100%', '100%');
                return editor;
            },
        }));
    });
</script>
@endpush