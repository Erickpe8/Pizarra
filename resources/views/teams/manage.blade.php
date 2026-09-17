<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestionar equipos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($teams->isEmpty())

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        No tienes equipos.
                    </div>
                </div>

            @else

                @foreach ($teams as $team)

                    <div class="bg-blue-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900">

                            <div class="flex justify-between items-center mb-4">

                                <div>
                                    <p class="font-semibold mb-2">
                                        Equipo
                                    </p>
                                    <h3 class="list-disc list-inside space-y-1">
                                        {{ $team->name }}
                                    </h3>
                                </div>

                                <div class="flex gap-2">

                                    <a
                                        href="{{ route('teams.edit', $team) }}"
                                        class="px-4 py-2 bg-black-500 text-black rounded-md hover:bg-blue-600"
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
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                                        >
                                            Eliminar
                                        </button>
                                    </form>

                                </div>

                            </div>

                            <h4 class="font-semibold mb-2">
                                Miembros
                            </h4>

                            @if ($team->users->isEmpty())

                                <p class="text-sm text-gray-600">
                                    Este equipo todavía no tiene miembros.
                                </p>

                            @else

                                <ul class="list-disc list-inside space-y-1">

                                    @foreach ($team->users as $member)

                                        <li>
                                            {{ $member->name }}

                                            <span class="text-gray-500 text-sm">
                                                ({{ $member->email }})
                                            </span>
                                        </li>

                                    @endforeach

                                </ul>

                            @endif

                        </div>
                    </div>

                @endforeach

            @endif

        </div>
    </div>

</x-app-layout>