<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Mi Biblioteca')</title>

  <!-- Estilos globales -->
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Roboto, sans-serif;
      background: #f4f6f9;
      color: #333;
    }

    header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #2c3e50;
      padding: 1rem;
    }
    header .logo a {
      color: #ecf0f1;
      font-size: 1.5rem;
      font-weight: 600;
      text-decoration: none;
    }
    .search-bar {
      display: flex;
    }
    .search-bar input {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 4px 0 0 4px;
      width: 250px;
    }
    .search-bar button {
      padding: 0.5rem 1rem;
      border: none;
      background: #3498db;
      color: #fff;
      border-radius: 0 4px 4px 0;
      cursor: pointer;
    }

    main {
      padding: 1.5rem;
    }

    /* Formularios */
    .form-group {
      margin-bottom: 1.25rem;
    }
    .input-with-button {
      display: flex;
      gap: .5rem;
    }
    .form-control {
      flex: 1;
      padding: .5rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .btn {
      padding: .5rem 1rem;
      border: none;
      border-radius: 4px;
      background: #3498db;
      color: #fff;
      cursor: pointer;
      font-weight: 600;
    }
    .btn:hover {
      background: #2980b9;
    }

    /* Grid de tarjetas */
    .books-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
      justify-content: center;
      gap: 1rem;
      margin-top: 1.5rem;
    }
    .book-card {
      max-width: 140px;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform .2s, box-shadow .2s;
    }
    .book-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    .book-card img {
      width: 100%;
      aspect-ratio: 2 / 3;
      object-fit: cover;
      display: block;
    }
    .book-card h3 {
      font-size: .9rem;
      margin: .5rem .5rem 0;
      line-height: 1.2;
      color: #2c3e50;
    }
    .book-card p {
      font-size: .75rem;
      margin: .25rem .5rem .75rem;
      color: #7f8c8d;
    }

    .alert-success {
      background: #dff0d8;
      color: #3c763d;
      padding: 1rem;
      border-radius: 6px;
      margin-bottom: 1.5rem;
    }
  </style>

  @yield('styles')
</head>
<body>

  <header>
    <div class="logo">
      <a href="{{ route('books.index') }}">MiBiblioteca</a>
    </div>

    <div class="search-bar">
      <input
        id="global-search-input"
        type="text"
        placeholder="Buscar por título, autor, ISBN..."
      >
      <button id="global-search-btn">Buscar</button>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  @yield('scripts')
</body>
</html>