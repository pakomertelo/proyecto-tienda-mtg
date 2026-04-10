<?php
session_start();
require_once __DIR__ . '/valoraciones.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$idioma = $_COOKIE['idioma'] ?? 'es';
$tema = $_COOKIE['tema'] ?? 'oscuro';
$tamano = $_COOKIE['tamano_fuente'] ?? 'normal';

$textos = [
    'es' => [
        'titulo' => 'Tienda de Cartas Magic the Gathering',
        'titulo_pagina' => 'Tienda Magic - Cartas en venta',
        'carrito' => 'Carrito',
        'deseos' => 'Lista de deseos',
        'preferencias' => 'Preferencias',
        'cerrar_sesion' => 'Cerrar sesión',
        'anadir_carrito' => 'Añadir al carrito',
        'anadir_deseados' => 'Añadir a deseados',
        'finalizar' => 'Finalizar compra',
        'vaciar' => 'Vaciar carrito',
        'cartas_disponibles' => 'Cartas disponibles (%d)',
        'foto' => 'Foto',
        'nombre_carta' => 'Nombre de la carta',
        'precio' => 'Precio (€)',
        'bienvenida_usuario' => 'Bienvenido, %s.',
        'bienvenida_admin' => 'Bienvenido, admin. Has iniciado sesión como administrador.',
        'carrito_vacio' => 'Carrito vacío.',
        'producto' => 'Producto',
        'precio_corto' => 'Precio',
        'cantidad' => 'Cantidad',
        'subtotal' => 'Subtotal',
        'acciones' => 'Acciones',
        'eliminar' => 'Eliminar',
        'total_label' => 'Total: ',
        'compra_finalizada' => 'Compra finalizada el ',
        'ultima_compra' => 'Última compra: ',
        'paginacion_anterior' => 'Anterior',
        'paginacion_siguiente' => 'Siguiente',
        'paginacion_info' => 'Página %d de %d'
    ],
    'en' => [
        'titulo' => 'Magic the Gathering Store',
        'titulo_pagina' => 'Magic Store - Cards on sale',
        'carrito' => 'Cart',
        'deseos' => 'Wishlist',
        'preferencias' => 'Preferences',
        'cerrar_sesion' => 'Log out',
        'anadir_carrito' => 'Add to cart',
        'anadir_deseados' => 'Add to wishlist',
        'finalizar' => 'Checkout',
        'vaciar' => 'Clear cart',
        'cartas_disponibles' => 'Available cards (%d)',
        'foto' => 'Photo',
        'nombre_carta' => 'Card name',
        'precio' => 'Price (€)',
        'bienvenida_usuario' => 'Welcome, %s.',
        'bienvenida_admin' => 'Welcome, admin. You are logged in as administrator.',
        'carrito_vacio' => 'Cart is empty.',
        'producto' => 'Product',
        'precio_corto' => 'Price',
        'cantidad' => 'Quantity',
        'subtotal' => 'Subtotal',
        'acciones' => 'Actions',
        'eliminar' => 'Remove',
        'total_label' => 'Total: ',
        'compra_finalizada' => 'Purchase completed on ',
        'ultima_compra' => 'Last purchase: ',
        'paginacion_anterior' => 'Previous',
        'paginacion_siguiente' => 'Next',
        'paginacion_info' => 'Page %d of %d'
    ]
];

$t = $textos[$idioma] ?? $textos['es'];

$usuario = $_SESSION['username'];
$rol = $_SESSION['rol'] ?? 'cliente';

$mensajeBienvenida = sprintf($t['bienvenida_usuario'], htmlspecialchars($usuario));
if ($rol === 'admin') {
    $mensajeBienvenida = $t['bienvenida_admin'];
}

$directorioImagenes = realpath(__DIR__ . '/../img');
$cartas = [];

if ($directorioImagenes !== false) {
    $imagenes = glob($directorioImagenes . '/*.{png,jpg,jpeg,webp}', GLOB_BRACE) ?: [];
    natcasesort($imagenes);

    $id = 1;
    foreach ($imagenes as $rutaImagen) {
        $archivo = basename($rutaImagen);
        $nombre = pathinfo($archivo, PATHINFO_FILENAME);

        $precioBase = (abs(crc32($archivo)) % 4500) / 100 + 1;
        $precio = round($precioBase, 2);

        $cartas[] = [
            'id' => $id++,
            'nombre' => $nombre,
            'precio' => $precio,
            'imagen' => $archivo
        ];
    }
}

$porPagina = 20;
$totalCartas = count($cartas);
$totalPaginas = max(1, (int) ceil($totalCartas / $porPagina));
$paginaActual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$paginaActual = max(1, min($paginaActual, $totalPaginas));
$inicio = ($paginaActual - 1) * $porPagina;
$cartasPagina = array_slice($cartas, $inicio, $porPagina);

