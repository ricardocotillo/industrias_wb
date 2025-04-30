{{-- resources/views/emails/quote.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cotización solicitada</title>
</head>
<body>
    <h2>Cotización solicitada</h2>
    
    <p><strong>Nombre completo:</strong> {{ $data['full_name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Teléfono:</strong> {{ $data['phone'] }}</p>
    <p><strong>RUC:</strong> {{ $data['ruc'] }}</p>
    
    <h3>Productos solicitados:</h3>
    @if (count($data['products']) > 0)
        <ul>
            @foreach ($data['products'] as $product)
                <li>{{ trim($product) }}</li>
            @endforeach
        </ul>
    @else
        <p>No se especificaron productos.</p>
    @endif
</body>
</html>