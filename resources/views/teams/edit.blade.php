<x-authenticated-layout>

    <div class="max-w-2xl mx-auto">

        <div class="mb-8">

            <p class="text-sm font-semibold text-indigo-700">
                Equipos
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                Editar equipo
            </h1>

            <p class="mt-2 text-gray-700">
                Modifica el nombre de tu equipo.
            </p>

        </div>


        <div class="bg-blue-100 border border-gray-200 shadow-sm rounded-xl p-8">

            <form
                method="POST"
                action="{{ route('teams.update', $team) }}"
            >

                @csrf
                @method('PUT')


                <div>

                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Nombre del equipo
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $team->name) }}"
                        required
                        autofocus
                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                    @error('name')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <div class="flex gap-3 mt-6">

                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                    >
                        Guardar cambios
                    </button>

                    <a
                        href="{{ route('teams.manage') }}"
                        class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                    >
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-authenticated-layout>