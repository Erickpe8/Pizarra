@if (session('success'))

    <div
        class="flex items-center w-full max-w-full p-4 mb-4 text-green-800 bg-green-50 border border-green-200 rounded-lg"
        role="alert"
    >

        <svg
            width="20"
            height="20"
            class="shrink-0 flex-none mr-3"
            style="width: 20px; height: 20px; min-width: 20px; min-height: 20px; max-width: 20px; max-height: 20px;"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20"
        >
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM8.5 14.5 4 10l1.5-1.5 3 3 6-6L16 7l-7.5 7.5Z"/>
        </svg>

        <div class="flex-1 min-w-0 text-sm font-medium">
            {{ session('success') }}
        </div>

        <button
            type="button"
            class="shrink-0 flex-none ml-3 p-1.5 text-green-500 bg-green-50 rounded-lg hover:bg-green-200"
            onclick="this.parentElement.remove()"
            aria-label="Cerrar"
        >

            <span class="sr-only">
                Cerrar
            </span>

            <svg
                width="12"
                height="12"
                class="shrink-0 flex-none"
                style="width: 12px; height: 12px; min-width: 12px; min-height: 12px; max-width: 12px; max-height: 12px;"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 14"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 12 12M13 1 1 13"
                />
            </svg>

        </button>

    </div>

@endif

@if (session('error'))

    <div
        class="flex items-center w-full max-w-full p-4 mb-4 text-red-800 bg-red-50 border border-red-200 rounded-lg"
        role="alert"
    >

        <svg
            width="20"
            height="20"
            class="shrink-0 flex-none mr-3"
            style="width: 20px; height: 20px; min-width: 20px; min-height: 20px; max-width: 20px; max-height: 20px;"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20"
        >
            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm1 15H9v-2h2Zm0-4H9V5h2Z"/>
        </svg>

        <div class="flex-1 min-w-0 text-sm font-medium">
            {{ session('error') }}
        </div>

        <button
            type="button"
            class="shrink-0 flex-none ml-3 p-1.5 text-red-500 bg-red-50 rounded-lg hover:bg-red-200"
            onclick="this.parentElement.remove()"
            aria-label="Cerrar"
        >

            <span class="sr-only">
                Cerrar
            </span>

            <svg
                width="12"
                height="12"
                class="shrink-0 flex-none"
                style="width: 12px; height: 12px; min-width: 12px; min-height: 12px; max-width: 12px; max-height: 12px;"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 14"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 12 12M13 1 1 13"
                />
            </svg>

        </button>

    </div>

@endif

@if (session('warning'))

    <div
        class="flex items-center w-full max-w-full p-4 mb-4 text-yellow-800 bg-yellow-50 border border-yellow-200 rounded-lg"
        role="alert"
    >

        <svg
            width="20"
            height="20"
            class="shrink-0 flex-none mr-3"
            style="width: 20px; height: 20px; min-width: 20px; min-height: 20px; max-width: 20px; max-height: 20px;"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20"
        >
            <path d="M10 1a9 9 0 1 0 9 9 9.01 9.01 0 0 0-9-9Zm1 13H9v-2h2Zm0-4H9V5h2Z"/>
        </svg>

        <div class="flex-1 min-w-0 text-sm font-medium">
            {{ session('warning') }}
        </div>

        <button
            type="button"
            class="shrink-0 flex-none ml-3 p-1.5 text-yellow-500 bg-yellow-50 rounded-lg hover:bg-yellow-200"
            onclick="this.parentElement.remove()"
            aria-label="Cerrar"
        >

            <span class="sr-only">
                Cerrar
            </span>

            <svg
                width="12"
                height="12"
                class="shrink-0 flex-none"
                style="width: 12px; height: 12px; min-width: 12px; min-height: 12px; max-width: 12px; max-height: 12px;"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 14"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 12 12M13 1 1 13"
                />
            </svg>

        </button>

    </div>

@endif

@if (session('info'))

    <div
        class="flex items-center w-full max-w-full p-4 mb-4 text-blue-800 bg-blue-50 border border-blue-200 rounded-lg"
        role="alert"
    >

        <svg
            width="20"
            height="20"
            class="shrink-0 flex-none mr-3"
            style="width: 20px; height: 20px; min-width: 20px; min-height: 20px; max-width: 20px; max-height: 20px;"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20"
        >
            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm1 15H9v-2h2Zm0-10H9v6h2Z"/>
        </svg>

        <div class="flex-1 min-w-0 text-sm font-medium">
            {{ session('info') }}
        </div>

        <button
            type="button"
            class="shrink-0 flex-none ml-3 p-1.5 text-blue-500 bg-blue-50 rounded-lg hover:bg-blue-200"
            onclick="this.parentElement.remove()"
            aria-label="Cerrar"
        >

            <span class="sr-only">
                Cerrar
            </span>

            <svg
                width="12"
                height="12"
                class="shrink-0 flex-none"
                style="width: 12px; height: 12px; min-width: 12px; min-height: 12px; max-width: 12px; max-height: 12px;"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 14"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 12 12M13 1 1 13"
                />
            </svg>

        </button>

    </div>

@endif

@if ($errors->any())

    <div
        class="flex items-start w-full max-w-full p-4 mb-4 text-red-800 bg-red-50 border border-red-200 rounded-lg"
        role="alert"
    >

        <svg
            width="20"
            height="20"
            class="shrink-0 flex-none mr-3 mt-0.5"
            style="width: 20px; height: 20px; min-width: 20px; min-height: 20px; max-width: 20px; max-height: 20px;"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20"
        >
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM8.5 14.5 4 10l1.5-1.5 3 3 6-6L16 7l-7.5 7.5Z"/>
        </svg>

        <div class="flex-1 min-w-0 text-sm">

            <span class="font-medium">
                Revisa los siguientes datos:
            </span>

            <ul class="mt-2 list-disc list-inside space-y-1">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

        <button
            type="button"
            class="shrink-0 flex-none ml-3 p-1.5 text-red-500 bg-red-50 rounded-lg hover:bg-red-200"
            onclick="this.parentElement.remove()"
            aria-label="Cerrar"
        >

            <span class="sr-only">
                Cerrar
            </span>

            <svg
                width="12"
                height="12"
                class="shrink-0 flex-none"
                style="width: 12px; height: 12px; min-width: 12px; min-height: 12px; max-width: 12px; max-height: 12px;"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 14"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 12 12M13 1 1 13"
                />
            </svg>

        </button>

    </div>

@endif