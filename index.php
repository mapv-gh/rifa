<?php
session_start();
require_once('./provider/conexion.php');
require_once('./components/producto_component.php');
$title = 'Curacaví FC | Rifa ';
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