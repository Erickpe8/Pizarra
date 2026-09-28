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

        /**
             * Inicializa todas las funcionalidades interactivas
             * del tablero Kanban cuando el documento ha terminado
             * de cargarse.
             *
             * Las funcionalidades incluyen:
             *
             * - Arrastrar y soltar tareas entre columnas.
             * - Actualizar el estado de una tarea mediante AJAX.
             * - Actualizar los contadores de las columnas.
             * - Mostrar notificaciones al usuario.
             * - Buscar y filtrar tareas.
             *
             * @listens DOMContentLoaded
             */
            document.addEventListener('DOMContentLoaded', function () {

                /**
                 * Obtiene todas las tarjetas de tareas del tablero.
                 *
                 * @type {NodeListOf<Element>}
                 */
                const cards =
                    document.querySelectorAll('.kanban-card');

                /**
                 * Obtiene los contenedores de tareas de las
                 * diferentes columnas del tablero.
                 *
                 * @type {NodeListOf<Element>}
                 */
                const columns =
                    document.querySelectorAll('.kanban-tasks');

                /**
                 * Tarjeta que actualmente está siendo arrastrada.
                 *
                 * @type {Element|null}
                 */
                let draggedCard = null;

                /**
                 * Columna donde se encontraba originalmente
                 * la tarjeta antes de ser movida.
                 *
                 * @type {Element|null}
                 */
                let originalColumn = null;

                /**
                 * Estado que tenía originalmente la tarea
                 * antes de comenzar el arrastre.
                 *
                 * @type {string|null}
                 */
                let originalStatus = null;


                /**
                 * Configura los eventos de arrastre para cada
                 * tarjeta de tarea.
                 *
                 * @param {Element} card Tarjeta de tarea que se está configurando.
                 * @returns {void}
                 */
                cards.forEach(function (card) {

                    /**
                     * Ejecuta la lógica inicial cuando el usuario
                     * comienza a arrastrar una tarea.
                     *
                     * Guarda la tarjeta, su columna y su estado
                     * original para poder restaurarlos si ocurre
                     * algún error.
                     *
                     * @param {DragEvent} event Evento generado al comenzar el arrastre.
                     * @returns {void}
                     */
                    card.addEventListener('dragstart', function (event) {

                        draggedCard = card;

                        originalColumn = card.parentElement;

                        originalStatus = card.dataset.status;

                        /**
                         * Aplica estilos visuales para indicar
                         * que la tarjeta está siendo arrastrada.
                         */
                        card.classList.add(
                            'opacity-50',
                            'scale-95',
                            'rotate-1'
                        );

                        /**
                         * Indica que la operación de arrastre
                         * permite mover la tarjeta.
                         */
                        event.dataTransfer.effectAllowed = 'move';

                        /**
                         * Guarda el identificador de la tarea
                         * dentro de los datos de la operación
                         * de arrastre.
                         *
                         * @type {string}
                         */
                        event.dataTransfer.setData(
                            'text/plain',
                            card.dataset.taskId
                        );

                    });


                    /**
                     * Ejecuta la limpieza visual cuando termina
                     * el arrastre de una tarea.
                     *
                     * @returns {void}
                     */
                    card.addEventListener('dragend', function () {

                        /**
                         * Elimina los estilos utilizados durante
                         * el arrastre.
                         */
                        card.classList.remove(
                            'opacity-50',
                            'scale-95',
                            'rotate-1'
                        );

                        /**
                         * Limpia la referencia de la tarjeta
                         * que estaba siendo arrastrada.
                         */
                        draggedCard = null;

                    });

                });


                /**
                 * Configura los eventos necesarios para que cada
                 * columna pueda recibir tareas arrastradas.
                 *
                 * @param {Element} column Columna del tablero Kanban.
                 * @returns {void}
                 */
                columns.forEach(function (column) {

                    /**
                     * Permite que una tarjeta pueda ser soltada
                     * dentro de la columna.
                     *
                     * @param {DragEvent} event Evento generado mientras
                     * el usuario arrastra una tarjeta sobre la columna.
                     * @returns {void}
                     */
                    column.addEventListener('dragover', function (event) {

                        event.preventDefault();

                        /**
                         * Indica visualmente que la tarjeta puede
                         * ser movida a esta columna.
                         */
                        event.dataTransfer.dropEffect = 'move';

                        column.classList.add(
                            'bg-indigo-50',
                            'border-indigo-300'
                        );

                    });


                    /**
                     * Elimina los estilos visuales de una columna
                     * cuando la tarjeta deja de estar sobre ella.
                     *
                     * @returns {void}
                     */
                    column.addEventListener('dragleave', function () {

                        column.classList.remove(
                            'bg-indigo-50',
                            'border-indigo-300'
                        );

                    });


                    /**
                     * Procesa el movimiento de una tarea cuando
                     * el usuario la suelta dentro de una columna.
                     *
                     * Actualiza visualmente la tarea y posteriormente
                     * envía el nuevo estado al servidor mediante
                     * una petición PATCH.
                     *
                     * Si la actualización falla, la tarea vuelve
                     * a su columna y estado originales.
                     *
                     * @param {DragEvent} event Evento generado al soltar
                     * la tarjeta.
                     * @returns {Promise<void>}
                     */
                    column.addEventListener('drop', async function (event) {

                        event.preventDefault();

                        column.classList.remove(
                            'bg-indigo-50',
                            'border-indigo-300'
                        );


                        /**
                         * No realizar ninguna acción si actualmente
                         * no existe una tarjeta siendo arrastrada.
                         */
                        if (!draggedCard) {
                            return;
                        }


                        /**
                         * Obtiene el nuevo estado asociado
                         * a la columna seleccionada.
                         *
                         * @type {string}
                         */
                        const newStatus =
                            column.dataset.status;


                        /**
                         * Si la tarea ya pertenece a esta columna,
                         * no es necesario realizar ninguna actualización.
                         */
                        if (newStatus === originalStatus) {
                            return;
                        }


                        /**
                         * Obtiene el identificador de la tarea.
                         *
                         * @type {string}
                         */
                        const taskId =
                            draggedCard.dataset.taskId;


                        /**
                         * Guarda la columna original para poder
                         * restaurar la tarea si la petición falla.
                         *
                         * @type {Element|null}
                         */
                        const previousColumn =
                            originalColumn;


                        /**
                         * Busca el mensaje que indica que una columna
                         * está vacía y lo elimina si existe.
                         */
                        const emptyMessage =
                            column.querySelector('.kanban-empty');

                        if (emptyMessage) {
                            emptyMessage.remove();
                        }


                        /**
                         * Mueve visualmente la tarjeta a la
                         * nueva columna.
                         */
                        column.appendChild(draggedCard);

                        /**
                         * Actualiza temporalmente el estado
                         * de la tarjeta en el DOM.
                         */
                        draggedCard.dataset.status = newStatus;


                        try {

                            /**
                             * Envía al servidor el nuevo estado
                             * de la tarea mediante una petición PATCH.
                             *
                             * @type {Response}
                             */
                            const response = await fetch(
                                '{{ route('tasks.status', [$team, '__TASK__']) }}'
                                    .replace('__TASK__', taskId),
                                {
                                    method: 'PATCH',

                                    headers: {
                                        'Content-Type':
                                            'application/json',

                                        'Accept':
                                            'application/json',

                                        'X-CSRF-TOKEN':
                                            document
                                                .querySelector(
                                                    'meta[name="csrf-token"]'
                                                )
                                                ?.getAttribute('content'),

                                        'X-Requested-With':
                                            'XMLHttpRequest',
                                    },

                                    body: JSON.stringify({
                                        status: newStatus,
                                    }),
                                }
                            );


                            /**
                             * Comprueba si el servidor respondió
                             * correctamente.
                             */
                            if (!response.ok) {

                                throw new Error(
                                    'No se pudo actualizar la tarea.'
                                );

                            }


                            /**
                             * Convierte la respuesta del servidor
                             * a un objeto JavaScript.
                             *
                             * @type {Object}
                             */
                            const data =
                                await response.json();


                            /**
                             * Muestra una notificación indicando
                             * que la tarea fue movida correctamente.
                             */
                            showKanbanNotification(
                                data.message ||
                                'La tarea se movió correctamente.',
                                'success'
                            );


                            /**
                             * Actualiza los contadores de las
                             * columnas del tablero.
                             */
                            updateKanbanCounts();


                        } catch (error) {

                            /**
                             * Si la petición falla, devuelve la tarjeta
                             * a su columna anterior.
                             */
                            previousColumn.appendChild(
                                draggedCard
                            );

                            /**
                             * Restaura el estado original de la tarea.
                             */
                            draggedCard.dataset.status =
                                originalStatus;


                            /**
                             * Informa al usuario que el movimiento
                             * no pudo guardarse.
                             */
                            showKanbanNotification(
                                'No se pudo mover la tarea.',
                                'error'
                            );


                            /**
                             * Actualiza nuevamente los contadores
                             * después de restaurar la tarjeta.
                             */
                            updateKanbanCounts();

                        }

                    });

                });


                /**
                 * Actualiza la cantidad de tareas mostrada
                 * en cada columna del tablero Kanban.
                 *
                 * También crea un mensaje cuando una columna
                 * queda completamente vacía.
                 *
                 * @returns {void}
                 */
                function updateKanbanCounts() {

                    document
                        .querySelectorAll('.kanban-column')
                        .forEach(function (column) {

                            /**
                             * Obtiene el contenedor de tareas
                             * de la columna actual.
                             *
                             * @type {Element|null}
                             */
                            const tasksContainer =
                                column.querySelector('.kanban-tasks');


                            /**
                             * Cuenta las tarjetas existentes
                             * dentro de la columna.
                             *
                             * @type {number}
                             */
                            const count =
                                tasksContainer.querySelectorAll(
                                    '.kanban-card'
                                ).length;


                            /**
                             * Obtiene el elemento encargado de
                             * mostrar el contador de la columna.
                             *
                             * @type {Element|null}
                             */
                            const counter =
                                column.querySelector('.kanban-count');


                            /**
                             * Actualiza visualmente el contador.
                             */
                            counter.textContent = count;


                            /**
                             * Comprueba si ya existe un mensaje
                             * indicando que la columna está vacía.
                             *
                             * @type {Element|null}
                             */
                            const empty =
                                tasksContainer.querySelector(
                                    '.kanban-empty'
                                );


                            /**
                             * Si la columna está vacía y todavía
                             * no existe un mensaje, crea uno.
                             */
                            if (count === 0 && !empty) {

                                /**
                                 * Crea el elemento que mostrará
                                 * el mensaje de columna vacía.
                                 *
                                 * @type {HTMLDivElement}
                                 */
                                const emptyMessage =
                                    document.createElement('div');


                                emptyMessage.className =
                                    'kanban-empty text-center py-8 px-4 text-sm text-gray-400 border-2 border-dashed border-gray-200 rounded-xl';


                                /**
                                 * Obtiene el estado correspondiente
                                 * a la columna.
                                 *
                                 * @type {string|undefined}
                                 */
                                const status =
                                    tasksContainer.dataset.status;


                                /**
                                 * Define el mensaje correspondiente
                                 * al estado de la columna.
                                 */
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


                                /**
                                 * Agrega el mensaje al contenedor
                                 * de tareas de la columna.
                                 */
                                tasksContainer.appendChild(
                                    emptyMessage
                                );

                            }

                        });

                }


                /**
                 * Muestra una notificación temporal en la parte
                 * superior derecha del tablero Kanban.
                 *
                 * @param {string} message Mensaje que se mostrará al usuario.
                 * @param {'success'|'error'} type Tipo de notificación.
                 * @returns {void}
                 */
                function showKanbanNotification(message, type) {

                    /**
                     * Busca una notificación existente.
                     *
                     * @type {Element|null}
                     */
                    const existing =
                        document.querySelector(
                            '#kanban-notification'
                        );


                    /**
                     * Elimina la notificación anterior para
                     * evitar mostrar varias simultáneamente.
                     */
                    if (existing) {
                        existing.remove();
                    }


                    /**
                     * Crea el elemento HTML de la nueva notificación.
                     *
                     * @type {HTMLDivElement}
                     */
                    const notification =
                        document.createElement('div');


                    notification.id =
                        'kanban-notification';


                    /**
                     * Define las clases visuales dependiendo
                     * del tipo de notificación.
                     *
                     * @type {string}
                     */
                    const colorClasses =
                        type === 'success'
                            ? 'text-green-800 bg-green-50 border-green-200'
                            : 'text-red-800 bg-red-50 border-red-200';


                    notification.className =
                        `fixed top-5 right-5 z-50 max-w-sm px-4 py-3 border rounded-lg shadow-lg text-sm font-medium ${colorClasses}`;


                    /**
                     * Inserta el mensaje recibido dentro
                     * de la notificación.
                     */
                    notification.textContent =
                        message;


                    /**
                     * Agrega la notificación al documento.
                     */
                    document.body.appendChild(
                        notification
                    );


                    /**
                     * Elimina automáticamente la notificación
                     * después de tres segundos.
                     */
                    setTimeout(function () {

                        notification.remove();

                    }, 3000);

                }


                /**
                 * Obtiene el campo de búsqueda de tareas.
                 *
                 * @type {HTMLElement|null}
                 */
                const taskSearch =
                    document.getElementById('task-search');


                /**
                 * Obtiene el filtro de estado de las tareas.
                 *
                 * @type {HTMLElement|null}
                 */
                const statusFilter =
                    document.getElementById('status-filter');


                /**
                 * Filtra las tareas del tablero según los criterios
                 * seleccionados por el usuario.
                 *
                 * Los filtros disponibles son:
                 *
                 * - Texto de búsqueda.
                 * - Estado.
                 * - Integrante asignado.
                 * - Fecha de vencimiento.
                 *
                 * @returns {void}
                 */
                function filterKanbanTasks() {

                    /**
                     * Obtiene y normaliza el texto introducido
                     * en el buscador.
                     *
                     * @type {string}
                     */
                    const search =
                        taskSearch.value
                            .toLowerCase()
                            .trim();


                    /**
                     * Obtiene el estado seleccionado.
                     *
                     * @type {string}
                     */
                    const selectedStatus =
                        statusFilter.value;


                    /**
                     * Obtiene el integrante seleccionado
                     * en el filtro de asignación.
                     *
                     * @type {string}
                     */
                    const selectedAssignee =
                        document
                            .getElementById('assignee-filter')
                            .value;


                    /**
                     * Obtiene el filtro seleccionado
                     * para las fechas de vencimiento.
                     *
                     * @type {string}
                     */
                    const selectedDueDate =
                        document
                            .getElementById('due-date-filter')
                            .value;


                    /**
                     * Recorre todas las columnas del Kanban
                     * para aplicar los filtros.
                     */
                    document
                        .querySelectorAll('.kanban-column')
                        .forEach(function (column) {

                            /**
                             * Estado asociado a la columna actual.
                             *
                             * @type {string|undefined}
                             */
                            const columnStatus =
                                column.dataset.status;


                            /**
                             * Obtiene las tarjetas existentes
                             * dentro de la columna.
                             *
                             * @type {NodeListOf<Element>}
                             */
                            const cards =
                                column.querySelectorAll(
                                    '.kanban-card'
                                );


                            /**
                             * Cuenta las tarjetas que permanecen
                             * visibles después de aplicar los filtros.
                             *
                             * @type {number}
                             */
                            let visibleCards = 0;


                            /**
                             * Evalúa individualmente cada tarjeta
                             * para determinar si debe mostrarse.
                             *
                             * @param {Element} card Tarjeta de tarea.
                             * @returns {void}
                             */
                            cards.forEach(function (card) {

                                /**
                                 * Obtiene el título de la tarea.
                                 *
                                 * @type {string}
                                 */
                                const title =
                                    card
                                        .querySelector('h4')
                                        ?.textContent
                                        .toLowerCase() || '';


                                /**
                                 * Obtiene la descripción de la tarea.
                                 *
                                 * @type {string}
                                 */
                                const description =
                                    card
                                        .querySelector('p')
                                        ?.textContent
                                        .toLowerCase() || '';


                                /**
                                 * Comprueba si el texto de búsqueda
                                 * coincide con el título o descripción.
                                 *
                                 * @type {boolean}
                                 */
                                const matchesSearch =
                                    search === '' ||
                                    title.includes(search) ||
                                    description.includes(search);


                                /**
                                 * Comprueba si la tarea pertenece
                                 * al estado seleccionado.
                                 *
                                 * @type {boolean}
                                 */
                                const matchesStatus =
                                    selectedStatus === 'todos' ||
                                    columnStatus === selectedStatus;


                                /**
                                 * Obtiene el identificador del integrante
                                 * asignado a la tarea.
                                 *
                                 * @type {string|undefined}
                                 */
                                const cardAssignee =
                                    card.dataset.assignee;


                                /**
                                 * Comprueba si la tarea coincide
                                 * con el integrante seleccionado.
                                 *
                                 * @type {boolean}
                                 */
                                const matchesAssignee =
                                    selectedAssignee === 'todos' ||
                                    cardAssignee === selectedAssignee;


                                /**
                                 * Obtiene la fecha de vencimiento
                                 * almacenada en la tarjeta.
                                 *
                                 * @type {string|undefined}
                                 */
                                const cardDueDate =
                                    card.dataset.dueDate;


                                /**
                                 * Obtiene la fecha actual sin considerar
                                 * la hora.
                                 *
                                 * @type {Date}
                                 */
                                const today =
                                    new Date();

                                today.setHours(0, 0, 0, 0);


                                /**
                                 * Convierte la fecha de vencimiento
                                 * de la tarea a un objeto Date.
                                 *
                                 * @type {Date|null}
                                 */
                                const dueDate =
                                    cardDueDate
                                        ? new Date(
                                            cardDueDate + 'T00:00:00'
                                        )
                                        : null;


                                /**
                                 * Indica inicialmente que la tarea
                                 * cumple el filtro de fecha.
                                 *
                                 * @type {boolean}
                                 */
                                let matchesDueDate = true;


                                /**
                                 * Filtra las tareas que no tienen
                                 * una fecha de vencimiento.
                                 */
                                if (selectedDueDate === 'sin_fecha') {

                                    matchesDueDate =
                                        !cardDueDate;


                                /**
                                 * Filtra las tareas cuya fecha
                                 * de vencimiento corresponde a hoy.
                                 */
                                } else if (selectedDueDate === 'hoy') {

                                    matchesDueDate =
                                        dueDate &&
                                        dueDate.getTime() === today.getTime();


                                /**
                                 * Filtra las tareas cuyo vencimiento
                                 * está dentro de los próximos siete días.
                                 */
                                } else if (
                                    selectedDueDate === 'proximos_7'
                                ) {

                                    if (!dueDate) {

                                        matchesDueDate = false;

                                    } else {

                                        /**
                                         * Calcula la fecha correspondiente
                                         * a siete días después de hoy.
                                         *
                                         * @type {Date}
                                         */
                                        const sevenDaysFromNow =
                                            new Date(today);

                                        sevenDaysFromNow.setDate(
                                            sevenDaysFromNow.getDate() + 7
                                        );

                                        matchesDueDate =
                                            dueDate >= today &&
                                            dueDate <= sevenDaysFromNow;
                                    }


                                /**
                                 * Filtra las tareas cuya fecha
                                 * de vencimiento ya pasó.
                                 */
                                } else if (
                                    selectedDueDate === 'vencidas'
                                ) {

                                    matchesDueDate =
                                        dueDate &&
                                        dueDate < today;
                                }


                                /**
                                 * Determina si la tarjeta cumple
                                 * todos los filtros seleccionados.
                                 *
                                 * @type {boolean}
                                 */
                                const shouldShow =
                                    matchesSearch &&
                                    matchesStatus &&
                                    matchesAssignee &&
                                    matchesDueDate;


                                /**
                                 * Muestra u oculta la tarjeta según
                                 * el resultado de los filtros.
                                 */
                                if (shouldShow) {

                                    card.style.display = '';

                                    visibleCards++;

                                } else {

                                    card.style.display = 'none';

                                }

                            });


                            /**
                             * Busca el mensaje que aparece cuando
                             * ningún resultado coincide con los filtros.
                             *
                             * @type {Element|null}
                             */
                            let filterMessage =
                                column.querySelector(
                                    '.kanban-filter-empty'
                                );


                            /**
                             * Si no hay tarjetas visibles, muestra
                             * un mensaje informativo.
                             */
                            if (visibleCards === 0) {

                                if (!filterMessage) {

                                    /**
                                     * Crea el mensaje de resultados vacíos.
                                     *
                                     * @type {HTMLDivElement}
                                     */
                                    filterMessage =
                                        document.createElement('div');


                                    filterMessage.className =
                                        'kanban-filter-empty text-center py-8 px-4 text-sm text-gray-400 border-2 border-dashed border-gray-200 rounded-xl';


                                    filterMessage.textContent =
                                        'No hay tareas que coincidan con el filtro.';


                                    column
                                        .querySelector('.kanban-tasks')
                                        .appendChild(
                                            filterMessage
                                        );

                                }

                                filterMessage.style.display = '';

                            } else {

                                /**
                                 * Si existen resultados, oculta
                                 * el mensaje de resultados vacíos.
                                 */
                                if (filterMessage) {

                                    filterMessage.style.display =
                                        'none';

                                }

                            }

                        });

                }


                /**
                 * Ejecuta el filtrado cada vez que el usuario
                 * escribe algo en el buscador.
                 *
                 * @listens input
                 */
                taskSearch.addEventListener(
                    'input',
                    filterKanbanTasks
                );


                /**
                 * Ejecuta el filtrado cuando cambia el filtro
                 * de estado.
                 *
                 * @listens change
                 */
                statusFilter.addEventListener(
                    'change',
                    filterKanbanTasks
                );


                /**
                 * Ejecuta el filtrado cuando cambia el integrante
                 * asignado seleccionado.
                 *
                 * @listens change
                 */
                document
                    .getElementById('assignee-filter')
                    .addEventListener(
                        'change',
                        filterKanbanTasks
                    );


                /**
                 * Ejecuta el filtrado cuando cambia el filtro
                 * de fecha de vencimiento.
                 *
                 * @listens change
                 */
                document
                    .getElementById('due-date-filter')
                    .addEventListener(
                        'change',
                        filterKanbanTasks
                    );

            });

        </script>

</x-app-layout>