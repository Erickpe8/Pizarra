{{-- resources/views/layouts/sidebar.blade.php --}}

<aside class="w-64 min-w-64 shrink-0 min-h-screen bg-blue-100 border-r border-gray-200 shadow-sm">

    <div class="flex flex-col min-h-screen w-64">

        <div class="flex items-center h-16 px-5 border-b border-gray-200">

            <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-indigo-600 text-white font-bold text-lg">
                P
            </div>

            <div class="ml-3">

                <h1 class="text-lg font-bold text-gray-900">
                    Pizarra
                </h1>

                <p class="text-xs text-gray-500">
                    Gestión de equipos
                </p>

            </div>

        </div>

        <nav class="flex-1 px-3 py-5">

            <p class="px-3 mb-3 text-xs font-semibold tracking-wider text-gray-400 uppercase">
                Menú principal
            </p>


            <ul class="space-y-1">

                <li>

                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition"
                    >

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
                                d="M3 10.5L12 3l9 7.5M5 9v11h14V9M9 20v-6h6v6"
                            />

                        </svg>

                        <span class="ml-3">
                            Dashboard
                        </span>

                    </a>

                </li>

                @role('lider')

                    <li>

                        <a
                            href="{{ route('teams.manage') }}"
                            class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition"
                        >

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
                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m8-5a4 4 0 11-8 0 4 4 0 018 0zm6-2a3 3 0 11-6 0"
                                />

                            </svg>

                            <span class="ml-3">
                                Gestionar equipos
                            </span>

                        </a>

                    </li>

                    <li>

                        <a
                            href="{{ route('teams.create') }}"
                            class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition"
                        >

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
                                    d="M12 4v16m8-8H4"
                                />

                            </svg>

                            <span class="ml-3">
                                Crear equipo
                            </span>

                        </a>

                    </li>

                @endrole

                @role('trabajador')

                    <li>

                        <a
                            href="{{ route('teams.my') }}"
                            class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition"
                        >

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
                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m8-5a4 4 0 11-8 0 4 4 0 018 0zm6-2a3 3 0 11-6 0"
                                />

                            </svg>

                            <span class="ml-3">
                                Mis equipos
                            </span>

                        </a>

                    </li>

                 @endrole

                <li>

                    <a
                        href="{{ route('teams.join') }}"
                        class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-100 hover:text-indigo-700 transition"
                    >

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
                                d="M18 8a4 4 0 11-8 0 4 4 0 018 0zM6 21a6 6 0 0112 0M19 12v6M22 15h-6"
                            />

                        </svg>

                        <span class="ml-3">
                            Unirme a un equipo
                        </span>

                    </a>

                </li>

                <li>

                    <a
                        href="{{ route('profile.edit') }}"
                        class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition"
                    >

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
                                d="M15 19a4 4 0 00-8 0m4-8a4 4 0 100-8 4 4 0 000 8zm7 8v-2a3 3 0 00-3-3h-1"
                            />

                        </svg>

                        <span class="ml-3">
                            Mi perfil
                        </span>

                    </a>

                </li>

            </ul>

        </nav>

        <div class="p-4 border-t border-gray-200">

            <div class="flex items-center p-3 mb-3 bg-blue-100 rounded-lg">

                <div class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-indigo-700 font-semibold shrink-0">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

                <div class="ml-3 min-w-0">

                    <p class="text-sm font-semibold text-gray-900 truncate">
                        {{ auth()->user()->name }}
                    </p>

                    @php
                        $role = auth()->user()->getRoleNames()->first();
                    @endphp

                    <p class="text-xs text-gray-500 truncate">

                        {{
                            $role === 'lider'
                                ? 'Líder'
                                : (
                                    $role === 'trabajador'
                                        ? 'Trabajador'
                                        : 'Usuario'
                                )
                        }}

                    </p>

                </div>

            </div>



            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="flex items-center w-full px-3 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-red-50 hover:text-red-600 transition"
                >

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
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                        />

                    </svg>

                    <span class="ml-3">
                        Cerrar sesión
                    </span>

                </button>

            </form>

        </div>

    </div>

</aside>