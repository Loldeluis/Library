<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Mi Biblioteca</title>
    <!-- aquí tus CSS, Bootstrap, etc. -->
  </head>
<body>
  <div class="container">
    @yield('content')
  </div>
</body>

</html>
<style>
  /* Tipografía general */
body {
  font-family: 'Segoe UI', Roboto, sans-serif;
  background-color: #f4f6f9;
  color: #333;
  margin: 0;
  padding: 2rem;
}

/* Encabezado */
h1 {
  font-size: 2rem;
  margin-bottom: 1.5rem;
  color: #2c3e50;
}

/* Contenedor del formulario */
#book-form {
  background-color: #fff;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  max-width: 600px;
  margin: auto;
}

/* Etiquetas */
label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #34495e;
}

/* Inputs */
input[type="text"] {
  width: 100%;
  padding: 0.75rem;
  margin-bottom: 1.5rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  transition: border-color 0.3s;
}

input[type="text"]:focus {
  border-color: #3498db;
  outline: none;
}

/* Botones */
button {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #2980b9;
}

/* Alertas */
.alert-success {
  background-color: #dff0d8;
  color: #3c763d;
  padding: 1rem;
  border-radius: 6px;
  margin-bottom: 1rem;
  border: 1px solid #d6e9c6;
}

</style>