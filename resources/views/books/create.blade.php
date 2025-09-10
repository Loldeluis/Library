@extends('layouts.app_library')

@section('title', 'Buscar Libros')
  
@section('content')
  <h1>Buscar Libros</h1>

  <div class="form-group" style="max-width:400px;margin:auto;display:flex;gap:.5rem;">
    <input
      type="text"
      id="search-input"
      class="form-control"
      placeholder="ISBN, título, autor..."
    >
    <button id="search-btn" class="btn">Buscar</button>
  </div>

  <div class="books-grid" id="search-results" style="margin-top:1.5rem;"></div>
@endsection

@section('scripts')
<script>
  const container = document.getElementById('search-results');
  const btn       = document.getElementById('search-btn');
  const input     = document.getElementById('search-input');

  btn.addEventListener('click', async () => {
    const q = input.value.trim();
    if (!q) return;

    // Limpia resultados previos
    container.innerHTML = '';

    try {
      // Definimos res aquí y lo usamos en todo el bloque
      const res = await fetch(
        `/books/query?q=${encodeURIComponent(q)}`, 
        { headers: { 'Accept': 'application/json' } }
      );

      if (!res.ok) {
        const errorText = await res.text();
        console.error(`Error ${res.status}:`, errorText);
        container.innerHTML = `<p>Error ${res.status} al buscar.</p>`;
        return;
      }

      const { count, results } = await res.json();

      if (!count) {
        container.innerHTML = `<p>No se encontraron resultados para “${q}”.</p>`;
        return;
      }

      // Renderizamos cada tarjeta
      results.forEach(book => {
        const card = document.createElement('div');
        card.className = 'book-card';
        card.innerHTML = `
          <img
            src="${book.portada_medium || '/images/placeholder.png'}"
            alt="Portada ${book.titulo}"
            loading="lazy"
          >
          <h3>${book.titulo}</h3>
          <p>${Array.isArray(book.autores) ? book.autores.join(', ') : ''}</p>
        `;
        container.appendChild(card);
      });

    } catch (err) {
      console.error(err);
      container.innerHTML = '<p>Error de conexión o respuesta inválida.</p>';
    }
  });
</script>
@endsection
