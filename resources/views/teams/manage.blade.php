<x-authenticated-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Encabezado --}}
        <div class="mb-8">

            <p class="text-sm font-semibold text-indigo-700">
                Administración
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                Gestionar equipos
            </h1>

            <p class="mt-2 text-gray-700">
                Administra tus equipos y consulta sus integrantes.
            </p>

        </div>


        {{-- Mensaje de éxito --}}
        @if (session('success'))

            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800">

                {{ session('success') }}

            </div>

        @endif


        @if ($teams->isEmpty())

            <div class="bg-blue-100 border border-gray-200 rounded-xl shadow-sm">

                <div class="p-6 text-gray-900">

                    No tienes equipos.

                </div>

            </div>

        @else

            <div class="space-y-6">

                @foreach ($teams as $team)

                    <div class="bg-blue-100 border border-gray-200 rounded-xl shadow-sm overflow-hidden">

                        {{-- Información del equipo --}}
                        <div class="p-6">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                <div>

                                    <p class="text-sm font-medium text-indigo-700">
                                        Equipo
                                    </p>

                                    <h2 class="mt-1 text-2xl font-bold text-gray-900">
                                        {{ $team->name }}
                                    </h2>

                                </div>


                                {{-- Acciones --}}
                                <div class="flex gap-2">

                                    <a
                                        href="{{ route('teams.edit', $team) }}"
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                                    >
                                        Editar
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('teams.destroy', $team) }}"
                                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar este equipo? Esta acción no se puede deshacer.');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                        >
                                            Eliminar
                                        </button>

                                    </form>

                                </div>

                            </div>


                            {{-- Miembros --}}
                            <div class="mt-6">

                                <h3 class="font-semibold text-gray-900 mb-3">
                                    Miembros
                                </h3>


                                @if ($team->users->isEmpty())

                                    <p class="text-sm text-gray-600">
                                        Este equipo todavía no tiene miembros.
                                    </p>

                                @else

                                    <div class="space-y-2">

                                        @foreach ($team->users as $member)

                                            <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200">

                                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-semibold">

                                                    {{ strtoupper(substr($member->name, 0, 1)) }}

                                                </div>

                                                <div class="ml-3">

                                                    <p class="font-medium text-gray-900">
                                                        {{ $member->name }}
                                                    </p>

                                                    <p class="text-sm text-gray-500">
                                                        {{ $member->email }}
                                                    </p>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</x-authenticated-layout>