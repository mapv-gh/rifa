<?php
session_start();
$base = "../"; // Estamos en la carpeta views
require_once($base . 'provider/conexion.php');

$title = "Tu Carrito | Curacaví FC";
include($base . 'header.php'); 

// Recalcular total inicial para mostrar en el resumen
$total_general = 0;
if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $id => $item) {
        $precio = $item['precio'];
        $cant = $item['cantidad'];
        
        // Lógica de precio Rifa (ID 4)
        if ($id == 4) {
            if ($cant >= 5) $precio = 2000;
            elseif ($cant >= 3) $precio = 2500;
            else $precio = 3000;
        }
        
        $total_general += ($precio * $cant);
    }
}
?>

<main class="container mx-auto px-4 mt-32 mb-20 min-h-[60vh]">

    <div class="flex flex-col md:flex-row justify-between items-end mb-8 border-b border-white/10 pb-6 gap-4">
        <div>
            <p class="text-yellow-300 text-xs font-bold uppercase tracking-widest mb-2">Proceso de Compra</p>
            <h1 class="text-4xl md:text-5xl font-black uppercase italic text-white leading-none">
                Tu Carrito
            </h1>
        </div>
        
        <?php if (!empty($_SESSION['carrito'])): ?>
            <div class="bg-white/5 px-4 py-2 rounded-lg border border-white/10">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">
                    <span class="text-white"><?= count($_SESSION['carrito']) ?></span> Items agregados
                </p>
            </div>
        <?php endif; ?>
    </div>

    <?php if (empty($_SESSION['carrito'])) : ?>
        <div class="py-20 text-center bg-slate-900/50 rounded-[2.5rem] border border-dashed border-white/10 flex flex-col items-center justify-center">
            <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center mb-6 shadow-xl text-4xl grayscale opacity-50">
                🛒
            </div>
            <h2 class="text-2xl font-black text-white italic uppercase mb-2">Tu carrito está vacío</h2>
            <p class="text-slate-400 mb-8 max-w-md mx-auto">Parece que aún no has elegido tu pack ganador.</p>
            <a href="rifa.php" class="bg-yellow-400 text-black font-black px-10 py-4 rounded-xl hover:bg-yellow-300 transition-all shadow-lg hover:-translate-y-1">
                Ir a Comprar Rifa
            </a>
        </div>
    <?php else : ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 space-y-4">
                
                <?php foreach ($_SESSION['carrito'] as $id => $item) : 
                    // --- Lógica Visual y de Precio ---
                    $cantidad = $item['cantidad'];
                    $precioBase = $item['precio']; // Precio original ($3.000 para rifa)
                    $precioFinal = $precioBase;
                    $textoPrecio = "$" . number_format($precioBase, 0, '.', '.') . " un.";
                    $imgSrc = $base . "assets/images/util/Imagen_no_disponible.svg.png";

                    // IMAGEN: Si es Rifa (ID 4) usamos la imagen estática, si no buscamos en carpeta
                    if ($id == 4) {
                        $imgSrc = $base . "assets/images/productos/".$id."/ticket.png";
                        
                        // Lógica de Precios Escalonados
                        if ($cantidad >= 5) {
                            $precioFinal = 2000;
                            $textoPrecio = "<span class='line-through text-slate-500 text-xs mr-2'>$" . number_format($precioBase, 0, '.', '.') . "</span>";
                            $textoPrecio .= "<span class='text-green-400 font-bold bg-green-400/10 px-2 py-0.5 rounded'>$2.000 (Pack 5+)</span>";
                        } elseif ($cantidad >= 3) {
                            $precioFinal = 2500;
                            $textoPrecio = "<span class='line-through text-slate-500 text-xs mr-2'>$" . number_format($precioBase, 0, '.', '.') . "</span>";
                            $textoPrecio .= "<span class='text-yellow-300 font-bold bg-yellow-400/10 px-2 py-0.5 rounded'>$2.500 (Pack 3-4)</span>";
                        }
                    } else {
                        // Lógica imagen productos normales
                        $pathImg = $base . "assets/images/productos/$id/";
                        if (is_dir($pathImg)) {
                            $files = array_diff(scandir($pathImg), array('..', '.'));
                            if (!empty($files)) $imgSrc = $pathImg . reset($files);
                        }
                    }

                    $subtotal = $precioFinal * $cantidad;
                ?>

                    <div class="bg-slate-900 border border-white/5 rounded-3xl p-4 sm:p-6 flex flex-col sm:flex-row items-center gap-6 relative group hover:border-white/10 transition-all">
                        
                        <div class="w-24 h-24 sm:w-28 sm:h-28 bg-black/40 rounded-2xl flex-shrink-0 p-2 border border-white/5 flex items-center justify-center">
                            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($item['nombre']) ?>" class="w-full h-full object-contain">
                        </div>

                        <div class="flex-grow text-center sm:text-left w-full">
                            <h3 class="text-white font-black uppercase italic text-xl leading-tight mb-2">
                                <?= htmlspecialchars($item['nombre']) ?>
                            </h3>
                            
                            <div class="mb-4 text-sm font-medium text-slate-400">
                                <?= $textoPrecio ?>
                            </div>

                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4">
                                <div class="flex items-center bg-black rounded-xl border border-white/10">
                                    <button onclick="updateCartPage(<?= $id ?>, -1)" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 rounded-l-xl transition-colors font-bold text-lg">-</button>
                                    <input type="text" value="<?= $cantidad ?>" readonly class="w-12 bg-transparent text-center text-white font-bold text-sm border-none focus:ring-0">
                                    <button onclick="updateCartPage(<?= $id ?>, 1)" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 rounded-r-xl transition-colors font-bold text-lg">+</button>
                                </div>
                                
                                <button onclick="removeCartPage(<?= $id ?>)" class="text-xs text-red-500 font-bold hover:text-red-400 hover:bg-red-500/10 px-3 py-2 rounded-lg transition-colors flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Quitar
                                </button>
                            </div>
                        </div>

                        <div class="text-right sm:pr-4 min-w-[120px]">
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-1">Subtotal</p>
                            <p class="text-2xl font-black text-yellow-400">
                                $<?= number_format($subtotal, 0, '.', '.') ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="mt-6">
                    <a href="../index.php#comprar-rifa" class="inline-flex items-center gap-2 text-slate-400 hover:text-yellow-300 text-sm font-bold transition-colors">
                        <span>←</span> Agregar más tickets
                    </a>
                </div>
            </div>

            <div class="lg:sticky lg:top-32">
                <div class="bg-black border border-yellow-400/20 rounded-[2rem] p-8 shadow-[0_0_40px_rgba(0,0,0,0.5)]">
                    <h3 class="text-xl font-black uppercase italic text-white mb-6 border-b border-white/10 pb-4">
                        Resumen de Compra
                    </h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Subtotal</span>
                            <span class="font-bold text-white">$<?= number_format($total_general, 0, '.', '.') ?></span>
                        </div>
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Envío</span>
                            <span class="text-green-400 font-bold text-xs uppercase bg-green-400/10 px-2 py-0.5 rounded">Digital (Gratis)</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center border-t border-white/10 pt-6 mb-8">
                        <span class="text-lg font-black text-white italic">Total a Pagar</span>
                        <span class="text-4xl font-black text-yellow-400">$<?= number_format($total_general, 0, '.', '.') ?></span>
                    </div>

                    <a href="checkout.php" class="block w-full bg-yellow-400 hover:bg-yellow-300 text-black font-black text-center uppercase tracking-widest py-5 rounded-xl transition-all shadow-lg hover:shadow-yellow-400/40 hover:-translate-y-1 mb-4 text-lg">
                        Finalizar Compra
                    </a>
                    
                    <div class="flex justify-center gap-2 grayscale opacity-40">
                        <div class="h-6 w-10 bg-white/20 rounded"></div>
                        <div class="h-6 w-10 bg-white/20 rounded"></div>
                        <div class="h-6 w-10 bg-white/20 rounded"></div>
                    </div>
                    <p class="text-center text-[10px] text-slate-600 font-bold uppercase mt-4">Pago 100% Seguro</p>
                </div>
            </div>

        </div>

    <?php endif; ?>
</main>

<script>
    function updateCartPage(id, cambio) {
        const fd = new FormData();
        fd.append('producto_id', id);
        fd.append('cambio', cambio);

        fetch('../provider/update_cart.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                if(data.status === 'success') {
                    window.location.reload(); // Recargar para actualizar etiquetas y totales complejos
                }
            });
    }

    function removeCartPage(id) {
        const fd = new FormData();
        fd.append('producto_id', id);

        fetch('../provider/remove_from_cart.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                if(data.status === 'success') {
                    window.location.reload();
                }
            });
    }
</script>

<?php include($base . 'sections/footer.php'); ?>