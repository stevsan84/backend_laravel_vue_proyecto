<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pedido #{{ $pedido->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .info, .cliente {
            margin-bottom: 15px;
        }

        .info table, .cliente table {
            width: 100%;
        }

        .productos {
            width: 100%;
            border-collapse: collapse;
        }

        .productos th, .productos td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .productos th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
        }

    </style>
</head>
<body>

<div class="header">
    <h2>RECIBO DE PEDIDO</h2>
    <p><strong>Pedido N°:</strong> {{ $pedido->id }}</p>
    <p><strong>Fecha:</strong> {{ date('d/m/Y H:i', strtotime($pedido->fecha)) }}</p>
</div>

<div class="cliente">
    <h4>Datos del Cliente</h4>
    <table>
        <tr>
            <td><strong>Nombre:</strong> {{ $pedido->cliente->nombre_completo }}</td>
            <td><strong>CI/NIT:</strong> {{ $pedido->cliente->ci_nit }}</td>
        </tr>
        <tr>
            <td><strong>Teléfono:</strong> {{ $pedido->cliente->telefono }}</td>
            <td><strong>Correo:</strong> {{ $pedido->cliente->correo }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Dirección:</strong> {{ $pedido->cliente->direccion }}</td>
        </tr>
    </table>
</div>

<h4>Detalle del Pedido</h4>
<table class="productos">
    <thead>
        <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($pedido->productos as $index => $producto)
            @php
                $cantidad = $producto->pivot->cantidad;
                $precio = (float) $producto->precio;
                $subtotal = $cantidad * $precio;
                $total += $subtotal;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->descripcion }}</td>
                <td>{{ $cantidad }}</td>
                <td>$ {{ number_format($precio, 2) }}</td>
                <td>$ {{ number_format($subtotal, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p class="total">TOTAL: $ {{ number_format($total, 2) }}</p>

<div class="footer">
    <p>Gracias por su compra</p>
</div>

</body>
</html>
