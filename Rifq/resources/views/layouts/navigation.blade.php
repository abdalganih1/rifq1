<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 space-x-reverse">
                        <svg class="h-8 w-8 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="text-xl font-bold text-emerald-600">رِفْق</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('messages.home') ?: 'الرئيسية' }}
                    </x-nav-link>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="/admin" :active="request()->is('admin')">
                                {{ __('messages.dashboard') ?: 'لوحة التحكم' }}
                            </x-nav-link>
                        @endif

                        @if(auth()->user()->hasAnyRole(['admin', 'data_entry', 'vet']))
                            <x-nav-link :href="route('animals.index')" :active="request()->routeIs('animals.*')">
                                {{ __('messages.animals') ?: 'الحيوانات' }}
                            </x-nav-link>
                            <x-nav-link :href="route('qrcodes.generate.form')" :active="request()->routeIs('qrcodes.*')">
                                {{ __('messages.generate_qr') ?: 'توليد QR' }}
                            </x-nav-link>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.trash.index')" :active="request()->routeIs('admin.trash.*')">
                                {{ __('messages.trash') ?: 'سلة المهملات' }}
                            </x-nav-link>
                        @endif

                        <x-nav-link :href="route('adoptions.index')" :active="request()->routeIs('adoptions.*')">
                            {{ __('messages.adoption') ?: 'التبني' }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="flex items-center gap-3 me-4">
                        <a href="{{ route('language.switch', 'ar') }}" class="text-sm {{ app()->getLocale() === 'ar' ? 'font-bold text-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">عربي</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('language.switch', 'en') }}" class="text-sm {{ app()->getLocale() === 'en' ? 'font-bold text-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">EN</a>
                    </div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white dark:bg-gray-800 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('messages.profile') ?: 'الملف الشخصي' }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('messages.logout') ?: 'تسجيل الخروج' }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3 me-4">
                        <a href="{{ route('language.switch', 'ar') }}" class="text-sm {{ app()->getLocale() === 'ar' ? 'font-bold text-emerald-600' : 'text-gray-500' }}">عربي</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('language.switch', 'en') }}" class="text-sm {{ app()->getLocale() === 'en' ? 'font-bold text-emerald-600' : 'text-gray-500' }}">EN</a>
                    </div>
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300">{{ __('messages.login') ?: 'تسجيل الدخول' }}</a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('messages.home') ?: 'الرئيسية' }}
            </x-responsive-nav-link>

            @auth
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link href="/admin">
                        {{ __('messages.dashboard') ?: 'لوحة التحكم' }}
                    </x-responsive-nav-link>
                @endif

                @if(auth()->user()->hasAnyRole(['admin', 'data_entry', 'vet']))
                    <x-responsive-nav-link :href="route('animals.index')" :active="request()->routeIs('animals.*')">
                        {{ __('messages.animals') ?: 'الحيوانات' }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('qrcodes.generate.form')" :active="request()->routeIs('qrcodes.*')">
                        {{ __('messages.generate_qr') ?: 'توليد QR' }}
                    </x-responsive-nav-link>
                @endif

                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.trash.index')" :active="request()->routeIs('admin.trash.*')">
                        {{ __('messages.trash') ?: 'سلة المهملات' }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('adoptions.index')" :active="request()->routeIs('adoptions.*')">
                    {{ __('messages.adoption') ?: 'التبني' }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('messages.profile') ?: 'الملف الشخصي' }}
                    </x-responsive-nav-link>

                    <div class="px-4 py-2">
                        <a href="{{ route('language.switch', 'ar') }}" class="text-sm text-gray-600 me-2">عربي</a>
                        <a href="{{ route('language.switch', 'en') }}" class="text-sm text-gray-600">English</a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('messages.logout') ?: 'تسجيل الخروج' }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4 py-2 space-y-2">
                    <div>
                        <a href="{{ route('language.switch', 'ar') }}" class="text-sm me-2">عربي</a>
                        <a href="{{ route('language.switch', 'en') }}" class="text-sm">English</a>
                    </div>
                    <a href="{{ route('login') }}" class="block text-sm text-emerald-600 font-medium">{{ __('messages.login') ?: 'تسجيل الدخول' }}</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
