<x-authenticated-layout>

    <div class="max-w-2xl mx-auto">

        <div class="mb-8">

            <p class="text-sm font-semibold text-indigo-700">
                Equipos
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                Crear equipo
            </h1>

            <p class="mt-2 text-gray-700">
                Crea un equipo y establece la contraseña que utilizarán sus integrantes.
            </p>

        </div>


        <div class="bg-blue-100 border border-gray-200 shadow-sm rounded-xl p-8">

            <form
                method="POST"
                action="{{ route('teams.store') }}"
            >

                @csrf


                {{-- Nombre --}}
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
                        value="{{ old('name') }}"
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


                {{-- Contraseña --}}
                <div class="mt-5">

                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Contraseña del equipo
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        minlength="6"
                        autocomplete="new-password"
                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                    <p class="mt-1 text-xs text-gray-500">
                        Esta contraseña será necesaria para unirse al equipo.
                    </p>

                    @error('password')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Botón --}}
                <button
                    type="submit"
                    class="mt-6 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition"
                >
                    Crear equipo
                </button>

            </form>

        </div>

    </div>

</x-authenticated-layout>