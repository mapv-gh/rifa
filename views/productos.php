<?php
session_start();
$base = "../"; 

require_once($base . 'provider/conexion.php');
require_once($base . 'components/producto_component.php');

// 1. CAPTURA DE VARIABLES
$categoria_id = (int)($_GET['categoria_id'] ?? 0);
$orden = $_GET['orden'] ?? 'newest';
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';

// 2. Título Dinámico
if (!empty($busqueda)) {
    $title = "Resultados para: \"" . htmlspecialchars($busqueda) . "\"";
} elseif ($categoria_id > 0) {
    $stmtCat = $conn->prepare("SELECT nombre_categoria FROM categorias WHERE id_categoria = ?");
    $stmtCat->bind_param("i", $categoria_id);
    $stmtCat->execute();
    $resCat = $stmtCat->get_result()->fetch_assoc();
    $title = $resCat ? $resCat['nombre_categoria'] : "Categoría no encontrada";
} else {
    $title = "Todos los Productos";
}

switch ($orden) {
    case 'precio_asc': $orderSql = "ORDER BY productos.precio_venta ASC"; break;
    case 'precio_desc': $orderSql = "ORDER BY productos.precio_venta DESC"; break;
    case 'nombre_asc': $orderSql = "ORDER BY productos.nombre ASC"; break;
    case 'nombre_desc': $orderSql = "ORDER BY productos.nombre DESC"; break;
    case 'newest': default: $orderSql = "ORDER BY productos.id DESC"; break;
}

// 4. Consulta SQL Dinámica
$sql = "SELECT productos.*, categorias.nombre_categoria, estados.nombre_estado
        FROM productos
        JOIN categorias ON productos.id_categoria = categorias.id_categoria
        JOIN estados ON productos.id_estado = estados.id_estado
        WHERE 1=1";

$params = [];
$types = "";

if ($categoria_id > 0) {
    $sql .= " AND productos.id_categoria = ?";
    $types .= "i";
    $params[] = $categoria_id;
}

if (!empty($busqueda)) {
    $sql .= " AND productos.nombre LIKE ?";
    $types .= "s";
    $params[] = "%" . $busqueda . "%";
}

$sql .= " " . $orderSql;

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include($base . 'header.php'); 
?>

<main class="container mx-auto px-4 mt-28 md:mt-40 mb-20">
    
    <div class="flex flex-col xl:flex-row justify-between items-end mb-6 md:mb-12 border-b border-white/10 pb-6 gap-6">
        
        <div class="w-full xl:w-auto">
            <nav class="flex text-slate-500 text-[10px] uppercase tracking-widest mb-2 font-bold">
                <a href="<?= $base ?>index.php" class="hover:text-yellow-300 transition-colors">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-slate-300">Tienda</span>
            </nav>
            
            <h1 class="text-3xl md:text-5xl font-black uppercase italic tracking-tighter text-white leading-none break-words mb-2">
                <?= htmlspecialchars($title) ?>
            </h1>
            
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                <span class="text-yellow-300 text-lg leading-none">•</span> 
                <?= count($productos) ?> Artículos disponibles
            </p>
        </div>
        
        <div class="w-full xl:w-auto flex flex-col md:flex-row gap-3 items-stretch md:items-center">
            
            <form method="GET" action="productos.php" class="relative w-full md:w-64">
                <?php if ($categoria_id > 0): ?><input type="hidden" name="categoria_id" value="<?= $categoria_id ?>"><?php endif; ?>
                <input type="hidden" name="orden" value="<?= htmlspecialchars($orden) ?>">

                <input type="text" name="q" value="<?= htmlspecialchars($busqueda) ?>" placeholder="Buscar..." 
                       class="w-full bg-slate-900/50 text-white text-xs font-bold border border-white/10 rounded-xl py-3 pl-4 pr-10 focus:outline-none focus:border-yellow-300 focus:ring-1 focus:ring-yellow-300 placeholder-slate-500 transition-all">
                <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-yellow-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>

            <form method="GET" class="relative w-full md:w-56">
                <?php if ($categoria_id > 0): ?><input type="hidden" name="categoria_id" value="<?= $categoria_id ?>"><?php endif; ?>
                <?php if (!empty($busqueda)): ?><input type="hidden" name="q" value="<?= htmlspecialchars($busqueda) ?>"><?php endif; ?>

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-yellow-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" /></svg>
                </div>
                <select name="orden" onchange="this.form.submit()" 
                        class="appearance-none w-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wide border border-white/10 rounded-xl py-3 pl-10 pr-8 cursor-pointer focus:outline-none focus:border-yellow-300 hover:bg-slate-800 transition-all">
                    <option value="newest" <?= $orden == 'newest' ? 'selected' : '' ?>>✨ Recientes</option>
                    <option value="precio_asc" <?= $orden == 'precio_asc' ? 'selected' : '' ?>>💲 Precio: Bajo</option>
                    <option value="precio_desc" <?= $orden == 'precio_desc' ? 'selected' : '' ?>>💰 Precio: Alto</option>
                    <option value="nombre_asc" <?= $orden == 'nombre_asc' ? 'selected' : '' ?>>🔤 Nombre: A-Z</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($productos)) : ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-3 gap-y-8 md:gap-x-6 md:gap-y-12">
            <?= productoComponent($productos, 0); ?>
        </div>
    <?php else : ?>
        <div class="py-32 text-center bg-slate-900/50 rounded-3xl border border-dashed border-white/10 flex flex-col items-center justify-center">
            <span class="text-4xl mb-4 grayscale opacity-50">🔍</span>
            <p class="text-slate-500 italic text-xl">No encontramos coincidencias para "<?= htmlspecialchars($busqueda) ?>"</p>
            <a href="productos.php" class="mt-6 inline-block bg-yellow-400 text-black font-black px-8 py-3 rounded-2xl hover:bg-yellow-300 transition-all shadow-lg shadow-yellow-400/20">
                Ver todo el catálogo
            </a>
        </div>
    <?php endif; ?>
</main>

<?php include($base . 'sections/footer.php'); ?>