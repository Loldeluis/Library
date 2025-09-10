<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Nombre -->
                    <div>
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input id="name" name="name" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('name', $user->name) }}"
                                      required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email"
                                      class="mt-1 block w-full"
                                      value="{{ old('email', $user->email) }}"
                                      required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Botón -->
                    <div class="flex justify-end">
                        <x-primary-button>
                            {{ __('Actualizar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>