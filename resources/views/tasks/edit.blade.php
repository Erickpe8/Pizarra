<x-authenticated-layout>

    <div class="max-w-4xl mx-auto px-6 py-8">

        <div class="bg-blue-100 rounded-2xl shadow-sm p-6">

            <div class="flex items-center justify-between mb-6">

                <div>
                    <p class="text-sm text-gray-500">
                        Editar tarea
                    </p>

                    <h1 class="text-2xl font-bold text-gray-800">
                        {{ $task->title }}
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Equipo: {{ $team->name }}
                    </p>
                </div>

                <a
                    href="{{ route('tasks.show', [$team, $task]) }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition"
                >
                    ← Cancelar
                </a>

            </div>


            @if ($errors->any())

                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">

                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('tasks.update', [$team, $task]) }}"
                class="space-y-6"
            >

                @csrf
                @method('PUT')

                <div>

                    <label
                        for="title"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Título
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $task->title) }}"
                        required
                        maxlength="255"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >

                </div>

                <div>

                    <label
                        for="description"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Descripción
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ old('description', $task->description) }}</textarea>

                </div>

                <div>

                    <label
                        for="status"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Estado
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >

                        <option
                            value="por hacer"
                            @selected(old('status', $task->status) === 'por hacer')
                        >
                            Por hacer
                        </option>

                        <option
                            value="en progreso"
                            @selected(old('status', $task->status) === 'en progreso')
                        >
                            En progreso
                        </option>

                        <option
                            value="terminada"
                            @selected(old('status', $task->status) === 'terminada')
                        >
                            Terminada
                        </option>

                    </select>

                </div>

                <div>

                    <label
                        for="assigned_to"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Asignar a
                    </label>

                    <select
                        id="assigned_to"
                        name="assigned_to"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >

                        <option value="">
                            Sin asignar
                        </option>

                        @foreach ($members as $member)

                            <option
                                value="{{ $member->id }}"
                                @selected((string) old('assigned_to', $task->assigned_to) === (string) $member->id)
                            >
                                {{ $member->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div>

                    <label
                        for="assigned_at"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Fecha de asignación
                    </label>

                    <input
                        type="datetime-local"
                        id="assigned_at"
                        name="assigned_at"
                        value="{{ old('assigned_at', $task->assigned_at?->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >

                </div>

                <div>

                    <label
                        for="due_date"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Fecha límite
                    </label>

                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                        value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >

                </div>

                <div>

                    <label
                        for="estimated_time"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Tiempo estimado (minutos)
                    </label>

                    <input
                        type="number"
                        id="estimated_time"
                        name="estimated_time"
                        min="0"
                        value="{{ old('estimated_time', $task->estimated_time) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >

                </div>


                <div class="flex justify-end gap-3 pt-4">

                    <a
                        href="{{ route('tasks.show', [$team, $task]) }}"
                        class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                    >
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-authenticated-layout>