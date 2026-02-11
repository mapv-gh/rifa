<?php
// --- 1. DEFINICIÓN DEL COMPONENTE (FUNCIÓN PHP) ---
function renderTicketCard($titulo, $precio, $cantidad, $emoji, $subtitulo, $extraHtml, $isFeatured = false) {
    global $id_ticket_real; // Usamos la variable global del ID
    
    // Clases dinámicas según si es destacado o normal
    $containerClasses = $isFeatured 
        ? "relative bg-black border-2 border-yellow-400 z-20 shadow-[0_0_50px_rgba(250,204,21,0.25)] transform md:scale-110" 
        : "bg-black/80 border border-yellow-400/30 relative group hover:border-yellow-400 hover:shadow-[0_0_30px_rgba(250,204,21,0.2)]";

    $buttonClasses = $isFeatured
        ? "bg-yellow-400 hover:bg-yellow-300 text-black shadow-[0_5px_20px_rgba(250,204,21,0.4)] hover:-translate-y-1 text-base"
        : "border-2 border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-black text-sm";
    
    $emojiClasses = $isFeatured
        ? "w-16 h-16 bg-gradient-to-br from-yellow-300 to-yellow-500 shadow-lg shadow-yellow-400/30 animate-pulse text-black text-3xl"
        : "w-14 h-14 bg-yellow-400/10 border border-yellow-400/20 text-yellow-400 text-2xl";

    $btnText = $isFeatured ? "Comprar Pack {$cantidad}x" : "Agregar {$cantidad}";

    ?>
    <div class="<?= $containerClasses ?> rounded-3xl p-8 flex flex-col items-center justify-between transition-all duration-300">
        
        <?php if ($isFeatured): ?>
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-yellow-400 text-black font-black uppercase text-[10px] px-6 py-1.5 rounded-full shadow-lg tracking-widest whitespace-nowrap">
                🔥 Más Vendido
            </div>
        <?php endif; ?>
        
        <div class="text-center w-full pt-2">
            <div class="<?= $emojiClasses ?> mx-auto rounded-full flex items-center justify-center mb-4">
                <?= $emoji ?>
            </div>
            
            <span class="text-yellow-200/50 text-[10px] font-bold uppercase tracking-widest"><?= $subtitulo ?></span>
            <h3 class="text-white font-black italic text-2xl mt-2"><?= $titulo ?></h3>
            
            <div class="my-6">
                <span class="text-5xl font-black text-white tracking-tight"><?= $precio ?></span>
            </div>
            
            <div class="text-xs font-medium">
                <?= $extraHtml ?>
            </div>
        </div>
        
        
    </div>
    <?php
}
?>

<section id="comprar-rifa" class="py-24 relative overflow-hidden">
    
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-4xl h-[500px] bg-yellow-500/5 blur-[120px] rounded-full pointer-events-none"></div>

    <?php $id_ticket_real = 4; // Configuración Global ?>

    <div class="container mx-auto px-4 relative z-10">
        
        <div class="text-center mb-16">
            <span class="inline-block py-1 px-3 rounded-lg bg-yellow-400/10 border border-yellow-400/20 text-yellow-300 text-[10px] font-black uppercase tracking-[0.3em] mb-4 animate-pulse">
                ⚡ Oportunidad Única
            </span>
            <h2 class="text-4xl md:text-6xl font-black uppercase italic tracking-tighter text-white leading-none drop-shadow-xl">
                Elige tu <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-yellow-100 to-yellow-300">Pack Ganador</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto items-stretch">

            <?php renderTicketCard(
                "1 Ticket", 
                "$3.000", 
                1, 
                "🎫", 
                "INICIAL", 
                "<p class='text-slate-400'>La suerte empieza aquí</p>"
            ); ?>

            <?php renderTicketCard(
                "5 Tickets", 
                "<span class='text-6xl text-yellow-400 drop-shadow-md'>$10.000</span>", 
                5, 
                "🏆", 
                "", // Sin subtítulo porque tiene etiqueta flotante
                "<div class='flex flex-col items-center'>
                    <span class='text-slate-500 text-xs font-bold uppercase line-through decoration-yellow-500/50 mb-2'>Normal: $15.000</span>
                    <div class='bg-yellow-400/20 border border-yellow-400/50 px-4 py-1 rounded-lg inline-block'>
                        <p class='text-yellow-200 text-xs font-black uppercase tracking-wider'>¡Ahorras $5.000!</p>
                    </div>
                 </div>",
                true // TRUE activa el modo destacado
            ); ?>

            <?php renderTicketCard(
                "2 Tickets", 
                "$5.000", 
                2, 
                "🤝", 
                "DÚO", 
                "<p class='text-green-400 font-bold'>Ahorras $1.000</p>"
            ); ?>
        </div>
    </div>
    <div class="w-56 mx-auto mt-20">
        <form onsubmit="addToCart(event)" method="POST" class="">
            <input type="hidden" name="producto_id" value="1">
            <input type="hidden" name="producto_cant" value="1">
            <button type="submit" class="w-full font-black uppercase py-3 rounded-xl transition-all tracking-widest bg-yellow-400 hover:bg-yellow-300 text-black shadow-[0_5px_20px_rgba(250,204,21,0.4)] hover:-translate-y-1 text-base">
                Comprar
            </button>
        </form>
    </div>
</section>