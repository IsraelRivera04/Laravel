<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .invoice-header {
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .invoice-header img {
            width: 120px;
        }
        h1, h2 {
            color: #555;
        }
        .invoice-table td, .invoice-table th {
            text-align: right;
            vertical-align: middle;
        }
        .invoice-table th {
            background-color: #f8f9fa;
        }
        .invoice-table td {
            padding: 0.75rem;
        }
        .invoice-total {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            border-top: 2px solid #ddd;
            padding-top: 10px;
            text-align: center;
            color: #555;
        }
        .footer p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Lacrimosa Board Games</h1>
                <div class="invoice-header d-flex justify-content-between">
                    <img src="storage/paginaInicio.jpeg" alt="Logo de la tienda">
                    <div class="text-end">
                        <h2 class="mb-1">Factura de Compra</h2>
                        <p class="mb-0"><strong>Pedido ID:</strong> {{ $pedido->id }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <p><strong>Cliente:</strong> {{ auth()->user()->username }}</p>
                        <p><strong>Dirección:</strong> {{ $pedido->direccion }}</p>
                        <p><strong>Teléfono:</strong> {{ $pedido->telefono }}</p>
                        <p><strong>Método de Pago:</strong> {{ $pedido->metodo_pago }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                    </div>
                </div>

                <h3 class="mt-4">Detalles del Pedido</h3>
                <table class="table table-bordered invoice-table">
                    <thead>
                        <tr>
                            <th class="text-start">Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido->items as $item)
                            <tr>
                                <td class="text-start">{{ $item->producto->nombre }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ number_format($item->precio_unitario, 2) }}€</td>
                                <td>{{ number_format($item->cantidad * $item->precio_unitario, 2) }}€</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="invoice-total text-end">Total: {{ number_format($pedido->total, 2) }}€</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <p><strong>¡Gracias por su compra!</strong></p>
                <p>Esperamos verte de nuevo pronto.</p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Lacrimosa Board Games.Tu tienda de confianza para juegos de mesa. Todos los derechos reservados.</p>
            <p>Para más información, visita nuestra página web.</p>
        </div>
    </div>
</body>
</html>
