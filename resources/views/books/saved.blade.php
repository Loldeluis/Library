@extends('layouts.app_library')

@section('title', 'Mis Libros Guardados')

@section('content')
  <h1>Mis Libros Guardados</h1>

  <form method="GET" action="{{ route('books.saved') }}" style="max-width:400px; margin:auto; display:flex; gap:.5rem;">
    <input type="text"
           name="q"
           class="form-control"
           placeholder="Buscar en mi inventario"
           value="{{ $q }}">
    <button type="submit" class="btn">Buscar</button>
  </form>

  <div class="books-grid" style="margin-top:1.5rem;">
    @forelse($ejemplares as $ej)
      <div class="book-card">
        <img src="{{ $ej->libro->portada_medium }}" alt="Portada {{ $ej->libro->titulo }}" loading="lazy">
        <h3>{{ $ej->libro->titulo }}</h3>
        <p>Cantidad: {{ $ej->cantidad }}</p>
        <p>Agregado: {{ $ej->created_at->format('d/m/Y') }}</p>
      </div>
    @empty
      <p style="text-align:center; width:100%;">No tienes libros guardados.</p>
    @endforelse
  </div>

  <div style="margin-top:1rem;">
    {{ $ejemplares->withQueryString()->links() }}
  </div>
@endsection