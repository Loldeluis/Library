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
    <label>ISBN</label>
    <input type="text" name="isbn" id="isbn-input" value="{{ old('isbn') }}">
    <button type="button" id="fetch-btn">Buscar</button>
  </div>

  <!-- Aquí irán los demás inputs: titulo, autores[], editorial, etc. -->
  <!-- Por brevedad no los incluyo todos, repítelos según tu FormRequest -->

  <button type="submit">Guardar</button>
</form>

<script>
document.getElementById('fetch-btn').addEventListener('click', async () => {
  const isbn = document.getElementById('isbn-input').value;
  const res = await fetch(`/api/books/isbn/${isbn}`);
  const data = await res.json();

  if (data.count > 0) {
    const libro = data.results[0];
    // Ejemplo: autocompletamos título y editorial
    document.querySelector('input[name="titulo"]').value = libro.titulo;
    document.querySelector('input[name="editorial"]').value = libro.editorial;
    // Autores: si tienes un solo campo, únelos por coma
    document.querySelector('input[name="autores[0]"]').value = libro.autores.join(', ');
    // Completa los demás inputs según mapeo
  } else {
    alert('No se encontró el libro en Google Books');
  }
});
</script>
@endsection
