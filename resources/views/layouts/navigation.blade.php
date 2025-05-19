<nav x-data="{ showLogin: window.location.pathname === '/login', open: false }" class="bg-white dark:bg-white border-b border-blue-900 dark:border-blue-900">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left Side: School Logo -->
            <div class="shrink-0 flex items-center">
                <a href="/">
                    <img src="{{ asset('images/pcu-logo.png') }}" alt="PCU Logo" class="block h-10 w-auto" onerror="this.src='https://via.placeholder.com/150x50?text=PCU+Logo'" />
                </a>
            </div>

            <!-- Right Side: Auth Buttons -->
            <div class="ml-16 flex items-center space-x-4">
                <div>
                    @guest
                    <button @click="showLogin = true" style="background-color: #232b39; color: #fff;" class="text-sm bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded font-semibold border border-blue-500 transition">Log in</button>  
                    @else
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" style="background-color: #232b39; color: #fff;" class="text-sm bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded font-semibold border border-blue-500 transition">Log out</button>
                    </form>
                    @endguest
                </div>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Mobile menu links can go here -->
        </div>

        <!-- Responsive Auth Button -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @guest
                <button @click="showLogin = true" type="button" class="block w-full ps-3 pe-4 py-2 text-start text-base font-semibold text-white bg-blue-500 hover:bg-blue-600 rounded transition">Log in</button>
            @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full ps-3 pe-4 py-2 text-start text-base font-semibold text-white bg-blue-500 hover:bg-blue-600 rounded transition">Log out</button>
                </form>
            @endguest
        </div>
    </div>

    <!-- Login Modal -->
    <div x-show="showLogin" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
        <div @click.away="showLogin = false" class="bg-[#232b39] rounded-lg shadow-lg overflow-hidden w-full sm:max-w-md">
            <div class="px-6 py-4">
                <h2 class="text-xl font-semibold text-white mb-4">{{ __('Log in') }}</h2>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block font-medium text-sm text-gray-200">Email</label>
                        <input id="email" class="border-gray-700 bg-gray-800 text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
                    </div>
                    
                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="block font-medium text-sm text-gray-200">Password</label>
                        <input id="password" class="border-gray-700 bg-gray-800 text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded bg-gray-800 border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                            <span class="ml-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-md transition-colors duration-300">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>

