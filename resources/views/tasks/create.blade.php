<x-authenticated-layout>

    <div class="max-w-4xl mx-auto">

        <div class="mb-8">

            <p class="text-sm font-semibold text-indigo-700">
                Nueva tarea
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                Crear tarea
            </h1>

            <p class="mt-2 text-gray-700">
                Equipo: <strong>{{ $team->name }}</strong>
            </p>

        </div>


        @if (session('success'))

            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800">
                {{ session('success') }}
            </div>

        @endif


        <form
            method="POST"
            action="{{ route('tasks.store', $team) }}"
            class="bg-blue-100 rounded-xl shadow-sm border border-blue-200 p-6 space-y-6"
        >

            @csrf

            <div>

                <label
                    for="title"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Título
                </label>

                <input
                    id="title"
                    name="title"
                    type="text"
                    value="{{ old('title') }}"
                    required
                    maxlength="255"
                    class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Ej. Diseñar pantalla de inicio"
                >

                @error('title')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div>

                <label
                    for="description"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Descripción
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Describe lo que debe realizarse..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div>

                <label
                    for="status"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Estado
                </label>

                <select
                    id="status"
                    name="status"
                    required
                    class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >

                    <option
                        value="por hacer"
                        @selected(old('status', 'por hacer') === 'por hacer')
                    >
                        Por hacer
                    </option>

                    <option
                        value="en progreso"
                        @selected(old('status') === 'en progreso')
                    >
                        En progreso
                    </option>

                    <option
                        value="terminada"
                        @selected(old('status') === 'terminada')
                    >
                        Terminada
                    </option>

                </select>

                @error('status')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div>

                <label
                    for="assigned_to"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Asignar a
                </label>

                <select
                    id="assigned_to"
                    name="assigned_to"
                    class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >

                    <option value="">
                        Sin asignar
                    </option>

                    @foreach ($members as $member)

                        <option
                            value="{{ $member->id }}"
                            @selected((string) old('assigned_to') === (string) $member->id)
                        >
                            {{ $member->name }} — {{ $member->email }}
                        </option>

                    @endforeach

                </select>

                @error('assigned_to')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div>

                <label
                    for="assigned_at"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Fecha de asignación
                </label>

                <input
                    id="assigned_at"
                    name="assigned_at"
                    type="datetime-local"
                    value="{{ old('assigned_at') }}"
                    class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >

                @error('assigned_at')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div>

                <label
                    for="due_date"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Fecha de entrega / fecha límite
                </label>

                <input
                    id="due_date"
                    name="due_date"
                    type="date"
                    value="{{ old('due_date') }}"
                    class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >

                @error('due_date')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div>

                <label
                    for="estimated_time"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Tiempo de desarrollo estimado (minutos)
                </label>

                <input
                    id="estimated_time"
                    name="estimated_time"
                    type="number"
                    min="0"
                    value="{{ old('estimated_time') }}"
                    class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Ej. 120"
                >

                @error('estimated_time')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>



            <div class="flex flex-wrap gap-3 pt-4">

                <button
                    type="submit"
                    class="px-5 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition"
                >
                    Crear tarea
                </button>

                <x-flash-message />

                <a
                    href="{{ route('teams.workspace', $team) }}"
                    class="px-5 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</x-authenticated-layout>