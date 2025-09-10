<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Mi Biblioteca')</title>

  
@section('styles')
  <link rel="stylesheet" href="{{ asset('css/book-search.css') }}">
@endsection
  @yield('styles')
</head>
<body>

  <header>
    <div class="logo">
      <a href="#">MiBiblioteca</a>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  @yield('scripts')
</body>
</html>
