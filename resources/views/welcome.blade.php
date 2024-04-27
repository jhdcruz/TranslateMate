@extends('layouts.app')

@section('content')

    <style>
        textarea {
            resize: none;
            /*hide scroll*/

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
        class="min-h-screen content-between bg-gray-100 bg-center bg-dots dark:bg-gray-900 selection:bg-indigo-500 selection:text-white">

        <div class="p-6 max-w-screen flex items-center align-middle justify-end">
            {{-- Theme Switcher --}}
            <button aria-label="Toggle dark mode" type="button"
                    class="p-2 mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500"
                    x-data="{
                        isDark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                        toggleTheme() {
                            this.isDark = !this.isDark;
                            localStorage.theme = this.isDark ? 'dark' : 'light';
                            document.documentElement.classList.toggle('dark', this.isDark);
                        }
                    }"
                    x-init="document.documentElement.classList.toggle('dark', this.isDark)"
                    @click="toggleTheme()">

                {{-- if dark --}}
                <x-gmdi-dark-mode-o x-show="!isDark" defer/>

                {{-- if light --}}
                <x-gmdi-light-mode-o x-show="isDark" defer/>
            </button>


            @if (Route::has('login'))
                @auth
                    <a href="{{ route('home') }}"
                       class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Home</a>
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

        <div class="relative flex justify-center items-center">
            <livewire:translate/>
        </div>

        {{-- Footer --}}
        <div
            class="flex max-w-screen mt-16 justify-center sm:justify-around px-0 py-8 items-center">

            {{-- Sponsor --}}
            <div class="mx-2 text-sm text-left text-gray-500 dark:text-gray-400 sm:mx-5">
                <div class="flex items-center gap-4">
                    <a href="https://github.com/jhdcruz/TranslateMate"
                       class="inline-flex items-center group hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">
                        <x-gmdi-favorite-border-o class="mr-2 w-4 h-4" defer/>
                        Sponsor
                    </a>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="mx-2 text-sm text-gray-500 dark:text-gray-400 text-right sm:mx-5">
                &copy; 2024 TranslateMate - All rights reserved.
            </div>
        </div>
    </div>
@endsection
