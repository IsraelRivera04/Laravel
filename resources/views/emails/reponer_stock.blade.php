<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reponer Stock</title>
</head>
<body>
    <h2>Atención, se ha agotado el stock de un producto.</h2>
    <p>El producto <strong>{{ $producto->nombre }}</strong> ha llegado a su stock mínimo y necesita ser repuesto.</p>
    <p>Detalles:</p>
    <ul>
        <li>Producto: {{ $producto->nombre }}</li>
        <li>Categoría: {{ $producto instanceof App\Models\Juego ? 'Juego' : 'Complemento' }}</li>
        <li>Precio: {{ $producto->precio }} €</li>
    </ul>
    <p>Por favor, repón el stock lo antes posible.</p>
</body>
</html>
