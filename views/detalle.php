<?php
session_start();
$base = "../"; // Estamos en la carpeta views

require_once($base . 'provider/conexion.php');
require_once($base . 'components/producto_component.php');

// 1. Validar ID del producto
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: productos.php"); // Si no hay ID válido, volver a la tienda
    exit;
}

// 2. Consultar datos del producto
$sql = "SELECT p.*, c.nombre_categoria, c.id_categoria 
        FROM productos p 
        JOIN categorias c ON p.id_categoria = c.id_categoria 
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$producto = $stmt->get_result()->fetch_assoc();

// Si no existe el producto, redirigir
if (!$producto) {
    header("Location: productos.php");
    exit;
}

// 3. Lógica de Imágenes
$pathImagenes = $base . "assets/images/productos/$id/";
$imagenes = [];
if (is_dir($pathImagenes)) {
    $imagenes = array_diff(scandir($pathImagenes), array('..', '.'));
    // Reindexar array para facilitar el uso en JS (0, 1, 2...)
    $imagenes = array_values($imagenes);
}
// Imagen por defecto si no hay ninguna
if (empty($imagenes)) {
    $imagenes[] = $base . "assets/images/util/Imagen_no_disponible.svg.png"; // Asegúrate de tener esta imagen o usa una ruta válida
    $esPlaceholder = true;
} else {
    // Ajustar rutas para el HTML
    foreach ($imagenes as $k => $img) {
        $imagenes[$k] = $pathImagenes . $img;
    }
    $esPlaceholder = false;
}

// 4. Productos Relacionados (Misma categoría, excluyendo el actual)
$sqlRel = "SELECT * FROM productos WHERE id_categoria = ? AND id != ? LIMIT 4";
$stmtRel = $conn->prepare($sqlRel);
$stmtRel->bind_param("ii", $producto['id_categoria'], $id);
$stmtRel->execute();
$relacionados = $stmtRel->get_result()->fetch_all(MYSQLI_ASSOC);

$tituloPagina = $producto['nombre'] . " | Curacaví FC";
include($base . 'header.php'); 
?>

<main class="container mx-auto px-4 mt-28 md:mt-40 mb-20">

    <nav class="flex text-slate-500 text-[10px] md:text-xs uppercase tracking-widest mb-8 font-bold">
        <a href="<?= $base ?>index.php" class="hover:text-yellow-300 transition-colors">Inicio</a>
        <span class="mx-2">/</span>
        <a href="productos.php" class="hover:text-yellow-300 transition-colors">Tienda</a>
        <span class="mx-2">/</span>
        <a href="productos.php?categoria_id=<?= $producto['id_categoria'] ?>" class="hover:text-yellow-300 transition-colors"><?= $producto['nombre_categoria'] ?></a>
        <span class="mx-2">/</span>
        <span class="text-white"><?= htmlspecialchars($producto['nombre']) ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <div class="space-y-4">
            <div class="relative aspect-square bg-slate-900/50 rounded-3xl border border-white/10 overflow-hidden group">
                <img id="mainImage" src="<?= htmlspecialchars($imagenes[0]) ?>" 
                     alt="<?= htmlspecialchars($producto['nombre']) ?>" 
                     class="w-full h-full object-contain p-6 transition-transform duration-500 group-hover:scale-105">
                
                <?php if ($producto['descuento'] > 0): ?>
                    <span class="absolute top-4 left-4 bg-red-600 text-white text-xs font-black px-3 py-1 rounded-full uppercase tracking-widest">
                        -<?= $producto['descuento'] ?>% OFF
                    </span>
                <?php endif; ?>
            </div>

            <?php if (count($imagenes) > 1): ?>
                <div class="grid grid-cols-4 gap-4">
                    <?php foreach ($imagenes as $index => $img): ?>
                        <button onclick="changeImage('<?= htmlspecialchars($img) ?>')" 
                                class="aspect-square bg-slate-900/50 rounded-xl border border-white/10 overflow-hidden hover:border-yellow-300 transition-all focus:ring-2 ring-yellow-300">
                            <img src="<?= htmlspecialchars($img) ?>" class="w-full h-full object-contain p-2">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex flex-col h-full">
            
            <div class="mb-6 border-b border-white/10 pb-6">
                <p class="text-yellow-300 text-xs font-bold uppercase tracking-[0.2em] mb-2">
                    <?= htmlspecialchars($producto['nombre_categoria']) ?>
                </p>
                <h1 class="text-3xl md:text-5xl font-black uppercase italic tracking-tighter text-white leading-none mb-4">
                    <?= htmlspecialchars($producto['nombre']) ?>
                </h1>
                
                <div class="flex items-end gap-4">
                    <?php 
                        $precioFinal = $producto['precio_venta'];
                        if($producto['descuento'] > 0) {
                            $precioFinal = $producto['precio_venta'] * (1 - $producto['descuento']/100);
                        }
                    ?>
                    <span class="text-4xl font-black text-yellow-400">$<?= number_format($precioFinal, 0, '.', '.') ?></span>
                    <?php if ($producto['descuento'] > 0): ?>
                        <span class="text-xl text-slate-500 line-through mb-1">$<?= number_format($producto['precio_venta'], 0, '.', '.') ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="prose prose-invert prose-sm text-slate-300 mb-8 leading-relaxed">
                <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
            </div>

            <div class="mt-auto bg-slate-900/50 p-6 rounded-3xl border border-white/5">
                <form onsubmit="addToCart(event)" method="POST" class="flex flex-col sm:flex-row gap-4">
                    <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                    
                    <div class="flex items-center justify-between bg-black rounded-xl border border-white/10 w-full sm:w-40 px-2 py-1">
                        <button type="button" onclick="decrementCantidad(this)" class="w-10 h-10 text-slate-400 hover:text-white font-bold text-lg">-</button>
                        <input type="number" name="producto_cant" value="1" readonly class="bg-transparent w-12 text-center text-white font-bold border-none focus:ring-0">
                        <button type="button" onclick="incrementCantidad(this)" class="w-10 h-10 text-slate-400 hover:text-white font-bold text-lg">+</button>
                    </div>

                    <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-black uppercase tracking-widest text-sm py-4 rounded-xl transition-all shadow-lg shadow-yellow-400/20 hover:scale-[1.02]">
                        Añadir al Carrito
                    </button>
                </form>

                <div class="flex items-center gap-4 mt-6 text-[10px] uppercase tracking-widest font-bold text-slate-500">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Stock Disponible</span>
                    <span class="flex items-center gap-1">🛡️ Compra Segura</span>
                </div>
            </div>

        </div>
    </div>

    <?php if (!empty($relacionados)): ?>
    <div class="mt-32 border-t border-white/10 pt-16">
        <h3 class="text-2xl md:text-3xl font-black uppercase italic text-white mb-8 text-center md:text-left">
            También te podría interesar
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-3 gap-y-8 md:gap-6">
            <?= productoComponent($relacionados, 0); // Reutilizamos tu componente ?>
        </div>
    </div>
    <?php endif; ?>

</main>

<script>
    // Pequeño script para cambiar la imagen principal al hacer click en miniaturas
    function changeImage(src) {
        const main = document.getElementById('mainImage');
        main.style.opacity = '0';
        setTimeout(() => {
            main.src = src;
            main.style.opacity = '1';
        }, 200);
    }
</script>

<?php include($base . 'sections/footer.php'); ?>