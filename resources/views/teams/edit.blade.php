<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar equipo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-xl font-semibold mb-6">
                        Editar equipo
                    </h3>

                    <form method="POST" action="{{ route('teams.update', $team) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">
                                Nombre del equipo
                            </label>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $team->name) }}"
                                required
                                autofocus
                                class="mt-1 block w-full rounded-md border-black shadow-sm"
                            >

                            @error('name')
                                <p class="text-red-600 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mt-6 flex gap-3">

                            <button
                                type="submit"
                                class="px-4 py-2 bg-purple-500 text-black rounded-md hover:bg-purple-600"
                            >
                                Guardar cambios
                            </button>

                            <a
                                href="{{ route('teams.manage') }}"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                            >
                                Cancelar
                            </a>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>