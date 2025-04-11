<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 50"
    class="bg-white border-b border-gray-100 fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    :class="{ 'shadow-md': scrolled }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex h-f">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                        {{ __('Categories') }}
                    </x-nav-link>
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs(['products.index', 'products.create', 'products.edit'])">
                        {{ __('Products') }}
                    </x-nav-link>
                    <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
                        {{ __('Contact') }}
                    </x-nav-link>
                    <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
                        {{ __('About us') }}
                    </x-nav-link>
                    <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
                        {{ __('Question') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="input-group flex-grow-1" style="max-width: 600px;">
                    <span class="input-group-text rounded-start-3 bg-white border border-gray-300 border-end-0">
                        <i class="fas fa-search text-gray-500"></i>
                    </span>
                    <input type="text" id="searchInput" placeholder="Search..."
                        class="form-control rounded-end-3 border border-gray-300 border-start-0 py-2 px-3 hover:border-gray-400 focus:border-gray-500 focus:ring-1 focus:ring-gray-200">
                </div>
                <a href="{{ route('login') }}"
                    class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition">
                    {{ __('Login') }}
                </a>
            </div>
        </div>
    </div>
</nav>
