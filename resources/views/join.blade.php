<x-app-layout>

    <div class="max-w-2xl mx-auto py-12 px-6">

        <div class="bg-white shadow rounded-xl p-8">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Unirme a un equipo
            </h1>

            @if($teams->isEmpty())

                <p class="text-gray-600">
                    No existen equipos disponibles.
                </p>

            @else

                <form method="POST" action="{{ route('teams.join') }}">

                    @csrf

                    <label
                        for="team_id"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Selecciona un equipo
                    </label>

                    <select
                        name="team_id"
                        id="team_id"
                        class="mt-2 block w-full rounded-lg border-gray-300"
                        required
                    >

                        <option value="">
                            Seleccionar equipo
                        </option>

                        @foreach($teams as $team)

                            <option value="{{ $team->id }}">
                                {{ $team->name }}
                            </option>

                        @endforeach

                    </select>

                    <button
                        type="submit"
                        class="mt-6 w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-3 rounded-lg"
                    >
                        Unirme al equipo
                    </button>

                </form>

            @endif

        </div>

    </div>

</x-app-layout>