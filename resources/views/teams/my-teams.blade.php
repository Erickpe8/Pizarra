<x-authenticated-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Encabezado --}}
        <div class="mb-8">

            <p class="text-sm font-semibold text-indigo-700">
                Equipos
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                Mis equipos
            </h1>

            <p class="mt-2 text-gray-700">
                Aquí puedes ver todos los equipos a los que estás unido.
            </p>

        </div>


        {{-- Mensaje de éxito --}}
        @if (session('success'))

            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800">
                {{ session('success') }}
            </div>

        @endif


        {{-- Sin equipos --}}
        @if ($teams->isEmpty())

            <div class="bg-blue-100 border border-gray-200 rounded-xl shadow-sm p-8 text-center">

                <h2 class="text-xl font-bold text-gray-900">
                    No estás unido a ningún equipo
                </h2>

                <p class="mt-2 text-gray-600">
                    Puedes unirte a un equipo utilizando su nombre y contraseña.
                </p>

                <div class="mt-6">

                    <a
                        href="{{ route('teams.join') }}"
                        class="inline-block px-5 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition"
                    >
                        Unirme a un equipo
                    </a>

                </div>

            </div>

        @else

            {{-- Lista de equipos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach ($teams as $team)

                    <div class="bg-blue-100 border border-gray-200 rounded-xl shadow-sm overflow-hidden">

                        <div class="p-6">

                            {{-- Icono --}}
                            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700">

                                <svg
                                    class="w-6 h-6"
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


                            {{-- Nombre --}}
                            <h2 class="mt-5 text-xl font-bold text-gray-900">
                                {{ $team->name }}
                            </h2>


                            {{-- Información --}}
                            <p class="mt-2 text-sm text-gray-600">
                                Estás unido a este equipo como trabajador.
                            </p>


                            {{-- Equipo actual --}}
                            @if (session('current_team_id') == $team->id)

                                <div class="mt-5">

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        Equipo actual
                                    </span>

                                </div>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Botón para unirse a otro --}}
            <div class="mt-6">

                <a
                    href="{{ route('teams.join') }}"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition"
                >
                    <span class="text-2xl leading-none font-light">
                        +
                    </span>

                    <span>
                        Unirme a otro equipo
                    </span>
                </a>

            </div>

        @endif

    </div>

</x-authenticated-layout>