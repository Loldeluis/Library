<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Bienvenido, administrador. Aquí puedes gestionar la librería.") }}
                </div>
            </div>

            <!-- Ejemplo de secciones rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <a href="{{ route('books.create') }}" class="block p-6 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">
                    📚 Registrar nuevo libro
                </a>
                <a href="#" class="block p-6 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                    👥 Gestionar usuarios
                </a>
                <a href="#" class="block p-6 bg-yellow-600 text-white rounded-lg shadow hover:bg-yellow-700">
                    📊 Ver reportes
                </a>
            </div>
        </div>
    </div>
</x-app-layout>