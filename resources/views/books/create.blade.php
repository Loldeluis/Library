@extends('layouts.app')

@section('content')
<h1>Registrar libro</h1>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form id="book-form" method="POST" action="{{ route('books.store') }}">
  @csrf

  <!-- Campo ISBN + botón de búsqueda -->
  <div>
    <label for="isbn-input">ISBN</label>
    <input type="text" name="isbn" id="isbn-input" value="{{ old('isbn') }}">
    <button type="button" id="fetch-btn">Buscar</button>
  </div>

  <!-- Campos que se autocompletarán -->
  <div>
    <label for="titulo">Título</label>
    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}">
  </div>

  <div>
    <label for="editorial">Editorial</label>
    <input type="text" name="editorial" id="editorial" value="{{ old('editorial') }}">
  </div>

  <div>
    <label for="autor-0">Autor(es)</label>
    <input type="text" name="autores[0]" id="autor-0" value="{{ old('autores.0') }}">
  </div>

  <!-- Puedes añadir más campos según tu FormRequest -->

  <button type="submit">Guardar</button>
</form>

<script>
document.getElementById('fetch-btn').addEventListener('click', async () => {
  const isbn = document.getElementById('isbn-input').value.trim();

  if (!isbn) {
    alert('Por favor ingresa un ISBN.');
    return;
  }

  try {
    const res = await fetch(`/api/books/isbn/${isbn}`, {
      headers: { 'Accept': 'application/json' }
    });

    if (!res.ok) {
      const errorText = await res.text();
      console.error('Error HTTP', res.status, errorText);
      alert('No se pudo obtener el libro. Revisa la consola.');
      return;
    }

    const data = await res.json();

    if (data.count > 0) {
      const libro = data.results[0];

      const tituloInput = document.querySelector('input[name="titulo"]');
      if (tituloInput) tituloInput.value = libro.titulo || '';

      const editorialInput = document.querySelector('input[name="editorial"]');
      if (editorialInput) editorialInput.value = libro.editorial || '';

      const autorInput = document.querySelector('input[name="autores[0]"]');
      if (autorInput && Array.isArray(libro.autores)) {
        autorInput.value = libro.autores.join(', ');
      }
    } else {
      alert('No se encontró el libro en Google Books');
    }
  } catch (err) {
    console.error('Error en fetch:', err);
    alert('Error de conexión o respuesta inválida.');
  }
});
</script>
@endsection