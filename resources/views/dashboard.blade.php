<x-authenticated-layout>

    <div class="mb-6">

        <p class="text-sm font-semibold text-indigo-700">
            Panel principal
        </p>

        <h1 class="mt-1 text-3xl font-bold text-gray-900">
            Dashboard
        </h1>

        <p class="mt-2 text-gray-700">
            Bienvenido de nuevo,
            <span class="font-semibold">
                {{ auth()->user()->name }}
            </span>.
        </p>

    </div>



    @if (session('success'))

        <div class="mb-6 flex items-center gap-3 p-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl">

            <svg
                width="20"
                height="20"
                class="w-5 h-5 shrink-0"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                />

            </svg>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if (auth()->user()->teams()->doesntExist())

        @include('norole')

    @else

        @php
            $role = auth()->user()->getRoleNames()->first();
        @endphp



        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">



            <div class="lg:col-span-2 bg-blue-100 border border-gray-200 rounded-xl shadow-sm">

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <div>

                            <h2 class="text-xl font-semibold text-gray-900">
                                Información de tu cuenta
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Información de tu usuario dentro de Pizarra.
                            </p>

                        </div>


                        <div class="flex items-center justify-center w-11 h-11 bg-indigo-50 text-indigo-600 rounded-lg">

                            <svg
                                width="24"
                                height="24"
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 19a4 4 0 00-8 0m4-8a4 4 0 100-8 4 4 0 000 8zm7 8v-2a3 3 0 00-3-3h-1"
                                />

                            </svg>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 gap-4 mt-6 sm:grid-cols-2">


                        {{-- Nombre --}}
                        <div class="p-4 bg-gray-50 rounded-lg">

                            <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                Nombre
                            </p>

                            <p class="mt-1 text-base font-semibold text-gray-900">
                                {{ auth()->user()->name }}
                            </p>

                        </div>


                        {{-- Correo --}}
                        <div class="p-4 bg-gray-50 rounded-lg">

                            <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                Correo electrónico
                            </p>

                            <p class="mt-1 text-base font-semibold text-gray-900 break-all">
                                {{ auth()->user()->email }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>



            <div class="bg-blue-100 border border-gray-200 rounded-xl shadow-sm">

                <div class="p-6">

                    <p class="text-sm font-medium text-gray-500">
                        Rol actual
                    </p>


                    <div class="flex items-center gap-4 mt-4">

                        <div class="flex items-center justify-center w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full">

                            <svg
                                width="24"
                                height="24"
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 14v7m0-7l-6.16-3.42M12 14l6.16-3.42"
                                />

                            </svg>

                        </div>


                        <div>

                            <p class="text-xl font-bold text-gray-900">

                                {{
                                    $role === 'lider'
                                        ? 'Líder'
                                        : (
                                            $role === 'trabajador'
                                                ? 'Trabajador'
                                                : ($role ?: 'Sin rol')
                                        )
                                }}

                            </p>

                            <p class="text-sm text-gray-500">
                                Rol asignado en Pizarra
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="mt-6">

            <h2 class="text-xl font-semibold text-gray-900">
                Acciones rápidas
            </h2>

            <p class="mt-1 text-sm text-gray-700">
                Accede rápidamente a las funciones disponibles.
            </p>


            <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 lg:grid-cols-3">


                {{-- Gestionar equipos --}}
                @role('lider')

                    <a
                        href="{{ route('teams.manage') }}"
                        class="block p-5 bg-blue-100 border border-gray-200 rounded-xl shadow-sm hover:border-indigo-400 hover:shadow-md transition"
                    >

                        <div class="flex items-center justify-center w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg">

                            <svg
                                width="20"
                                height="20"
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m8-5a4 4 0 11-8 0 4 4 0 018 0zm6-2a3 3 0 11-6 0"
                                />

                            </svg>

                        </div>

                        <h3 class="mt-4 font-semibold text-gray-900">
                            Gestionar equipos
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Administra tus equipos y sus integrantes.
                        </p>

                    </a>


                    {{-- Crear equipo --}}
                    <a
                        href="{{ route('teams.create') }}"
                        class="block p-5 bg-blue-100 border border-gray-200 rounded-xl shadow-sm hover:border-indigo-400 hover:shadow-md transition"
                    >

                        <div class="flex items-center justify-center w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg">

                            <svg
                                width="20"
                                height="20"
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"
                                />

                            </svg>

                        </div>

                        <h3 class="mt-4 font-semibold text-gray-900">
                            Crear equipo
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Crea un nuevo equipo.
                        </p>

                    </a>

                @endrole


                {{-- Unirse --}}
                <a
                    href="{{ route('teams.join') }}"
                    class="block p-5 bg-blue-100 border border-gray-200 rounded-xl shadow-sm hover:border-indigo-400 hover:shadow-md transition"
                >

                    <div class="flex items-center justify-center w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg">

                        <svg
                            width="20"
                            height="20"
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M18 8a4 4 0 11-8 0 4 4 0 018 0zM6 21a6 6 0 0112 0M19 12v6M22 15h-6"
                            />

                        </svg>

                    </div>

                    <h3 class="mt-4 font-semibold text-gray-900">
                        Unirme a un equipo
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Ingresa el nombre y contraseña del equipo.
                    </p>

                </a>

            </div>

        </div>

    @endif

</x-authenticated-layout>