@extends('layouts.app_library')

@section('title', 'Buscar Libros')
  
@section('content')
  <h1>Buscar Libros</h1>

  {{-- Buscador único --}}
  <div class="form-group" style="max-width:400px;margin:auto;display:flex;gap:.5rem;">
    <input
      type="text"
      id="search-input"
      class="form-control"
      placeholder="ISBN, título, autor..."
    >
    <button id="search-btn" class="btn">Buscar</button>
  </div>

  {{-- Contenedor de resultados --}}
  <div class="books-grid" id="search-results" style="margin-top:1.5rem;"></div>

  {{-- Modal de detalle --}}
  <div id="book-modal" class="modal">
    <div class="modal-content">
      <button class="modal-close">&times;</button>
      <img id="modal-cover" src="" alt="Portada" loading="lazy">
      <div class="modal-info">
        <h2 id="modal-title"></h2>
        <p><strong>Autor(es):</strong> <span id="modal-authors"></span></p>
        <p><strong>Editorial:</strong> <span id="modal-publisher"></span></p>
        <p><strong>Año:</strong> <span id="modal-year"></span></p>
        <p><strong>Páginas:</strong> <span id="modal-pages"></span></p>
        <p><strong>Idioma:</strong> <span id="modal-language"></span></p>
        <h3>Sinopsis</h3>
        <p id="modal-description"></p>
      </div>
      <div class="modal-footer" style="clear: both; margin-top: 1rem;">
  <label for="modal-quantity">Cantidad:</label>
  <input type="number"
         id="modal-quantity"
         min="1"
         value="1"
         style="width: 4rem; margin: 0 .5rem;">
  <button id="modal-save-btn" class="btn">Guardar</button>
</div>

    </div>
    
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/book-search.js') }}"></script>
@endsection
