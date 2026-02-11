<?php
// Lógica de rutas (Igual que antes)
$inViews = (strpos($_SERVER['PHP_SELF'], 'views') !== false);
$base = $inViews ? "../" : "./";
$searchAction = $inViews ? "productos.php" : "views/productos.php";

require_once($base . 'provider/conexion.php'); //CONECCIONPHP

include($base . '/meta.php') ?>

<body class="bg-black text-white pt-20 md:pt-24"> 

<div id="menuBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden transition-opacity duration-300 md:hidden"></div>

<nav id="navbar" class="bg-black/95 backdrop-blur-md border-b border-white/10 w-full text-white fixed z-50 top-0 left-0 transition-all duration-500 font-sans">
    
    <div id="search-bar-container" class="absolute top-full left-0 w-full bg-slate-900 border-b border-yellow-300/30 overflow-hidden h-0 transition-all duration-300 ease-in-out shadow-2xl">
        <div class="container mx-auto px-4 py-6">
            <form action="<?= $base . $searchAction ?>" method="GET" class="relative flex items-center max-w-3xl mx-auto">
                <input type="text" name="q" placeholder="¿Qué buscas? Ej: Camiseta Local..." 
                       class="w-full bg-black text-white border-2 border-white/10 rounded-full py-3 pl-14 pr-4 focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 placeholder-slate-500 font-bold uppercase text-sm tracking-wider transition-all">
                
                <div class="absolute left-5 text-yellow-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button type="button" id="closeSearchBtn" class="ml-4 text-slate-400 hover:text-white font-black text-xs uppercase tracking-widest transition-colors">Cerrar</button>
            </form>
        </div>
    </div>

    <div id="navbar-container" class="container mx-auto px-4 h-20 flex justify-between items-center relative z-10">
    
        <div class="flex items-center gap-4">
            
            <button id="menuButton" class="md:hidden text-white hover:text-yellow-300 p-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <a href="<?= $base ?>index.php" class="flex items-center gap-3 group">
                <img id="nav-logo" src="<?= $base ?>assets/images/util/image.png" alt="logo" class="w-10 h-10 md:w-12 md:h-12 rounded-full shadow-lg shadow-yellow-500/10 group-hover:scale-110 transition-transform duration-300" />
                <div class="hidden sm:block leading-none">
                    <p class="text-lg font-black uppercase italic tracking-tighter text-white group-hover:text-yellow-300 transition-colors">Curacaví <span class="text-yellow-300 group-hover:text-white">FC</span></p>
                </div>
            </a>
        </div>

        <div class="hidden md:flex items-center gap-8">
            <a href="<?= $base ?>index.php" class="text-sm font-bold uppercase tracking-widest hover:text-yellow-300 transition-colors py-2 relative group">
                Inicio
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
            </a>

            <a href="<?= $base ?>../../../tienda_online/index.php" class="text-sm font-bold uppercase tracking-widest hover:text-yellow-300 transition-colors py-2 relative group">
                Tienda Oficial
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
            </a>

            <a href="<?= $base ?>../../../curacavi_fc/index.php" class="text-sm font-bold uppercase tracking-widest hover:text-yellow-300 transition-colors py-2 relative group">
                Sitio Oficial
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
            </a>
            
           
        </div>

    
    </div>

    <div id="sidebar" class="fixed top-0 left-0 w-[280px] h-screen bg-slate-950 z-[60] transform -translate-x-full transition-transform duration-300 ease-in-out border-r border-white/10 flex flex-col md:hidden">
        
        <div class="p-6 bg-yellow-400 flex justify-between items-center text-black shrink-0">
            <h2 class="font-black uppercase italic text-xl tracking-tighter">Menú</h2>
            <button id="closeMenu" class="text-2xl hover:rotate-90 transition-transform font-bold">✕</button>
        </div>
        
        <div class="p-5 space-y-6 overflow-y-auto h-full">
            
            <div class="space-y-2">
                <a href="<?= $base ?>index.php" class="flex items-center gap-3 p-3 text-white hover:bg-white/5 rounded-xl transition-colors font-bold uppercase tracking-widest text-sm">
                    🏠 Inicio
                </a>
                
                <div>
                    <button class="menu-option w-full flex justify-between items-center p-3 text-white hover:bg-white/5 rounded-xl transition-colors font-bold uppercase tracking-widest text-sm" data-target="sub-cat-mobile">
                        <span class="flex items-center gap-3">👕 Categorías</span> 
                        <span class="arrow-icon transition-transform">▼</span>
                    </button>
                    <div id="sub-cat-mobile" class="hidden pl-4 mt-2 space-y-1 border-l-2 border-white/10 ml-6">
                        <a href="<?= $base ?>views/productos.php" class="block py-2 px-3 text-yellow-300 text-sm font-bold">Ver Todo</a>
                        <?php foreach ($categoriasMenu as $cat) : ?>
                        <a href="<?= $base ?>views/productos.php?categoria_id=<?= $cat['id_categoria'] ?>" class="block py-2 px-3 text-slate-400 hover:text-white text-sm">
                            <?= htmlspecialchars($cat['nombre_categoria']) ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <a href="#" class="flex items-center gap-3 p-3 text-white hover:bg-white/5 rounded-xl transition-colors font-bold uppercase tracking-widest text-sm">
                    🎟️ Rifa 2026
                </a>
                
                <a href="#" class="flex items-center gap-3 p-3 text-white hover:bg-white/5 rounded-xl transition-colors font-bold uppercase tracking-widest text-sm">
                    ✉️ Contacto
                </a>
            </div>

            <div class="pt-6 border-t border-white/10">
                <a href="#" class="flex items-center justify-center gap-2 w-full bg-white/10 hover:bg-white/20 text-white font-bold py-3 rounded-xl transition-colors text-sm uppercase">
                    👤 Mi Cuenta
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const mobileDropdownBtn = document.querySelector('[data-target="sub-cat-mobile"]');
    if(mobileDropdownBtn) {
        mobileDropdownBtn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetDiv = document.getElementById(targetId);
            const arrow = this.querySelector('.arrow-icon');
            
            targetDiv.classList.toggle('hidden');
            if(!targetDiv.classList.contains('hidden')){
                arrow.style.transform = 'rotate(180deg)';
            } else {
                arrow.style.transform = 'rotate(0deg)';
            }
        });
    }
});
</script>