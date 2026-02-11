<?php
$baseFooter = (strpos($_SERVER['PHP_SELF'], 'views') !== false) ? "../" : "./";

$categoriasFooter = $categoriasHeader ?? $categorias ?? [];

if (empty($categoriasFooter)) {
    require_once($baseFooter . 'provider/conexion.php');
    $sqlRespaldo = "SELECT id_categoria, nombre_categoria FROM categorias LIMIT 5";
    $resRespaldo = $conn->query($sqlRespaldo);
    if ($resRespaldo) {
        $categoriasFooter = $resRespaldo->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<footer class="bg-slate-900 text-slate-300 pt-12 pb-6 border-t border-white/5 mt-5">
    <div class="container mx-auto px-6">
        <div class="flex justify-between gap-12">
            
            <div class="col-span-1 md:col-span-1">
                <h2 class="text-2xl font-black text-yellow-300 mb-4 italic uppercase tracking-tighter">
                    Curacaví <span class="text-white">FC</span>
                </h2>
                <p class="text-sm leading-relaxed text-slate-400">
                    Tu tienda oficial conectada. Viste los colores del club y apoya al equipo local con productos de alta calidad.
                </p>
            </div>

            <div>
                <h3 class="text-white font-bold mb-4 uppercase tracking-widest text-xs">Sitios</h3>
                <ul class="space-y-2 text-sm">
                        <li>
                            <a href="<?= $baseFooter ?>../../tienda_online/index.php" 
                               class="hover:text-yellow-300 transition-colors duration-200 flex items-center group">
                                <span class="w-0 group-hover:w-2 h-0.5 bg-yellow-300 mr-0 group-hover:mr-2 transition-all"></span>
                                <?= htmlspecialchars('Tienda Oficial') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $baseFooter ?>../../curacavi_fc/index.php"
                               class="hover:text-yellow-300 transition-colors duration-200 flex items-center group">
                                <span class="w-0 group-hover:w-2 h-0.5 bg-yellow-300 mr-0 group-hover:mr-2 transition-all"></span>
                                <?= htmlspecialchars('Sitio Web Oficial') ?>
                            </a>
                        </li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold mb-4 uppercase tracking-widest text-xs">Contacto</h3>
                <p class="text-sm mb-2 text-slate-400 font-medium italic">Curacaví, Región Metropolitana</p>
                <p class="text-sm text-yellow-300 font-black tracking-tight">contacto@curacavifc.cl</p>
                
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-yellow-300 transition-colors">Privacidad</a>
                    <a href="#" class="hover:text-yellow-300 transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </div>
    
</footer>
<div id="toast-container" class="fixed bottom-5 right-5 z-[100] flex flex-col gap-3 pointer-events-none"></div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="<?= $baseFooter ?>assets/js/script.js"></script>
</body>
</html>