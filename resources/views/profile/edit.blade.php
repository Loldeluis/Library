<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div class="mb-3">
      <label for="name" class="block text-sm font-medium">Nombre</label>
      <input id="name" name="name" type="text"
             value="{{ $user->name }}"
             required
             class="mt-1 block w-full border rounded px-3 py-2" />
      @error('name')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-3">
      <label for="email" class="block text-sm font-medium">Email</label>
      <input id="email" name="email" type="email"
             value="{{ $user->email }}"
             required
             class="mt-1 block w-full border rounded px-3 py-2" />
      @error('email')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit"
            class="mt-4 w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
      Actualizar
    </button>
</form>