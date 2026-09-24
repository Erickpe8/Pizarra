<x-authenticated-layout>

    <div class="max-w-5xl mx-auto px-6 py-8">

        {{-- Encabezado --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Tarea del equipo
                    </p>

                    <h1 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $task->title }}
                    </h1>
                </div>

                <a
                    href="{{ route('teams.workspace', $team) }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition"
                >
                    ← Volver al equipo
                </a>

            </div>

        </div>


        {{-- Información de la tarea --}}
        <div class="mt-6 bg-white rounded-2xl shadow-sm p-6">

            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                Detalles de la tarea
            </h2>

            {{-- Descripción --}}
            <div class="mb-6">

                <p class="text-sm font-semibold text-gray-500 mb-2">
                    Descripción
                </p>

                <div class="bg-gray-50 rounded-xl p-4 text-gray-700">
                    {{ $task->description ?: 'Sin descripción.' }}
                </div>

            </div>


            {{-- Información --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="text-sm text-gray-500">
                        Estado
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ ucfirst($task->status) }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-500">
                        Creada por
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $task->creator?->name ?? 'Sin información' }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-500">
                        Asignada a
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $task->assignee?->name ?? 'Sin asignar' }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-500">
                        Fecha de asignación
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $task->assigned_at?->format('d/m/Y H:i') ?? 'Sin asignar' }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-500">
                        Fecha límite
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $task->due_date?->format('d/m/Y') ?? 'Sin fecha límite' }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-500">
                        Tiempo estimado
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $task->estimated_time !== null
                            ? $task->estimated_time . ' min'
                            : 'Sin estimar' }}
                    </p>
                </div>

            </div>

        </div>

    </div>

</x-authenticated-layout>