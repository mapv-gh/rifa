<?php
session_start();
require_once('../provider/conexion.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $producto_id = isset($_POST['producto_id']) ? $_POST['producto_id'] : null;
    $producto_cant = isset($_POST['producto_cant']) ? (int)$_POST['producto_cant'] : 1;

    if ($producto_id === null || $producto_id === '') {
        echo json_encode(['status' => 'error', 'message' => 'ID de producto no válido']);
        exit();
    }

    $sql = "SELECT id, nombre, precio_venta, descuento FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        
        $precio_final = ($producto['descuento'] > 0) ? 
                        $producto['precio_venta'] * (1 - ($producto['descuento'] / 100)) : 
                        $producto['precio_venta'];

        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad'] += $producto_cant;
        } else {
            $_SESSION['carrito'][$producto_id] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $precio_final,
                'cantidad' => $producto_cant
            ];
        }

        $total_general = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $total_general += ($item['precio'] * $item['cantidad']);
        }

        echo json_encode([
            'status' => 'success', 
            'producto' => $_SESSION['carrito'][$producto_id],
            'total_general' => $total_general
        ]);
        
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado']);
    }
    $stmt->close();
    $conn->close();
}