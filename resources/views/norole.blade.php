<div class="max-w-2xl mx-auto">

    <div class="bg-blue-100 border border-gray-200 shadow-sm rounded-xl p-8 text-center">

        <h1 class="text-2xl font-bold text-gray-900">
            No tienes un equipo
        </h1>

        <p class="mt-3 text-gray-600">
            Para continuar debes crear un equipo o unirte a uno existente.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-8">

            <a
                href="{{ route('teams.create') }}"
                class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition"
            >
                Crear equipo
            </a>

            <a
                href="{{ route('teams.join') }}"
                class="block w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-3 rounded-lg transition"
            >
                Unirme a un equipo
            </a>

        </div>

    </div>

</div>