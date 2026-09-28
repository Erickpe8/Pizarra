<x-authenticated-layout>

    <div class="max-w-7xl mx-auto">

        <div class="mb-8">

            <p class="text-sm font-semibold text-indigo-700">
                Equipos
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                Mis equipos
            </h1>

            <p class="mt-2 text-gray-700">
                Consulta los equipos a los que perteneces y sus integrantes.
            </p>

        </div>


        @if (session('success'))

            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800">
                {{ session('success') }}
            </div>

        @endif


        @if ($errors->has('member'))

            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800">
                {{ $errors->first('member') }}
            </div>

        @endif


        @if ($teams->isEmpty())

            <div class="bg-blue-100 border border-gray-200 rounded-xl shadow-sm p-8 text-center">

                <h2 class="text-xl font-bold text-gray-900">
                    No tienes equipos
                </h2>

                <p class="mt-2 text-gray-600">
                    Todavía no perteneces a ningún equipo.
                </p>

                <a
                    href="{{ route('teams.join') }}"
                    class="inline-block mt-6 px-5 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition"
                >
                    Unirme a un equipo
                </a>

            </div>

        @else

            <div class="space-y-6">

                @foreach ($teams as $team)

                    @php
                        $isLeader = in_array($team->id, $leaderTeamIds);
                    @endphp


                    <div class="bg-blue-100 border border-gray-200 rounded-xl shadow-sm overflow-hidden">

                        <div class="p-6">

                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                                <div>

                                    <p class="text-sm font-medium text-indigo-700">
                                        Equipo
                                    </p>

                                    <h2 class="mt-1 text-2xl font-bold text-gray-900">
                                        {{ $team->name }}
                                    </h2>

                                    <div class="mt-2">

                                        @if ($isLeader)

                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                                Líder
                                            </span>

                                        @else

                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                Trabajador
                                            </span>

                                        @endif

                                        @if (session('current_team_id') == $team->id)

                                        <div class="mt-2">

                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                ✓ Equipo seleccionado
                                            </span>

                                        </div>

                                    @endif

                                    </div>
                                    

                                </div>


                                <div class="flex items-center gap-2 shrink-0 self-start">

                                    <form
                                        method="POST"
                                        action="{{ route('teams.select', $team) }}"
                                        class="flex shrink-0"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                                        >
                                            Trabajar en este equipo
                                        </button>
                                    </form>


                                    @if ($isLeader)

                                        <a
                                            href="{{ route('teams.edit', $team) }}"
                                            class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                                        >
                                            Editar
                                        </a>


                                        <form
                                            method="POST"
                                            action="{{ route('teams.destroy', $team) }}"
                                            class="flex shrink-0"
                                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este equipo? Esta acción no se puede deshacer.');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                            >
                                                Eliminar equipo
                                            </button>
                                        </form>

                                    @endif

                                </div>

                            </div>


                            <div class="mt-6 border-t border-gray-200 pt-6">

                                <div class="flex items-center justify-between mb-4">

                                    <h3 class="font-semibold text-gray-900">
                                        Integrantes
                                    </h3>

                                    <span class="text-sm text-gray-500">
                                        {{ $team->users->count() }}
                                        {{ $team->users->count() === 1 ? 'integrante' : 'integrantes' }}
                                    </span>

                                </div>


                                @if ($team->users->isEmpty())

                                    <p class="text-sm text-gray-600">
                                        Este equipo todavía no tiene integrantes.
                                    </p>

                                @else

                                    <div class="space-y-3">

                                        @foreach ($team->users as $member)

                                            @php
                                                $memberRole = $memberRoles[$team->id][$member->id] ?? null;
                                            @endphp


                                            <div class="flex flex-col gap-4 p-4 bg-white rounded-lg border border-gray-200 lg:flex-row lg:items-center lg:justify-between">

                                                <div class="flex items-center min-w-0">

                                                    <div class="flex items-center justify-center w-10 h-10 shrink-0 rounded-full bg-indigo-100 text-indigo-700 font-semibold">

                                                        {{ strtoupper(substr($member->name, 0, 1)) }}

                                                    </div>


                                                    <div class="ml-3 min-w-0">

                                                        <p class="font-medium text-gray-900 truncate">
                                                            {{ $member->name }}
                                                        </p>

                                                        <p class="text-sm text-gray-500 truncate">
                                                            {{ $member->email }}
                                                        </p>

                                                    </div>

                                                </div>


                                                <div class="flex flex-wrap items-center gap-2">

                                                    @if ($memberRole === 'lider')

                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                                            Líder
                                                        </span>

                                                    @elseif ($memberRole === 'trabajador')

                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                            Trabajador
                                                        </span>

                                                    @endif


                                                    @if ($isLeader && $member->id !== auth()->id())

                                                        @if ($memberRole === 'trabajador')

                                                            <form
                                                                method="POST"
                                                                action="{{ route('teams.members.role', [$team, $member]) }}"
                                                            >

                                                                @csrf
                                                                @method('PATCH')

                                                                <input
                                                                    type="hidden"
                                                                    name="role"
                                                                    value="lider"
                                                                >

                                                                <button
                                                                    type="submit"
                                                                    class="px-3 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                                                                >
                                                                    Dar rol de líder
                                                                </button>

                                                            </form>

                                                        @elseif ($memberRole === 'lider')

                                                            <form
                                                                method="POST"
                                                                action="{{ route('teams.members.role', [$team, $member]) }}"
                                                            >

                                                                @csrf
                                                                @method('PATCH')

                                                                <input
                                                                    type="hidden"
                                                                    name="role"
                                                                    value="trabajador"
                                                                >

                                                                <button
                                                                    type="submit"
                                                                    class="px-3 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-gray-700 transition"
                                                                >
                                                                    Dar rol de trabajador
                                                                </button>

                                                            </form>

                                                        @endif


                                                        <form
                                                            method="POST"
                                                            action="{{ route('teams.members.destroy', [$team, $member]) }}"
                                                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este integrante del equipo?');"
                                                        >

                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="px-3 py-2 text-sm font-medium bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                                            >
                                                                Eliminar
                                                            </button>

                                                        </form>

                                                    @endif

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