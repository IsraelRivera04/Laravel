@extends('plantilla')

@section('contenido')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/factura.css') }}">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }
        .factura-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: orange;
            color: white;
            padding: 20px 0;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
        }
        .header p {
            font-size: 1.2rem;
        }
        .section-title {
            font-size: 1.5rem;
            color: #333;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .section-content {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 20px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: orange;
            color: white;
        }
        .total {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container mb-5 factura-container">
        <div class="header">
            <h1>¡Gracias por tu Compra!</h1>
            <p>Pedido Confirmado - ID: {{ $pedido->id }}</p>
        </div>

        <div class="section-title">Detalles del Cliente</div>
        <div class="section-content">
            <p><strong>Cliente:</strong> {{ auth()->user()->username }}</p>
            <p><strong>Dirección:</strong> {{ $pedido->direccion }}</p>
            <p><strong>Teléfono:</strong> {{ $pedido->telefono }}</p>
        </div>

        <div class="section-title mt-4">Información de Pago</div>
        <div class="section-content">
            <p><strong>Método de Pago:</strong> {{ $pedido->metodo_pago }}</p>
        </div>

        <div class="section-title mt-4">Detalles del Pedido</div>
        <div class="section-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->items as $item)
                        <tr>
                            <td>{{ $item->producto->nombre }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>{{ number_format($item->precio_unitario, 2) }}€</td>
                            <td>{{ number_format($item->cantidad * $item->precio_unitario, 2) }}€</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total mt-4">
            <p><strong>Total: {{ number_format($pedido->total, 2) }}€</strong></p>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('compra.descargarPDF') }}" class="btn-custom">Descargar PDF</a>
            <a href="{{ route('inicio') }}" class="btn btn-outline-secondary">Volver al Inicio</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection

