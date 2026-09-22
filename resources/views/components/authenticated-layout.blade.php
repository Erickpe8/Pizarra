{{-- resources/views/components/authenticated-layout.blade.php --}}

<x-app-layout>

    <div class="flex min-h-screen bg-blue-300">

        @include('layouts.sidebar')

        <div class="flex-1 min-w-0">

            <header class="h-16 bg-white border-b border-gray-200 shadow-sm">

                <div class="flex items-center justify-between h-full px-6">

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">
                            Dashboard
                        </h2>
                    </div>

                    <div class="flex items-center gap-3">

                        <div class="text-right">

                            <p class="text-sm font-medium text-gray-900">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ auth()->user()->email }}
                            </p>

                        </div>

                        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 font-semibold">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                    </div>

                </div>

            </header>

            <main class="min-h-[calc(100vh-4rem)] bg-blue-300">

                <div class="w-full px-6 py-8">

                    {{ $slot }}

                </div>

            </main>

        </div>

    </div>

</x-app-layout>