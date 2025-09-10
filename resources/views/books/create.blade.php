@extends('layouts.app_library')

@section('title', 'Registrar Libro')

@section('content')
  <h1>Registrar Libro</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form id="book-form" method="POST" action="{{ route('books.store') }}">
    @csrf

    {{-- ISBN + botón de búsqueda --}}
    <div class="form-group">
      <label for="isbn-input">ISBN</label>
      <div class="input-with-button">
        <input
          type="text"
          name="isbn"
          id="isbn-input"
          class="form-control"
          value="{{ old('isbn') }}"
        >
        <button type="button" id="fetch-btn" class="btn">Buscar</button>
      </div>
      @error('isbn')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    {{-- Título --}}
    <div class="form-group">
      <label for="titulo">Título</label>
      <input
        type="text"
        name="titulo"
        id="titulo"
        class="form-control"
        value="{{ old('titulo') }}"
      >
      @error('titulo')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    {{-- Editorial --}}
    <div class="form-group">
      <label for="editorial">Editorial</label>
      <input
        type="text"
        name="editorial"
        id="editorial"
        class="form-control"
        value="{{ old('editorial') }}"
      >
      @error('editorial')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    {{-- Autor(es) --}}
    <div class="form-group">
      <label for="autor-0">Autor(es)</label>
      <input
        type="text"
        name="autores[0]"
        id="autor-0"
        class="form-control"
        value="{{ old('autores.0') }}"
      >
      @error('autores.0')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    {{-- Aquí puedes agregar más campos de tu StoreBookRequest --}}
    <button type="submit" class="btn">Guardar</button>
  </form>

  {{-- Vista previa dinámica --}}
  <div class="books-grid" id="book-preview"></div>
@endsection

@section('scripts')
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
        console.error(await res.text());
        return alert('Error al buscar el libro. Revisa la consola.');
      }

      const { count, results } = await res.json();
      const preview = document.getElementById('book-preview');
      preview.innerHTML = '';

      if (count > 0) {
        const book = results[0];

        // Rellenar el formulario
        document.getElementById('titulo').value     = book.titulo    || '';
        document.getElementById('editorial').value  = book.editorial || '';
        document.getElementById('autor-0').value    = Array.isArray(book.autores)
          ? book.autores.join(', ')
          : '';

        // Construir la tarjeta de preview
        const card = document.createElement('div');
        card.className = 'book-card';
        card.innerHTML = `
          <img
            src="${book.portada_medium || asset('images/placeholder.png')}"
            alt="Portada ${book.titulo}"
            loading="lazy"
          >
          <h3>${book.titulo}</h3>
          <p>${Array.isArray(book.autores) ? book.autores.join(', ') : ''}</p>
        `;
        preview.append(card);
      } else {
        preview.innerHTML = '<p>No se encontró el libro en Google Books.</p>';
      }
    } catch (err) {
      console.error(err);
      alert('Error de conexión o respuesta inválida.');
    }
  });
</script>
@endsection