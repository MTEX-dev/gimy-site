<div class="bg-gray-900 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-x-12 gap-y-16 lg:grid-cols-2">
            <div class="fade-in-up">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Write Code with Clarity
                </h2>
                <p class="mt-4 text-lg text-gray-400">
                    Our built-in editor supports syntax highlighting for HTML, CSS, and JavaScript, making it easier to read, write, and manage your code directly in the browser.
                </p>
            </div>

            <div x-data="codeDisplay" class="relative min-h-[32rem] rounded-2xl shadow-2xl zoom-in">
                <!-- Tabs -->
                <div class="absolute top-0 left-0 right-0 z-10 flex p-2 bg-gray-800/60 backdrop-blur-sm rounded-t-2xl">
                    <button @click="tab = 'html'" :class="{'bg-indigo-500 text-white': tab === 'html', 'text-gray-300 hover:bg-gray-700': tab !== 'html'}" class="px-4 py-2 text-sm font-medium rounded-md transition-colors">
                        HTML
                    </button>
                    <button @click="tab = 'css'" :class="{'bg-indigo-500 text-white': tab === 'css', 'text-gray-300 hover:bg-gray-700': tab !== 'css'}" class="ml-2 px-4 py-2 text-sm font-medium rounded-md transition-colors">
                        CSS
                    </button>
                    <button @click="tab = 'js'" :class="{'bg-indigo-500 text-white': tab === 'js', 'text-gray-300 hover:bg-gray-700': tab !== 'js'}" class="ml-2 px-4 py-2 text-sm font-medium rounded-md transition-colors">
                        JavaScript
                    </button>
                </div>

                <!-- Code Editors -->
                <div class="absolute inset-0 pt-14 bg-gray-800 rounded-2xl overflow-hidden">
                    <div x-show="tab === 'html'" class="h-full" x-cloak>
                        <textarea id="html-editor-display">
&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;Gimy.site Showcase&lt;/title&gt;
    &lt;link rel="stylesheet" href="style.css"&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;header class="site-header"&gt;
        &lt;h1&gt;Welcome to Gimy.site&lt;/h1&gt;
        &lt;p&gt;The easiest way to host your static sites.&lt;/p&gt;
    &lt;/header&gt;

    &lt;main class="container"&gt;
        &lt;div class="card"&gt;
            &lt;h2&gt;Feature-Rich Editor&lt;/h2&gt;
            &lt;p&gt;Edit HTML, CSS, and JS with syntax highlighting.&lt;/p&gt;
            &lt;button id="theme-toggle"&gt;Toggle Theme&lt;/button&gt;
        &lt;/div&gt;
    &lt;/main&gt;

    &lt;footer class="site-footer"&gt;
        &lt;p&gt;&copy; 2025 Gimy.site. All rights reserved.&lt;/p&gt;
    &lt;/footer&gt;
    
    &lt;script src="script.js"&gt;&lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
                        </textarea>
                    </div>
                    <div x-show="tab === 'css'" class="h-full" x-cloak>
                        <textarea id="css-editor-display">
/* General Body Styles */
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    line-height: 1.6;
    background-color: #111827;
    color: #e5e7eb;
    margin: 0;
    padding: 0;
    transition: background-color 0.3s ease;
}

/* Light Theme */
body.light-theme {
    background-color: #f9fafb;
    color: #1f2937;
}

/* Container */
.container {
    padding: 2rem;
    max-width: 800px;
    margin: 0 auto;
}

/* Header and Footer */
.site-header, .site-footer {
    text-align: center;
    padding: 2rem 1rem;
    background-color: rgba(31, 41, 55, 0.5);
}

body.light-theme .site-header,
body.light-theme .site-footer {
    background-color: #e5e7eb;
}

.site-header h1 {
    margin: 0;
    font-size: 2.5rem;
    color: #ffffff;
}

body.light-theme .site-header h1 {
    color: #111827;
}

/* Card Styles */
.card {
    background: #1f2937;
    padding: 2rem;
    border-radius: 0.75rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    text-align: center;
}

body.light-theme .card {
    background: #ffffff;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
}

.card h2 {
    margin-top: 0;
    color: #6366f1;
}

/* Button Styles */
button {
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
    background-color: #4f46e5;
    color: white;
}

button:hover {
    background-color: #6366f1;
    transform: translateY(-2px);
}

button:active {
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        padding: 1rem;
    }

    .site-header h1 {
        font-size: 2rem;
    }
}
                        </textarea>
                    </div>
                    <div x-show="tab === 'js'" class="h-full" x-cloak>
                        <textarea id="js-editor-display">
document.addEventListener('DOMContentLoaded', () => {
    const themeToggleButton = document.getElementById('theme-toggle');
    const body = document.body;

    // Check for saved theme preference
    if (localStorage.getItem('theme') === 'light') {
        body.classList.add('light-theme');
        updateButtonText();
    }

    // Toggle theme on button click
    themeToggleButton.addEventListener('click', () => {
        body.classList.toggle('light-theme');
        
        // Save theme preference to localStorage
        if (body.classList.contains('light-theme')) {
            localStorage.setItem('theme', 'light');
        } else {
            localStorage.removeItem('theme');
        }

        updateButtonText();
    });

    function updateButtonText() {
        const isLight = body.classList.contains('light-theme');
        themeToggleButton.textContent = isLight ? 'Switch to Dark Mode' : 'Switch to Light Mode';
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
                readOnly: true, // Set to non-editable
                lineWrapping: true,
            });
            editor.setSize("100%", "100%");
            return editor;
        }
    }));
});
</script>
@endpush
