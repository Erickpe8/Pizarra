<x-app-layout>
    @if (auth()->user()->teams()->doesntExist())
        @include('norole')
    @else
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-blue-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Bienvenido,
                        {{ auth()->user()->name }}

                        <div class="mt-4">
                            Tu rol actual:
                            <strong>
                                @php
                                    $role = auth()->user()->getRoleNames()->first();
                                @endphp
                                {{ $role === 'lider' ? 'Líder' : ($role === 'trabajador' ? 'Trabajador' : ($role ?: 'Sin rol')) }}
                            </strong>
                        </div>

                        @role('lider')
                            <div class="mt-6">
                                <a
                                    href="{{ route('teams.manage') }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg"
                                >
                                    Gestionar equipo
                                </a>
                            </div>
                        @endrole
                        @role('lider')
                            <div class="mt-6">
                                <a
                                    href="{{ route('teams.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg"
                                >
                                    Crear nuevo equipo
                                </a>
                            </div>
                        @endrole

                       
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
