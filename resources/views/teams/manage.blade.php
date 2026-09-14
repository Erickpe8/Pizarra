<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestionar equipo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <p>
                        Equipo:
                        <strong>{{ $team->name }}</strong>
                    </p>

                    <p class="text-sm text-gray-600">
                        Solo el líder puede ver y gestionar esta sección.
                    </p>

                    <div>
                        <h3 class="font-semibold mb-2">Miembros</h3>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($team->users as $member)
                                <li>
                                    {{ $member->name }}
                                    <span class="text-gray-500 text-sm">({{ $member->email }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
