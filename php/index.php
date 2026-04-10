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
        'ultima_compra' => 'Última compra: '
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
        'ultima_compra' => 'Last purchase: '
    ]
];

$t = $textos[$idioma] ?? $textos['es'];

$usuario = $_SESSION['username'];
$rol = $_SESSION['rol'] ?? 'cliente';

$mensajeBienvenida = sprintf($t['bienvenida_usuario'], htmlspecialchars($usuario));
if ($rol === 'admin') {
    $mensajeBienvenida = $t['bienvenida_admin'];
}

    $cartas = [
        ['id' => 1, 'nombre' => 'Aloy, Savior of Meridian', 'precio' => 29.50, 'imagen' => 'Aloy, Savior of Meridian.jpg'],
        ['id' => 2, 'nombre' => 'Cooper Myr (Grazer)', 'precio' => 3.00, 'imagen' => 'Cooper Myr (Grazer).png'],
        ['id' => 3, 'nombre' => 'Cultivate', 'precio' => 1.20, 'imagen' => 'Cultivate.png'],
        ['id' => 4, 'nombre' => 'Cyberdrive Awakener (Dreadwing)', 'precio' => 2.80, 'imagen' => 'Cyberdrive Awakener (Dreadwing).png'],
        ['id' => 5, 'nombre' => 'Cyberman Patrol (Sawtooth)', 'precio' => 4.50, 'imagen' => 'Cyberman Patrol (Sawtooth).png'],
        ['id' => 6, 'nombre' => 'Darksteel Juggernaut (Shellsnaper)', 'precio' => 0.80, 'imagen' => 'Darksteel Juggernaut (Shellsnaper).jpg'],
        ['id' => 7, 'nombre' => 'Diamond Weapon (Tallneck)', 'precio' => 2.00, 'imagen' => 'Diamond Weapon (Tallneck).png'],
        ['id' => 8, 'nombre' => "Garruk's Uprising (Faro Plague)", 'precio' => 5.00, 'imagen' => 'Garruk’s Uprising (Faro Plague).png'],
        ['id' => 9, 'nombre' => 'Guardian Project (Cauldron SIGMA)', 'precio' => 12.00, 'imagen' => 'Guardian Project (Cauldron SIGMA).png'],
        ['id' => 10, 'nombre' => 'Inkwell Leviathan (Stalker)', 'precio' => 3.50, 'imagen' => 'Inkwell Leviathan (Stalker).png'],
        ['id' => 11, 'nombre' => 'Kappa Cannnoneer (Rockbreaker)', 'precio' => 30.00, 'imagen' => 'Kappa Cannoneer (Rockbreaker).png'],
        ['id' => 12, 'nombre' => "Kodama's Reach (Mark of the Seeker)", 'precio' => 25.00, 'imagen' => 'Kodama’s Reach (Mark of the Seeker).png'],
        ['id' => 13, 'nombre' => 'Master of Eterium (Sylens, Cherised Wanderer)', 'precio' => 2.20, 'imagen' => 'Master of Eterium (Sylens, Cherished Wanderer).png'],
        ['id' => 14, 'nombre' => 'Myr Galvanizer (Longleg)', 'precio' => 1.50, 'imagen' => 'Myr Galvanizer (Longleg).png'],
        ['id' => 15, 'nombre' => 'Phyrexian Metamorph (Specter)', 'precio' => 8.00, 'imagen' => 'Phyrexian Metamorph (Specter).png'],
        ['id' => 16, 'nombre' => 'Roaming Throne (Deathbringer)', 'precio' => 8.00, 'imagen' => 'Roaming Throne (Deathbringer).png'],
        ['id' => 17, 'nombre' => 'Silver Myr (Scrapper)', 'precio' => 8.00, 'imagen' => 'Silver Myr (Scrapper).png'],
        ['id' => 18, 'nombre' => 'Sol Ring (Focus)', 'precio' => 8.00, 'imagen' => 'Sol Ring (Focus).png'],
        ['id' => 19, 'nombre' => 'Steel Overseer (Redeye Watcher)', 'precio' => 8.00, 'imagen' => 'Steel Overseer (Redeye Watcher).png'],
        ['id' => 20, 'nombre' => 'Verdurous Gearhulk (Tremortusk)', 'precio' => 8.00, 'imagen' => 'Verdurous Gearhulk (Tremortusk).png'],
        ['id' => 21, 'nombre' => 'Webspinner Cuff (Corruptor)', 'precio' => 8.00, 'imagen' => 'Webspinner Cuff (Corruptor).png'],
        ['id' => 22, 'nombre' => 'Wurmcoil Engine (Slitherfang)', 'precio' => 8.00, 'imagen' => 'Wurmcoil Engine (Slitherfang).png']
    ];

    $resumenValoraciones = [];
    $votosUsuario = [];
    try {
        $pdo = obtenerConexion();
        $resumenValoraciones = obtenerResumenValoraciones($pdo);
        foreach ($cartas as $carta) {
            $votosUsuario[$carta['id']] = usuarioYaVoto($pdo, (int) $carta['id'], $usuario);
        }
    } catch (Throwable $e) {
        $resumenValoraciones = [];
        foreach ($cartas as $carta) {
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
        <h2><?php echo sprintf($t['cartas_disponibles'], count($cartas)); ?></h2>

        <div class="productos-grid bento-grid">
            <?php foreach ($cartas as $carta): ?>
                <article class="producto-card">
                    <img src="../img/<?php echo $carta['imagen']; ?>"
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
                            <button type="submit"><?php echo $t['anadir_deseados']; ?></button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
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