$resumenValoraciones = [];
$votosUsuario = [];
try {
    $pdo = obtenerConexion();
    $resumenValoraciones = obtenerResumenValoraciones($pdo);
    foreach ($cartasPagina as $carta) {
        $votosUsuario[$carta['id']] = usuarioYaVoto($pdo, (int) $carta['id'], $usuario);
    }
} catch (Throwable $e) {
    $resumenValoraciones = [];
    foreach ($cartasPagina as $carta) {
        $votosUsuario[$carta['id']] = false;
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($idioma); ?>">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($t['titulo_pagina']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="<?php echo htmlspecialchars($tema); ?> <?php echo 'fuente-' . htmlspecialchars($tamano); ?>">
    <div class="contenedor">
        <h1><?php echo $t['titulo']; ?></h1>
        <p><?php echo $mensajeBienvenida; ?></p>

        <nav class="menu">
            <a href="logout.php"><?php echo $t['cerrar_sesion']; ?></a>
            <a href="listaDeseos.php"><?php echo $t['deseos']; ?></a>
            <a href="preferencias.php"><?php echo $t['preferencias']; ?></a>
        </nav>

        <hr>
        <h2><?php echo sprintf($t['cartas_disponibles'], $totalCartas); ?></h2>

        <div class="productos-grid">
            <?php foreach ($cartasPagina as $carta): ?>
                <article class="producto-card">
                    <img src="../img/<?php echo rawurlencode($carta['imagen']); ?>"
                        alt="<?php echo htmlspecialchars($carta['nombre']); ?>"
                        class="producto-img">

                    <h3><?php echo htmlspecialchars($carta['nombre']); ?></h3>
                    <p class="precio-card"><?php echo number_format($carta['precio'], 2, ',', '.'); ?> €</p>

                    <p id="valoracion-<?php echo $carta['id']; ?>" class="valoracion-texto">
                        <?php
                        $resumen = $resumenValoraciones[$carta['id']] ?? ['total_votos' => 0, 'media' => 0];
                        echo htmlspecialchars(textoValoracion($resumen));
                        ?>
                    </p>
                    <form class="form-voto" data-id="<?php echo $carta['id']; ?>">
                        <div class="selector-estrellas">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <button type="button"
                                    class="estrella-voto"
                                    data-voto="<?php echo $i; ?>"
                                    <?php echo !empty($votosUsuario[$carta['id']]) ? 'disabled' : ''; ?>
                                    title="<?php echo $i; ?> estrella(s)">★</button>
                            <?php endfor; ?>
                        </div>
                    </form>

                    <div class="acciones-card">
                        <button type="button" class="btn-carrito" data-nombre="<?php echo htmlspecialchars($carta['nombre']); ?>" data-precio="<?php echo $carta['precio']; ?>"><?php echo $t['anadir_carrito']; ?></button>
                        <form action="anadirDeseo.php" method="post">
                            <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($carta['nombre']); ?>">
                            <input type="hidden" name="precio" value="<?php echo $carta['precio']; ?>">
                            <button type="submit" class="btn-deseados"><?php echo $t['anadir_deseados']; ?></button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPaginas > 1): ?>
            <nav class="paginacion" aria-label="Paginación de productos">
                <?php if ($paginaActual > 1): ?>
                    <a class="btn btn-paginacion" href="?pagina=<?php echo $paginaActual - 1; ?>"><?php echo $t['paginacion_anterior']; ?></a>
                <?php endif; ?>

                <span class="paginacion-info"><?php echo sprintf($t['paginacion_info'], $paginaActual, $totalPaginas); ?></span>

                <?php if ($paginaActual < $totalPaginas): ?>
                    <a class="btn btn-paginacion" href="?pagina=<?php echo $paginaActual + 1; ?>"><?php echo $t['paginacion_siguiente']; ?></a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    </div>

    <button id="btn-toggle-carrito" type="button" class="btn-toggle-carrito"><?php echo $t['carrito']; ?></button>
    <aside id="carrito-section" class="carrito-lateral">
        <h3><?php echo $t['carrito']; ?></h3>
        <div id="carrito-lista"></div>
        <p id="carrito-total"><?php echo $t['total_label']; ?>0 €</p>
        <button id="btn-vaciar" type="button"><?php echo $t['vaciar']; ?></button>
        <button id="btn-finalizar" type="button"><?php echo $t['finalizar']; ?></button>
        <p id="mensaje-compra"></p>
    </aside>

    <script>
    window.textosCarrito = <?php echo json_encode([
                                'carrito_vacio' => $t['carrito_vacio'],
                                'producto' => $t['producto'],
                                'precio' => $t['precio_corto'],
                                'cantidad' => $t['cantidad'],
                                'subtotal' => $t['subtotal'],
                                'acciones' => $t['acciones'],
                                'eliminar' => $t['eliminar'],
                                'total' => $t['total_label'],
                                'compra_finalizada' => $t['compra_finalizada'],
                                'ultima_compra' => $t['ultima_compra']
                            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    </script>

    <script src="js/tienda.js"></script>
    <script src="js/valoraciones.js"></script>
</body>

</html>
