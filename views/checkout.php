<?php
session_start();
$base = "../";
require_once($base . 'provider/conexion.php');

// Seguridad: Si el carrito está vacío, mandar al inicio
if (empty($_SESSION['carrito'])) {
    header("Location: ../index.php");
    exit;
}

$title = "Finalizar Compra | Curacaví FC";
include($base . 'header.php'); 

// --- CALCULAR TOTALES PARA EL RESUMEN ---
$total_general = 0;
$cantidad_items = 0;

foreach ($_SESSION['carrito'] as $id => $item) {
    $precio = $item['precio'];
    $cant = $item['cantidad'];
    
    // Lógica Rifa
    if ($id == 4) {
        if ($cant >= 5) $precio = 2000;
        elseif ($cant >= 3) $precio = 2500;
        else $precio = 3000;
    }
    
    $total_general += ($precio * $cant);
    $cantidad_items += $cant;
}
?>

<main class="container mx-auto px-4 mt-32 mb-20 min-h-[70vh]">

    <div class="flex flex-col lg:flex-row gap-12 items-start max-w-6xl mx-auto">
        
        <div class="w-full lg:w-2/3">
            
            <div class="mb-8">
                <a href="carrito.php" class="text-slate-400 hover:text-yellow-400 text-sm font-bold flex items-center gap-2 mb-4 transition-colors">
                    <span>←</span> Volver al Carrito
                </a>
                <h1 class="text-3xl md:text-4xl font-black uppercase italic text-white leading-none mb-2">
                    Datos del Comprador
                </h1>
                <p class="text-slate-500 text-sm">Ingresa tus datos para recibir tus tickets.</p>
            </div>

            <form id="form-checkout" class="space-y-6" onsubmit="procesarPago(event)">
                
                <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 md:p-8">
                    <h3 class="text-white font-black uppercase italic text-lg mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 bg-yellow-400 text-black rounded-full flex items-center justify-center text-sm not-italic">1</span>
                        Información Personal
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Nombre</label>
                            <input type="text" name="nombre" required placeholder="Ej: Juan" 
                                class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder:text-slate-700">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Apellido</label>
                            <input type="text" name="apellido" required placeholder="Ej: Pérez" 
                                class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder:text-slate-700">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">RUT</label>
                            <input type="text" name="rut" id="inputRut" required placeholder="Ej: 12.345.678-9" oninput="formatearRut(this)" maxlength="12"
                                class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder:text-slate-700">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Teléfono</label>
                            <div class="flex">
                                <span class="bg-white/5 border border-white/10 border-r-0 rounded-l-xl px-3 py-3 text-slate-400 text-sm flex items-center">+56</span>
                                <input type="tel" name="telefono" required placeholder="9 1234 5678" 
                                    class="w-full bg-black border border-white/10 rounded-r-xl px-4 py-3 text-white focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder:text-slate-700">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 mt-6">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Correo Electrónico</label>
                        <input type="email" name="email" required placeholder="ejemplo@correo.com" 
                            class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder:text-slate-700">
                        <p class="text-[10px] text-yellow-500/80 ml-1">⚠️ Aquí recibirás tus tickets digitales.</p>
                    </div>
                </div>

                <div class="bg-slate-900/50 border border-white/10 rounded-3xl p-6 md:p-8">
                    <h3 class="text-white font-black uppercase italic text-lg mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 bg-yellow-400 text-black rounded-full flex items-center justify-center text-sm not-italic">2</span>
                        Método de Pago
                    </h3>
                    
                    <label class="relative flex items-center justify-between bg-black border-2 border-yellow-400 rounded-xl p-4 cursor-pointer shadow-[0_0_15px_rgba(250,204,21,0.1)]">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="pago" value="webpay" checked class="w-5 h-5 text-yellow-400 bg-slate-800 border-white/20 focus:ring-yellow-400">
                            <div>
                                <p class="text-white font-bold uppercase text-sm">Webpay Plus</p>
                                <p class="text-slate-500 text-xs">Débito, Crédito y Prepago</p>
                            </div>
                        </div>
                        <div class="h-8 bg-white/90 px-2 rounded flex items-center">
                           <img src="https://www.transbankdevelopers.cl/public/library/img/svg/logo_webpay_plus.svg" alt="Webpay" class="h-5">
                        </div>
                    </label>
                </div>

                <button type="submit" class="lg:hidden w-full bg-yellow-400 text-black font-black uppercase text-lg py-5 rounded-xl shadow-lg hover:bg-yellow-300 transition-all">
                    Pagar $<?= number_format($total_general, 0, '.', '.') ?>
                </button>

            </form>
        </div>

        <div class="w-full lg:w-1/3 lg:sticky lg:top-32">
            <div class="bg-black border border-yellow-400/20 rounded-[2rem] p-6 md:p-8 shadow-[0_0_40px_rgba(0,0,0,0.8)] relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-400/5 blur-[50px] rounded-full pointer-events-none"></div>

                <h3 class="text-xl font-black uppercase italic text-white mb-6 border-b border-white/10 pb-4 relative z-10">
                    Resumen
                </h3>

                <div class="space-y-3 mb-6 max-h-[200px] overflow-y-auto custom-scrollbar pr-2">
                    <?php foreach ($_SESSION['carrito'] as $id => $item): 
                        $p_unit = $item['precio'];
                        // Lógica visual simple para el resumen
                        if($id == 4) {
                            if($item['cantidad'] >= 5) $p_unit = 2000;
                            elseif($item['cantidad'] >= 3) $p_unit = 2500;
                        }
                    ?>
                        <div class="flex justify-between items-start text-sm group">
                            <div class="text-slate-400 group-hover:text-white transition-colors">
                                <span class="text-yellow-400 font-bold"><?= $item['cantidad'] ?>x</span> 
                                <?= $item['nombre'] ?>
                            </div>
                            <div class="text-white font-bold">
                                $<?= number_format($p_unit * $item['cantidad'], 0, '.', '.') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-white/10 pt-4 space-y-2 mb-8">
                    <div class="flex justify-between text-slate-400 text-sm">
                        <span>Total Items</span>
                        <span><?= $cantidad_items ?></span>
                    </div>
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-white/10">
                        <span class="text-white font-bold uppercase">Total a Pagar</span>
                        <span class="text-3xl font-black text-yellow-400">$<?= number_format($total_general, 0, '.', '.') ?></span>
                    </div>
                </div>

                <button form="form-checkout" type="submit" class="hidden lg:block w-full bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-300 hover:to-yellow-400 text-black font-black uppercase tracking-widest py-4 rounded-xl transition-all shadow-lg hover:shadow-yellow-400/40 hover:-translate-y-1 text-lg">
                    Pagar Ahora
                </button>

                <p class="text-center text-[10px] text-slate-600 font-bold uppercase mt-4">
                    Tus datos están protegidos por SSL
                </p>
            </div>
        </div>

    </div>
</main>

<script>
    // Formatear RUT Chileno (XX.XXX.XXX-X)
    function formatearRut(input) {
        let rut = input.value.replace(/[^0-9kK]/g, ""); // Limpiar todo menos números y K
        
        if (rut.length > 1) {
            const cuerpo = rut.slice(0, -1);
            const dv = rut.slice(-1).toUpperCase();
            
            // Poner puntos al cuerpo
            input.value = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, ".") + "-" + dv;
        } else {
            input.value = rut;
        }
    }

    // Simulación de Proceso de Pago
    function procesarPago(e) {
        e.preventDefault();
        const btn = e.target.querySelector('button[type="submit"]');
        const originalText = btn.innerText;
        
        // Estado de carga visual
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Procesando...';
        btn.classList.add('opacity-75');

        // Aquí iría el fetch a tu backend real (ej: provider/crear_orden.php)
        setTimeout(() => {
            alert("¡Redirigiendo a Webpay! (Simulación)");
            // window.location.href = "provider/iniciar_webpay.php"; 
            btn.disabled = false;
            btn.innerText = originalText;
            btn.classList.remove('opacity-75');
        }, 1500);
    }
</script>

<?php include($base . 'sections/footer.php'); ?>