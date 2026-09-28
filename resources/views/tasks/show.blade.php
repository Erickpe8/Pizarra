<x-authenticated-layout>

    <x-flash-message />

    <div class="max-w-5xl mx-auto px-6 py-8">

        {{-- Encabezado --}}
        <div class="bg-blue-100 rounded-2xl shadow-sm p-6">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Tarea del equipo
                    </p>

                    <h1 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $task->title }}
                    </h1>
                </div>

                <div class="flex items-center gap-2">

                    @if (auth()->user()->hasRole('lider'))

                        <a
                            href="{{ route('tasks.edit', [$team, $task]) }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                        >
                            Editar tarea
                        </a>

                    @endif

                    <a
                        href="{{ route('teams.workspace', $team) }}"
                        class="px-4 py-2 bg-blue-100 text-gray-700 rounded-lg hover:bg-blue-200 transition"
                    >
                        ← Volver al equipo
                    </a>

                </div>

            </div>

        </div>


        {{-- Detalles de la tarea --}}
        <div class="mt-6 bg-blue-100 rounded-2xl shadow-sm p-6">

            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                Detalles de la tarea
            </h2>

            <div class="mb-6">

                <p class="text-sm font-semibold text-gray-500 mb-2">
                    Descripción
                </p>

                <div class="bg-gray-50 rounded-xl p-4 text-gray-700 whitespace-pre-line">
                    {{ $task->description ?: 'Sin descripción.' }}
                </div>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Estado --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Estado
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ ucfirst($task->status) }}
                    </p>
                </div>


                {{-- Creador --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Creada por
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $task->creator?->name ?? 'Sin información' }}
                    </p>
                </div>


                {{-- Asignado --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Asignada a
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $task->assignee?->name ?? 'Sin asignar' }}
                    </p>
                </div>


                {{-- Fecha de asignación --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Fecha de asignación
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $task->assigned_at?->format('d/m/Y H:i') ?? 'Sin asignar' }}
                    </p>
                </div>


                {{-- Fecha límite --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Fecha límite
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $task->due_date?->format('d/m/Y') ?? 'Sin fecha límite' }}
                    </p>
                </div>


                {{-- Tiempo estimado --}}
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


        {{-- Comentarios --}}
        <div class="mt-6 bg-blue-100 rounded-2xl shadow-sm p-6">

            <div class="mb-6">

                <h2 class="text-xl font-semibold text-gray-800">
                    Comentarios
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Conversación relacionada con esta tarea.
                </p>

            </div>


            {{-- Lista de comentarios --}}
            <div class="space-y-4">

                @forelse ($task->comments()->with('user')->latest()->get() as $comment)

                    <div class="bg-white border border-gray-200 rounded-xl p-4">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="font-semibold text-gray-800">
                                    {{ $comment->user->name }}
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $comment->created_at->format('d/m/Y H:i') }}
                                </p>

                            </div>

                        </div>


                        <p class="text-gray-700 mt-3 whitespace-pre-line">
                            {{ $comment->content }}
                        </p>

                    </div>

                @empty

                    <div class="bg-white border border-gray-200 rounded-xl p-6 text-center">

                        <p class="text-sm text-gray-500">
                            Todavía no hay comentarios en esta tarea.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Agregar comentario --}}
            <div class="mt-6 pt-6 border-t border-gray-300">

                <h3 class="text-sm font-semibold text-gray-800 mb-3">
                    Agregar comentario
                </h3>

                <form
                    method="POST"
                    action="{{ route('comments.store', [$team, $task]) }}"
                >

                    @csrf

                    <textarea
                        name="content"
                        rows="4"
                        maxlength="2000"
                        required
                        placeholder="Escribe un comentario..."
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ old('content') }}</textarea>

                    @error('content')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror


                    <div class="flex justify-end mt-3">

                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                        >
                            Comentar
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-authenticated-layout>