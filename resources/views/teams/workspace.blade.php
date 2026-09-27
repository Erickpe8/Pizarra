<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

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

                    <div>

                        <h2 class="text-xl font-semibold text-gray-900">
                            Tablero de tareas
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Arrastra las tareas para cambiar su estado.
                        </p>

                    </div>

                    @if (auth()->user()->hasRole('lider'))

                        <a
                            href="{{ route('tasks.create', $team) }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                        >
                            + Crear tarea
                        </a>

                    @endif

                </div>

                <div class="mb-6 bg-white border border-gray-200 rounded-xl p-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

                        <div>

                            <label
                                for="task-search"
                                class="block mb-2 text-sm font-medium text-gray-700"
                            >
                                Buscar tarea
                            </label>

                            <input
                                type="text"
                                id="task-search"
                                placeholder="Buscar por nombre o descripción..."
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            >

                        </div>

                        <div>

                            <label
                                for="status-filter"
                                class="block mb-2 text-sm font-medium text-gray-700"
                            >
                                Filtrar por estado
                            </label>

                            <select
                                id="status-filter"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            >

                                <option value="todos">
                                    Todos los estados
                                </option>

                                <option value="por hacer">
                                    Por hacer
                                </option>

                                <option value="en progreso">
                                    En progreso
                                </option>

                                <option value="terminada">
                                    Terminada
                                </option>

                            </select>

                        </div>

                        <div>

                            <label
                                for="assignee-filter"
                                class="block mb-2 text-sm font-medium text-gray-700"
                            >
                                Asignado a
                            </label>

                            <select
                                id="assignee-filter"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            >

                                <option value="todos">
                                    Todos los integrantes
                                </option>

                                @foreach ($team->users()->orderBy('name')->get() as $member)

                                    <option value="{{ $member->id }}">
                                        {{ $member->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>
                        <div>
                            <label
                                for="due-date-filter"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Fecha de vencimiento
                            </label>

                            <select
                                id="due-date-filter"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="todos">Todas las fechas</option>
                                <option value="sin_fecha">Sin fecha</option>
                                <option value="hoy">Vence hoy</option>
                                <option value="proximos_7">Próximos 7 días</option>
                                <option value="vencidas">Vencidas</option>
                            </select>
                        </div>

                    </div>

                </div>

                <x-flash-message />


                <div
                    id="kanban-board"
                    class="gap-5 items-start"
                    style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));"
                >

                    <div
                        class="kanban-column bg-gray-50 rounded-xl border border-gray-200 p-4"
                        data-status="por hacer"
                    >

                        <div class="flex items-center justify-between mb-4">

                            <h3 class="font-semibold text-gray-800">
                                Por hacer
                            </h3>

                            <span
                                class="kanban-count inline-flex items-center justify-center min-w-7 h-7 px-2 text-sm font-semibold text-indigo-700 bg-indigo-100 rounded-full"
                            >
                                {{ $tasks->where('status', 'por hacer')->count() }}
                            </span>

                        </div>


                        <div
                            class="kanban-tasks min-h-24 space-y-3"
                            data-status="por hacer"
                        >

                            @forelse ($tasks->where('status', 'por hacer') as $task)

                                <div
                                    class="kanban-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm cursor-grab hover:shadow-md hover:border-indigo-400 hover:-translate-y-0.5 transition-all duration-150"                                    draggable="true"
                                    draggable="true"
                                    data-task-id="{{ $task->id }}"
                                    data-status="por hacer"
                                    data-assignee="{{ $task->assigned_to }}"
                                    data-due-date="{{ $task->due_date?->format('Y-m-d') }}"
                                >

                                    <a
                                        href="{{ route('tasks.show', [$team, $task]) }}"
                                        class="block"
                                    >

                                        <h4 class="font-semibold text-gray-800">
                                            {{ $task->title }}
                                        </h4>

                                        @if ($task->description)

                                            <p class="mt-2 text-sm text-gray-500 line-clamp-2">
                                                {{ $task->description }}
                                            </p>

                                        @endif

                                        @if ($task->assignee)

                                            <p class="mt-3 text-xs text-gray-500">
                                                Asignada a:
                                                <span class="font-medium text-gray-700">
                                                    {{ $task->assignee->name }}
                                                </span>
                                            </p>

                                        @endif

                                       @if ($task->due_date)

                                            @php
                                                $today = now()->startOfDay();
                                                $dueDate = $task->due_date->copy()->startOfDay();

                                                if ($dueDate->lt($today)) {
                                                    $dueDateClass = 'text-red-600 bg-red-50';
                                                    $dueDateLabel = 'Vencida';
                                                } elseif ($dueDate->equalTo($today)) {
                                                    $dueDateClass = 'text-orange-600 bg-orange-50';
                                                    $dueDateLabel = 'Vence hoy';
                                                } else {
                                                    $dueDateClass = 'text-green-600 bg-green-50';
                                                    $dueDateLabel = 'En plazo';
                                                }
                                            @endphp

                                            <div class="mt-3 flex items-center justify-between gap-2">

                                                <span class="text-xs text-gray-500">
                                                    Vencimiento:
                                                    {{ $task->due_date->format('d/m/Y') }}
                                                </span>

                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-medium {{ $dueDateClass }}"
                                                >
                                                    {{ $dueDateLabel }}
                                                </span>

                                            </div>

                                        @endif

                                    </a>

                                </div>

                            @empty

                                <div
                                    class="kanban-empty text-center py-8 px-4 text-sm text-gray-400 border-2 border-dashed border-gray-200 rounded-xl"
                                >
                                    No hay tareas por hacer.
                                </div>

                            @endforelse

                        </div>

                    </div>

                    <div
                        class="kanban-column bg-gray-50 rounded-xl border border-gray-200 p-4"
                        data-status="en progreso"
                    >

                        <div class="flex items-center justify-between mb-4">

                            <h3 class="font-semibold text-gray-800">
                                En progreso
                            </h3>

                            <span
                                class="kanban-count inline-flex items-center justify-center min-w-7 h-7 px-2 text-sm font-semibold text-amber-700 bg-amber-100 rounded-full"
                            >
                                {{ $tasks->where('status', 'en progreso')->count() }}
                            </span>

                        </div>


                        <div
                            class="kanban-tasks min-h-24 space-y-3"
                            data-status="en progreso"
                        >

                            @forelse ($tasks->where('status', 'en progreso') as $task)

                                <div
                                    class="kanban-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm cursor-grab hover:shadow-md hover:border-indigo-400 hover:-translate-y-0.5 transition-all duration-150"
                                    draggable="true"
                                    data-task-id="{{ $task->id }}"
                                    data-status="en progreso"
                                    data-assignee="{{ $task->assigned_to }}"
                                    data-due-date="{{ $task->due_date?->format('Y-m-d') }}">

                                    <a
                                        href="{{ route('tasks.show', [$team, $task]) }}"
                                        class="block"
                                    >

                                        <h4 class="font-semibold text-gray-800">
                                            {{ $task->title }}
                                        </h4>

                                        @if ($task->description)

                                            <p class="mt-2 text-sm text-gray-500 line-clamp-2">
                                                {{ $task->description }}
                                            </p>

                                        @endif

                                        @if ($task->assignee)

                                            <p class="mt-3 text-xs text-gray-500">
                                                Asignada a:
                                                <span class="font-medium text-gray-700">
                                                    {{ $task->assignee->name }}
                                                </span>
                                            </p>

                                        @endif

                                        @if ($task->due_date)

                                            @php
                                                $today = now()->startOfDay();
                                                $dueDate = $task->due_date->copy()->startOfDay();

                                                if ($dueDate->lt($today)) {
                                                    $dueDateClass = 'text-red-600 bg-red-50';
                                                    $dueDateLabel = 'Vencida';
                                                } elseif ($dueDate->equalTo($today)) {
                                                    $dueDateClass = 'text-orange-600 bg-orange-50';
                                                    $dueDateLabel = 'Vence hoy';
                                                } else {
                                                    $dueDateClass = 'text-green-600 bg-green-50';
                                                    $dueDateLabel = 'En plazo';
                                                }
                                            @endphp

                                            <div class="mt-3 flex items-center justify-between gap-2">

                                                <span class="text-xs text-gray-500">
                                                    Vencimiento:
                                                    {{ $task->due_date->format('d/m/Y') }}
                                                </span>

                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-medium {{ $dueDateClass }}"
                                                >
                                                    {{ $dueDateLabel }}
                                                </span>

                                            </div>

                                        @endif

                                    </a>

                                </div>

                            @empty

                                <div
                                    class="kanban-empty text-center py-8 px-4 text-sm text-gray-400 border-2 border-dashed border-gray-200 rounded-xl"
                                >
                                    No hay tareas en progreso.
                                </div>

                            @endforelse

                        </div>

                    </div>

                    <div
                        class="kanban-column bg-gray-50 rounded-xl border border-gray-200 p-4"
                        data-status="terminada"
                    >

                        <div class="flex items-center justify-between mb-4">

                            <h3 class="font-semibold text-gray-800">
                                Terminada
                            </h3>

                            <span
                                class="kanban-count inline-flex items-center justify-center min-w-7 h-7 px-2 text-sm font-semibold text-green-700 bg-green-100 rounded-full"
                            >
                                {{ $tasks->where('status', 'terminada')->count() }}
                            </span>

                        </div>


                        <div
                            class="kanban-tasks min-h-24 space-y-3"
                            data-status="terminada"
                        >

                            @forelse ($tasks->where('status', 'terminada') as $task)

                                <div
                                    class="kanban-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm cursor-grab hover:shadow-md hover:border-indigo-400 hover:-translate-y-0.5 transition-all duration-150"                                    draggable="true"
                                    draggable="true"    
                                    data-task-id="{{ $task->id }}"
                                    data-status="terminada"
                                    data-assignee="{{ $task->assigned_to }}"
                                    data-due-date="{{ $task->due_date?->format('Y-m-d') }}"
                                >

                                    <a
                                        href="{{ route('tasks.show', [$team, $task]) }}"
                                        class="block"
                                    >

                                        <h4 class="font-semibold text-gray-800">
                                            {{ $task->title }}
                                        </h4>

                                        @if ($task->description)

                                            <p class="mt-2 text-sm text-gray-500 line-clamp-2">
                                                {{ $task->description }}
                                            </p>

                                        @endif

                                        @if ($task->assignee)

                                            <p class="mt-3 text-xs text-gray-500">
                                                Asignada a:
                                                <span class="font-medium text-gray-700">
                                                    {{ $task->assignee->name }}
                                                </span>
                                            </p>

                                        @endif

                                        @if ($task->due_date)

                                            @php
                                                $today = now()->startOfDay();
                                                $dueDate = $task->due_date->copy()->startOfDay();

                                                if ($dueDate->lt($today)) {
                                                    $dueDateClass = 'text-red-600 bg-red-50';
                                                    $dueDateLabel = 'Vencida';
                                                } elseif ($dueDate->equalTo($today)) {
                                                    $dueDateClass = 'text-orange-600 bg-orange-50';
                                                    $dueDateLabel = 'Vence hoy';
                                                } else {
                                                    $dueDateClass = 'text-green-600 bg-green-50';
                                                    $dueDateLabel = 'En plazo';
                                                }
                                            @endphp

                                            <div class="mt-3 flex items-center justify-between gap-2">

                                                <span class="text-xs text-gray-500">
                                                    Vencimiento:
                                                    {{ $task->due_date->format('d/m/Y') }}
                                                </span>

                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-medium {{ $dueDateClass }}"
                                                >
                                                    {{ $dueDateLabel }}
                                                </span>

                                            </div>

                                        @endif

                                    </a>

                                </div>

                            @empty

                                <div
                                    class="kanban-empty text-center py-8 px-4 text-sm text-gray-400 border-2 border-dashed border-gray-200 rounded-xl"
                                >
                                    No hay tareas terminadas.
                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const cards = document.querySelectorAll('.kanban-card');
            const columns = document.querySelectorAll('.kanban-tasks');

            let draggedCard = null;
            let originalColumn = null;
            let originalStatus = null;

            cards.forEach(function (card) {

                card.addEventListener('dragstart', function (event) {

                    draggedCard = card;
                    originalColumn = card.parentElement;
                    originalStatus = card.dataset.status;

                    card.classList.add('opacity-50','scale-95','rotate-1');

                    event.dataTransfer.effectAllowed = 'move';

                    event.dataTransfer.setData(
                        'text/plain',
                        card.dataset.taskId
                    );

                });


                card.addEventListener('dragend', function () {

                    card.classList.remove('opacity-50','scale-95','rotate-1');

                    draggedCard = null;

                });

            });

            columns.forEach(function (column) {

                column.addEventListener('dragover', function (event) {

                    event.preventDefault();

                    event.dataTransfer.dropEffect = 'move';

                    column.classList.add(
                        'bg-indigo-50',
                        'border-indigo-300'
                    );

                });


                column.addEventListener('dragleave', function () {

                    column.classList.remove(
                        'bg-indigo-50',
                        'border-indigo-300'
                    );

                });

                column.addEventListener('drop', async function (event) {

                    event.preventDefault();

                    column.classList.remove(
                        'bg-indigo-50',
                        'border-indigo-300'
                    );


                    if (!draggedCard) {
                        return;
                    }


                    const newStatus = column.dataset.status;

                    if (newStatus === originalStatus) {
                        return;
                    }


                    const taskId = draggedCard.dataset.taskId;

                    const previousColumn = originalColumn;

                    const emptyMessage =
                        column.querySelector('.kanban-empty');

                    if (emptyMessage) {
                        emptyMessage.remove();
                    }

                    column.appendChild(draggedCard);

                    draggedCard.dataset.status = newStatus;


                    try {

                        const response = await fetch(
                            '{{ route('tasks.status', [$team, '__TASK__']) }}'
                                .replace('__TASK__', taskId),
                            {
                                method: 'PATCH',

                                headers: {
                                    'Content-Type': 'application/json',

                                    'Accept': 'application/json',

                                    'X-CSRF-TOKEN':
                                        document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            ?.getAttribute('content'),

                                    'X-Requested-With': 'XMLHttpRequest',
                                },

                                body: JSON.stringify({
                                    status: newStatus,
                                }),
                            }
                        );


                        if (!response.ok) {

                            throw new Error(
                                'No se pudo actualizar la tarea.'
                            );

                        }


                        const data = await response.json();


                        showKanbanNotification(
                            data.message ||
                            'La tarea se movió correctamente.',
                            'success'
                        );


                        updateKanbanCounts();


                    } catch (error) {

                        previousColumn.appendChild(draggedCard);

                        draggedCard.dataset.status = originalStatus;


                        showKanbanNotification(
                            'No se pudo mover la tarea.',
                            'error'
                        );


                        updateKanbanCounts();

                    }

                });

            });


            function updateKanbanCounts() {

                document
                    .querySelectorAll('.kanban-column')
                    .forEach(function (column) {

                        const tasksContainer =
                            column.querySelector('.kanban-tasks');

                        const count =
                            tasksContainer.querySelectorAll(
                                '.kanban-card'
                            ).length;

                        const counter =
                            column.querySelector('.kanban-count');

                        counter.textContent = count;

                        const empty =
                            tasksContainer.querySelector(
                                '.kanban-empty'
                            );


                        if (count === 0 && !empty) {

                            const emptyMessage =
                                document.createElement('div');

                            emptyMessage.className =
                                'kanban-empty text-center py-8 px-4 text-sm text-gray-400 border-2 border-dashed border-gray-200 rounded-xl';

                            const status =
                                tasksContainer.dataset.status;


                            if (status === 'por hacer') {

                                emptyMessage.textContent =
                                    'No hay tareas por hacer.';

                            } else if (status === 'en progreso') {

                                emptyMessage.textContent =
                                    'No hay tareas en progreso.';

                            } else {

                                emptyMessage.textContent =
                                    'No hay tareas terminadas.';

                            }


                            tasksContainer.appendChild(
                                emptyMessage
                            );

                        }

                    });

            }

            function showKanbanNotification(message, type) {

                const existing =
                    document.querySelector(
                        '#kanban-notification'
                    );

                if (existing) {
                    existing.remove();
                }


                const notification =
                    document.createElement('div');

                notification.id =
                    'kanban-notification';


                const colorClasses =
                    type === 'success'
                        ? 'text-green-800 bg-green-50 border-green-200'
                        : 'text-red-800 bg-red-50 border-red-200';


                notification.className =
                    `fixed top-5 right-5 z-50 max-w-sm px-4 py-3 border rounded-lg shadow-lg text-sm font-medium ${colorClasses}`;


                notification.textContent = message;


                document.body.appendChild(
                    notification
                );


                setTimeout(function () {

                    notification.remove();

                }, 3000);

            }

            const taskSearch = document.getElementById('task-search');

            const statusFilter = document.getElementById('status-filter');


            function filterKanbanTasks() {

                const search =
                    taskSearch.value
                        .toLowerCase()
                        .trim();

                const selectedStatus =
                    statusFilter.value;
            
                const selectedAssignee =
                    document.getElementById('assignee-filter').value;

                const selectedDueDate =
                    document.getElementById('due-date-filter').value;


                document
                    .querySelectorAll('.kanban-column')
                    .forEach(function (column) {

                        const columnStatus =
                            column.dataset.status;

                        const cards =
                            column.querySelectorAll('.kanban-card');

                        let visibleCards = 0;


                        cards.forEach(function (card) {

                            const title =
                                card
                                    .querySelector('h4')
                                    ?.textContent
                                    .toLowerCase() || '';

                            const description =
                                card
                                    .querySelector('p')
                                    ?.textContent
                                    .toLowerCase() || '';

                            const matchesSearch =
                                search === '' ||
                                title.includes(search) ||
                                description.includes(search);

                            const matchesStatus =
                                selectedStatus === 'todos' ||
                                columnStatus === selectedStatus;

                            const cardAssignee =
                                card.dataset.assignee;

                            const matchesAssignee =
                                selectedAssignee === 'todos' ||
                                cardAssignee === selectedAssignee;

                            const cardDueDate =
                                card.dataset.dueDate;

                            const today =
                                new Date();

                            today.setHours(0, 0, 0, 0);

                            const dueDate =
                                cardDueDate
                                    ? new Date(cardDueDate + 'T00:00:00')
                                    : null;

                            let matchesDueDate = true;

                            if (selectedDueDate === 'sin_fecha') {

                                matchesDueDate =
                                    !cardDueDate;

                            } else if (selectedDueDate === 'hoy') {

                                matchesDueDate =
                                    dueDate &&
                                    dueDate.getTime() === today.getTime();

                            } else if (selectedDueDate === 'proximos_7') {

                                if (!dueDate) {

                                    matchesDueDate = false;

                                } else {

                                    const sevenDaysFromNow =
                                        new Date(today);

                                    sevenDaysFromNow.setDate(
                                        sevenDaysFromNow.getDate() + 7
                                    );

                                    matchesDueDate =
                                        dueDate >= today &&
                                        dueDate <= sevenDaysFromNow;
                                }

                            } else if (selectedDueDate === 'vencidas') {

                                matchesDueDate =
                                    dueDate &&
                                    dueDate < today;
                            }

                            const shouldShow =
                                matchesSearch &&
                                matchesStatus &&
                                matchesAssignee &&
                                matchesDueDate;


                            if (shouldShow) {

                                card.style.display = '';

                                visibleCards++;

                            } else {

                                card.style.display = 'none';

                            }

                        });

                        let filterMessage =
                            column.querySelector('.kanban-filter-empty');


                        if (visibleCards === 0) {

                            if (!filterMessage) {

                                filterMessage =
                                    document.createElement('div');

                                filterMessage.className =
                                    'kanban-filter-empty text-center py-8 px-4 text-sm text-gray-400 border-2 border-dashed border-gray-200 rounded-xl';

                                filterMessage.textContent =
                                    'No hay tareas que coincidan con el filtro.';

                                column
                                    .querySelector('.kanban-tasks')
                                    .appendChild(filterMessage);

                            }

                            filterMessage.style.display = '';

                        } else {

                            if (filterMessage) {

                                filterMessage.style.display = 'none';

                            }

                        }

                    });

            }


            taskSearch.addEventListener(
                'input',
                filterKanbanTasks
            );


            statusFilter.addEventListener(
                'change',
                filterKanbanTasks
            );

            document
                .getElementById('assignee-filter')
                .addEventListener(
                    'change',
                    filterKanbanTasks
                );
            
            document
                .getElementById('due-date-filter')
                .addEventListener(
                    'change',
                    filterKanbanTasks
                );

        });

    </script>

</x-app-layout>