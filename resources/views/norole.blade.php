<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="bg-white shadow-lg rounded-xl p-8 max-w-md w-full text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-3">
            No tienes un rol
        </h1>

        <p class="text-gray-600 mb-8">
            Para continuar debes crear un equipo o unirte a uno existente.
        </p>

        <div class="space-y-4">
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
