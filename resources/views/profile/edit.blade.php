<x-authenticated-layout>

    <div class="max-w-7xl mx-auto">

        <div class="mb-8">

            <p class="text-sm font-semibold text-indigo-700">
                Cuenta
            </p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                Mi perfil
            </h1>

            <p class="mt-2 text-gray-700">
                Administra la información y configuración de tu cuenta.
            </p>

        </div>


        <div class="space-y-6">


            {{-- Información personal --}}
            <div class="bg-blue-100 border border-gray-200 shadow-sm rounded-xl p-6 sm:p-8">

                <div class="max-w-xl">

                    @include('profile.partials.update-profile-information-form')

                </div>

            </div>


            {{-- Contraseña --}}
            <div class="bg-blue-100 border border-gray-200 shadow-sm rounded-xl p-6 sm:p-8">

                <div class="max-w-xl">

                    @include('profile.partials.update-password-form')

                </div>

            </div>


            {{-- Eliminar cuenta --}}
            <div class="bg-blue-100 border border-gray-200 shadow-sm rounded-xl p-6 sm:p-8">

                <div class="max-w-xl">

                    @include('profile.partials.delete-user-form')

                </div>

            </div>

        </div>

    </div>

</x-authenticated-layout>