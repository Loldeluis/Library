<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    
@if (session('status') === 'profile-updated')
    <div class="mb-4 p-3 
                bg-green-100 text-green-800 
                dark:bg-green-800 dark:text-green-100 
                rounded shadow">
        ✅ Perfil actualizado correctamente.
    </div>
@endif


</x-app-layout>

