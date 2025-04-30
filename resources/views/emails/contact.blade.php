<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Nuevo mensaje de contacto</title>
</head>
<body>
  <h2>Nuevo mensaje de contacto</h2>
  
  <p><strong>Nombre:</strong> {{ $data['first_name'] }}</p>
  <p><strong>Apellido:</strong> {{ $data['last_name'] }}</p>
  <p><strong>Email:</strong> {{ $data['email'] }}</p>
  <p><strong>Teléfono:</strong> {{ $data['phone'] }}</p>
  
  <h3>Mensaje:</h3>
  <p>{{ $data['message'] }}</p>
</body>
</html>