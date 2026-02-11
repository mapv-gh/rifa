<?php
session_start();
header('Content-Type: application/json');

$producto_id = $_POST['producto_id'] ?? null;

if ($producto_id && isset($_SESSION['carrito'][$producto_id])) {
    // Eliminamos el producto de la sesión
    unset($_SESSION['carrito'][$producto_id]);

    // Recalculamos el total general para el footer del carro
    $nuevo_total_carrito = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $nuevo_total_carrito += ($item['precio'] * $item['cantidad']);
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Producto eliminado correctamente',
        'nuevo_total_carrito' => $nuevo_total_carrito,
        'carrito_vacio' => empty($_SESSION['carrito']) // Útil para mostrar el mensaje de "vacío"
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo encontrar el producto']);
}