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
                    <x-nav-link :href="auth()->check() ? route('home') : route('welcome')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('categories.list')" :active="request()->routeIs('categories.list')">
                        {{ __('Categories') }}
                    </x-nav-link>
                    <x-nav-link :href="route('products.list')" :active="request()->routeIs(['products.list', 'products.create', 'products.edit'])">
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

                <form action="{{ route('user.products.search') }}" method="GET" class="flex-grow-1"
                    style="max-width: 600px;">
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3 bg-white border border-gray-300 border-end-0">
                            <i class="fas fa-search text-gray-500"></i>
                        </span>
                        <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..."
                            class="form-control rounded-end-3 border border-gray-300 border-start-0 py-2 px-3 hover:border-gray-400 focus:border-gray-500 focus:ring-1 focus:ring-gray-200">
                        <button type="submit" class="btn btn-dark ms-2">Tìm kiếm</button>
                    </div>
                </form>
                @auth
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <a href="#"
                            class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">

                            </span>
                        </a>
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                @endauth

                @guest
                    <a href="{{ route('login') }}"
                        class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition">
                        {{ __('Login') }}
                    </a>
                @endguest

            </div>
        </div>
    </div>
</nav>
