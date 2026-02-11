<?php
session_start();
require_once('./provider/conexion.php');
require_once('./components/producto_component.php');
$title = 'Curacaví FC | Rifa ';

$sql = "SELECT productos.*, categorias.nombre_categoria 
        FROM productos 
        JOIN categorias ON productos.id_categoria = categorias.id_categoria 
        WHERE destacado = 1 LIMIT 4";
$res = $conn->query($sql);
$productos_destacados = ($res) ? $res->fetch_all(MYSQLI_ASSOC) : [];

?>
<!DOCTYPE html>
<html lang="es">
<?php include('./header.php'); ?>
<main class="container mx-auto px-4">
    
    <?php 
        include('./sections/sorteo_index.php'); 
        include('./sections/packs_tickets.php');
    ?>

</main>

<?php include('./sections/footer.php'); ?>