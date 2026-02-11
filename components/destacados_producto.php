<?php
// producto_component.php

function destacadoProducto($productos)
{
    ob_start();
    foreach ($productos as $producto) :
        $idProducto = $producto['id'];
        $carpetaProducto = "../assets/images/productos/$idProducto/";
        $imagenesProducto = [];

        if (is_dir($carpetaProducto)) {
            $imagenesProducto = array_diff(scandir($carpetaProducto), array('..', '.'));
        }
?>
        <div class="relative border p-4 rounded-lg flex items-center justify-center flex-col max-w-56 background-madera">
            <?php if ($producto['descuento'] > 0) : ?>
                <div class="ribbon">
                    <span>-<?= htmlspecialchars($producto['descuento']) ?>%</span>
                </div>
            <?php endif; ?>
            <?php if (!empty($imagenesProducto)) : ?>
                <div class="swiper swiper_producto w-full h-full">
                    <div class="swiper-wrapper">
                        <?php foreach ($imagenesProducto as $imagen) : ?>
                            <div class="swiper-slide text-center text-lg flex justify-center items-center rounded-lg bg-cover max-w-52 p-1">
                                <img src="<?= htmlspecialchars($carpetaProducto . $imagen) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="rounded-lg">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next text-pink-600"></div>
                    <div class="swiper-button-prev text-pink-600"></div>
                </div>
            <?php else : ?>
                <img class="max-sm:w-28 rounded-md" src="../assets/images/util/Imagen_no_disponible.svg.png" alt="<?= htmlspecialchars($producto['nombre']) ?>">
            <?php endif; ?>
            <div class="bg-white p-2 rounded-md mt-5 text-sm">
                <h2 class="font-bold mb-1 text-center"><?= htmlspecialchars($producto['nombre']) ?></h2>
                <p class="text-black font-semibold mb-2 text-center line-clamp-2 overflow-ellipsis"><?= htmlspecialchars($producto['descripcion']) ?></p>
                <?php if ($producto['descuento'] > 0) :
                    $precioOriginal = $producto['precio_venta'];
                    $precioConDescuento = $precioOriginal - ($precioOriginal * ($producto['descuento'] / 100));
                ?>
                    <p class="text-black font-semibold mb-2 text-center"><span class="line-through text-red-600">$<?= number_format($precioOriginal, 0, ',', '.') ?></span> $<?= number_format($precioConDescuento, 0, ',', '.') ?></p>
                <?php else : ?>
                    <p class="text-black font-semibold mb-2 text-center">$<?= number_format($producto['precio_venta'], 0, ',', '.') ?></p>
                <?php endif; ?>
            </div>
            <form onsubmit="addToCart(event)" method="POST" class="flex justify-center items-center m-2 gap-3">
                <input type="hidden" name="producto_id" value="<?= htmlspecialchars($producto['id']) ?>">
                <input type="number" inputmode="numeric" name="producto_cant" min="1" class="w-14 rounded-md p-1 bg-purple-500 text-white" value="1" />
                <button type="submit" class="bg-purple-500 text-white p-1 mt-2 rounded text-sm">
                    <img src="../assets/images/util/cart_plus.svg" alt="" width="30px">
                </button>
            </form>
        </div>
<?php
    endforeach;
    $output = ob_get_clean(); // Captura el contenido del buffer y lo limpia
    return $output;
}
?>