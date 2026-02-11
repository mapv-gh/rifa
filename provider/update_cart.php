<?php
session_start();
header('Content-Type: application/json');

$producto_id = $_POST['producto_id'] ?? null;
$cambio = isset($_POST['cambio']) ? (int)$_POST['cambio'] : 0;

if ($producto_id && isset($_SESSION['carrito'][$producto_id])) {
    
    $_SESSION['carrito'][$producto_id]['cantidad'] += $cambio;
    $nueva_cantidad = $_SESSION['carrito'][$producto_id]['cantidad'];
    
    if ($nueva_cantidad <= 0) {
        unset($_SESSION['carrito'][$producto_id]);
        $nueva_cantidad = 0;
    }

    $nuevo_total_carrito = 0;
    
    foreach ($_SESSION['carrito'] as $id => $item) {
        $cantidad = $item['cantidad'];
        $precio_unitario = $item['precio']; // Precio base normal

        if ($id == 4) {
            if ($cantidad >= 5) {
                $precio_unitario = 2000;
            } elseif ($cantidad >= 3) {
                $precio_unitario = 2500;
            } else {
                $precio_unitario = 3000;
            }
        }
        // ----------------------------------------

        $nuevo_total_carrito += ($precio_unitario * $cantidad);
    }

    $nuevo_subtotal = 0;
    if (isset($_SESSION['carrito'][$producto_id])) {
        $cant_actual = $_SESSION['carrito'][$producto_id]['cantidad'];
        $precio_actual = $_SESSION['carrito'][$producto_id]['precio'];

        if ($producto_id == 4) {
            if ($cant_actual >= 5) {
                $precio_actual = 2000;
            } elseif ($cant_actual >= 3) {
                $precio_actual = 2500;
            } else {
                $precio_actual = 3000;
            }
        }
        $nuevo_subtotal = $precio_actual * $cant_actual;
    }

    // 4. Enviamos la respuesta
    echo json_encode([
        'status' => 'success',
        'nueva_cantidad' => $nueva_cantidad,
        'nuevo_subtotal' => $nuevo_subtotal, 
        'nuevo_total_carrito' => $nuevo_total_carrito
    ]);

} else {
    echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado']);
}