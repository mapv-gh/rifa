<?php
function productoComponent($productos, $index)
{
    ob_start();
    foreach ($productos as $producto) :
        $id = $producto['id'];
        
        // Ajuste de ruta base para assets
        $pathBase = ($index == 1) ? "./" : "../"; 
        
        // Ajuste de ruta para el LINK DE DETALLE
        // Si index=1 (Home), el link es 'views/detalle.php'
        // Si index=0 (Dentro de views), el link es 'detalle.php'
        $linkDetalle = ($index == 1) ? "views/detalle.php?id=$id" : "detalle.php?id=$id";

        $folder = $pathBase . "assets/images/productos/$id/";
        $icon_cart = $pathBase . "assets/images/util/cart_plus.svg";
        
        // Lógica de imágenes
        $imagenesProducto = [];
        if (is_dir($folder)) {
            $imagenesProducto = array_diff(scandir($folder), array('..', '.'));
        }
        $useSwiper = count($imagenesProducto) > 1;

        // Lógica de precios
        $precioOriginal = (float)$producto['precio_venta'];
        $descuento = (float)($producto['descuento'] ?? 0);
        $precioFinal = ($descuento > 0) ? $precioOriginal * (1 - ($descuento / 100)) : $precioOriginal;
?>
        <div class="group relative bg-slate-900 border border-white/10 rounded-2xl md:rounded-3xl overflow-hidden transition-all duration-500 hover:shadow-[0_0_40px_rgba(234,179,8,0.15)] hover:-translate-y-2 flex flex-col h-full">
            
            <?php if ($descuento > 0) : ?>
                <div class="absolute top-2 left-2 md:top-3 md:left-3 z-20 bg-red-600 text-white text-[9px] md:text-[10px] font-black px-2 py-0.5 md:px-2.5 md:py-1 rounded-full shadow-lg uppercase tracking-tighter">
                    -<?= $descuento ?>%
                </div>
            <?php endif; ?>

            <a href="<?= $linkDetalle ?>" class="block relative h-40 sm:h-48 md:h-64 w-full bg-white/5 overflow-hidden p-2 md:p-4 cursor-pointer">
                <?php if ($useSwiper) : ?>
                    <div class="swiper swiper_producto h-full w-full">
                        <div class="swiper-wrapper">
                            <?php foreach ($imagenesProducto as $imagen) : ?>
                                <div class="swiper-slide flex items-center justify-center">
                                    <img src="<?= htmlspecialchars($folder . $imagen) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-110">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination !bottom-0 text-yellow-300 scale-75 md:scale-100"></div>
                    </div>
                <?php else : ?>
                    <div class="flex items-center justify-center h-full">
                        <?php $imgSrc = !empty($imagenesProducto) ? $folder . reset($imagenesProducto) : $pathBase . "assets/images/util/Imagen_no_disponible.svg.png"; ?>
                        <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-110">
                    </div>
                <?php endif; ?>
            </a>

            <div class="p-3 md:p-5 flex flex-col flex-grow">
                <a href="<?= $linkDetalle ?>" class="block">
                    <h2 class="text-white font-black text-sm md:text-lg mb-1 group-hover:text-yellow-400 transition-colors uppercase italic tracking-tighter leading-tight line-clamp-2">
                        <?= htmlspecialchars($producto['nombre']) ?>
                    </h2>
                </a>
                
                <div class="flex flex-wrap items-baseline gap-1.5 md:gap-2 mb-3 mt-1">
                    <span class="text-yellow-400 font-black text-lg md:text-2xl">$<?= number_format($precioFinal, 0, ',', '.') ?></span>
                    <?php if ($descuento > 0) : ?>
                        <span class="text-slate-500 text-[10px] md:text-sm line-through">$<?= number_format($precioOriginal, 0, ',', '.') ?></span>
                    <?php endif; ?>
                </div>

                <form onsubmit="addToCart(event)" method="POST" class="mt-auto flex items-stretch gap-1.5 md:gap-2">
                    <input type="hidden" name="producto_id" value="<?= $id ?>">
                    
                    <div class="flex items-center bg-white/5 rounded-lg border border-white/10">
                        <button type="button" onclick="decrementCantidad(this)" class="w-6 h-8 md:w-8 md:h-10 flex items-center justify-center text-white hover:bg-white/10 rounded-l-lg transition-colors text-xs md:text-base font-bold">-</button>
                        <input type="number" name="producto_cant" value="1" readonly 
                               class="bg-transparent w-6 md:w-8 text-center text-xs md:text-sm font-bold text-yellow-400 border-none focus:ring-0 p-0 h-full">
                        <button type="button" onclick="incrementCantidad(this)" class="w-6 h-8 md:w-8 md:h-10 flex items-center justify-center text-white hover:bg-white/10 rounded-r-lg transition-colors text-xs md:text-base font-bold">+</button>
                    </div>

                    <button type="submit" class="flex-grow bg-yellow-400 hover:bg-yellow-300 text-black font-black rounded-lg md:rounded-xl transition-all active:scale-95 flex justify-center items-center shadow-lg shadow-yellow-400/10">
                        <img src="<?= $icon_cart ?>" alt="Añadir" class="w-4 h-4 md:w-6 md:h-6">
                    </button>
                </form>
            </div>
        </div>
<?php
    endforeach;
    return ob_get_clean();
}
?>