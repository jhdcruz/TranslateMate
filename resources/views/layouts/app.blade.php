@extends('layouts.base')

@section('body')
    <style>
        textarea {
            resize: none;
        }

        @media (prefers-color-scheme: dark) {
            .bg-dots {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(200,200,255,0.15)'/%3E%3C/svg%3E");
            }
        }

        @media (prefers-color-scheme: light) {
            .bg-dots {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,50,0.10)'/%3E%3C/svg%3E")
            }
        }
    </style>

    <div
        class="content-between min-h-screen bg-gray-100 bg-center bg-dots dark:bg-gray-900 selection:bg-indigo-500 selection:text-white">

        <div class="flex items-center justify-between p-6 align-middle max-w-screen">

            <div class="flex align-middle">
                <a href="{{ route('home') }}"
                    class="mr-3 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Translate</a>

                <a href="{{ route('history') }}"
                    class="mr-3 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">History</a>
            </div>

            <div class="flex align-middle">
                {{-- Theme Switcher --}}
                <button aria-label="Toggle dark mode" type="button"
                    class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500"
                    x-data="{
                        isDark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                        toggleTheme() {
                            this.isDark = !this.isDark;
                            localStorage.theme = this.isDark ? 'dark' : 'light';
                            document.documentElement.classList.toggle('dark', this.isDark);
                        }
                    }" x-init="document.documentElement.classList.toggle('dark', this.isDark)" @click="toggleTheme()">

                    {{-- if dark --}}
                    <x-gmdi-dark-mode-o x-show="!isDark" defer />

                    {{-- if light --}}
                    <x-gmdi-light-mode-o x-show="isDark" defer />
                </button>


                @if (Route::has('login'))
                    @auth

                        <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
                            class="flex items-center text-sm font-medium text-gray-600 rounded-full pe-1 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500"
                            type="button">
                            <span class="sr-only">Open user menu</span>
                            {{ Auth::user()->name }}
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownAvatarName"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <div
                                class="px-4 py-3 text-sm text-gray-900 rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <div class="font-medium ">{{ Auth::user()->name }}</div>
                                <div class="truncate">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="w-full py-2">
                                <form class="w-full" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full px-4 py-2 mx-2 text-sm text-gray-900 rounded-lg text-start dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        Log out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Log
                            in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>

        <div class="flex justify-center h-full md:h-[78vh] items-start">
            @yield('content')

            @isset($slot)
                {{ $slot }}
            @endisset
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-center px-0 py-8 max-w-screen">
            <span class="mx-2 text-sm text-right text-gray-500 dark:text-gray-400 sm:mx-5">
                &copy; 2024 TranslateMate - All rights reserved.
            </span>
        </div>
    </div>
@endsection
