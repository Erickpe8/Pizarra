<aside class="w-64 min-w-64 shrink-0 bg-white border-r border-gray-200 min-h-screen flex flex-col">

    <div class="h-20 flex items-center px-6 border-b border-gray-200">
        <a href="{{ route('dashboard') }}"
           class="text-3xl font-bold text-indigo-600">
            Pizarra
        </a>
    </div>

    <nav class="flex-1 px-4 py-6">

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-3 mb-2 rounded-lg
                  text-gray-700 hover:bg-indigo-50 hover:text-indigo-600
                  transition">

            <svg
                class="shrink-0"
                style="width: 18px; height: 18px;"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"
                />
            </svg>

            <span class="text-base font-medium">
                Dashboard
            </span>
        </a>


        @if(auth()->user()->hasRole('lider') || auth()->user()->hasRole('trabajador'))
            <a href="{{ route('teams.manage') }}"
               class="flex items-center gap-3 px-3 py-3 mb-2 rounded-lg
                      text-gray-700 hover:bg-indigo-50 hover:text-indigo-600
                      transition">

                <svg
                    class="shrink-0"
                    style="width: 18px; height: 18px;"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                    />
                    <circle
                        cx="9"
                        cy="7"
                        r="4"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M22 21v-2a4 4 0 00-3-3.87"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 3.13a4 4 0 010 7.75"
                    />
                </svg>

                <span class="text-base font-medium">
                    Mis equipos
                </span>
            </a>
        @endif


        @if(auth()->user()->hasRole('lider'))
            <a href="{{ route('teams.create') }}"
               class="flex items-center gap-3 px-3 py-3 mb-2 rounded-lg
                      text-gray-700 hover:bg-indigo-50 hover:text-indigo-600
                      transition">

                <svg
                    class="shrink-0"
                    style="width: 18px; height: 18px;"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 5v14M5 12h14"
                    />
                </svg>

                <span class="text-base font-medium">
                    Crear equipo
                </span>
            </a>
        @endif


        @if(auth()->user()->hasRole('lider') || auth()->user()->hasRole('trabajador'))
            <a href="{{ route('teams.join') }}"
               class="flex items-center gap-3 px-3 py-3 mb-2 rounded-lg
                      text-gray-700 hover:bg-indigo-50 hover:text-indigo-600
                      transition">

                <svg
                    class="shrink-0"
                    style="width: 18px; height: 18px;"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <circle
                        cx="9"
                        cy="8"
                        r="4"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 21a6 6 0 0112 0"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 8v6M16 11h6"
                    />
                </svg>

                <span class="text-base font-medium">
                    Unirme a un equipo
                </span>
            </a>
        @endif


        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-3 py-3 mb-2 rounded-lg
                  text-gray-700 hover:bg-indigo-50 hover:text-indigo-600
                  transition">

            <svg
                class="shrink-0"
                style="width: 18px; height: 18px;"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <circle
                    cx="12"
                    cy="8"
                    r="4"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 21a8 8 0 0116 0"
                />
            </svg>

            <span class="text-base font-medium">
                Mi perfil
            </span>
        </a>

    </nav>


    <div class="px-4 py-5 border-t border-gray-200">

        <div class="px-3 mb-4">
            <p class="text-sm font-semibold text-gray-800">
                {{ auth()->user()->name }}
            </p>

            <p class="text-xs text-gray-500 truncate">
                {{ auth()->user()->email }}
            </p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="w-full flex items-center gap-3 px-3 py-3 rounded-lg
                       text-gray-700 hover:bg-red-50 hover:text-red-600
                       transition text-left"
            >

                <svg
                    class="shrink-0"
                    style="width: 18px; height: 18px;"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10 17l5-5-5-5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12H3"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 19V5a2 2 0 00-2-2h-6"
                    />
                </svg>

                <span class="text-base font-medium">
                    Cerrar sesión
                </span>

            </button>
        </form>

    </div>

</aside>