<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-blue-100 rounded-xl shadow-sm p-6">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Equipo seleccionado
                        </p>

                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ $team->name }}
                        </h1>

                    </div>

                    <a
                        href="{{ route('teams.manage') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition"
                    >
                        Mis equipos
                    </a>

                </div>

            </div>


            <div class="mt-6 bg-blue-100 rounded-xl shadow-sm p-6">

                <div class="flex items-center justify-between mb-6">

                    <h2 class="text-xl font-semibold text-gray-900">
                        Tareas
                    </h2>

                    @if (auth()->user()->hasRole('lider'))

                        <a
                            href="{{ route('tasks.create', $team) }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                        >
                            + Crear tarea
                        </a>

                    @endif

                </div>


                <x-flash-message />
               <div class="mt-6">

                    @if ($tasks->isEmpty())

                        <div class="text-center py-10 text-gray-500">
                            No hay tareas todavía.
                        </div>

                    @else

                        <div class="flex flex-col gap-3">

                            @foreach ($tasks as $task)

                                <a
                                    href="{{ route('tasks.show', [$team, $task]) }}"
                                    class="group w-full max-w-md bg-blue-100 border border-blue-200 rounded-xl px-4 py-3 hover:border-indigo-300 hover:shadow-sm transition"
                                >

                                    <div class="flex items-center justify-between gap-3">

                                        <span class="font-semibold text-gray-800 truncate">
                                            {{ $task->title }}
                                        </span>

                                        <span class="text-gray-400 group-hover:text-indigo-500 transition">
                                            →
                                        </span>

                                    </div>

                                </a>

                            @endforeach

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>