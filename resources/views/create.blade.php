<x-app-layout>

    <div class="max-w-2xl mx-auto py-12 px-6">

        <div class="bg-white shadow rounded-xl p-8">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Crear equipo
            </h1>

            <form method="POST" action="{{ route('teams.store') }}">

                @csrf

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
                        required
                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                @error('name')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                <button
                    type="submit"
                    class="mt-6 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg"
                >
                    Crear equipo
                </button>

            </form>

        </div>

    </div>

</x-app-layout>