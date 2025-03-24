<script>
    (function () {
        const darkStyles = document.querySelector('style[data-theme="dark"]')?.textContent
        const lightStyles = document.querySelector('style[data-theme="light"]')?.textContent
        const removeStyles = () => {
            document.querySelector('style[data-theme="dark"]')?.remove()
            document.querySelector('style[data-theme="light"]')?.remove()
        }
        removeStyles()
        setDarkClass = () => {
            removeStyles()
            const isDark = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
            isDark ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')
            if (isDark) {
                document.head.insertAdjacentHTML('beforeend', `<style data-theme="dark">${darkStyles}</style>`)
            } else {
                document.head.insertAdjacentHTML('beforeend', `<style data-theme="light">${lightStyles}</style>`)
            }
        }
        setDarkClass()
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', setDarkClass)
    })();
</script>
<div
    class="relative"
    x-data="{
        menu: false,
        theme: localStorage.theme,
        darkMode() {
            this.theme = 'dark'
            localStorage.theme = 'dark'
            setDarkClass()
        },
        lightMode() {
            this.theme = 'light'
            localStorage.theme = 'light'
            setDarkClass()
        },
        systemMode() {
            this.theme = undefined
            localStorage.removeItem('theme')
            setDarkClass()
        },
    }"
    @click.outside="menu = false"
>
    <button
        x-cloak
        class="block rounded p-1 hover:bg-gray-100 dark:hover:bg-gray-800"
        :class="theme ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 dark:text-gray-600 hover:text-gray-500 focus:text-gray-500 dark:hover:text-gray-500 dark:focus:text-gray-500'"
        @click="menu = ! menu"
    >
        <x-laravel-exceptions-renderer::icons.sun class="block h-5 w-5 dark:hidden" />
        <x-laravel-exceptions-renderer::icons.moon class="hidden h-5 w-5 dark:block" />
    </button>
    <div
        x-show="menu"
        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5"
        @click.away="menu = false"
    >
        <div class="py-1">
            <a href="#" @click.prevent="darkMode" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300">Dark Mode</a>
            <a href="#" @click.prevent="lightMode" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300">Light Mode</a>
            <a href="#" @click.prevent="systemMode" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300">System Default</a>
        </div>
    </div>
</div>
