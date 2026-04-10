<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }

    $idioma = $_COOKIE['idioma'] ?? 'es';
    $tema = $_COOKIE['tema'] ?? 'claro';
    $tamano = $_COOKIE['tamano_fuente'] ?? 'normal';

    $textos = [
        'es' => [
            'titulo' => 'Lista de deseos',
            'volver' => 'Volver a la tienda',
            'preferencias' => 'Preferencias',
            'cerrar_sesion' => 'Cerrar sesión',
            'sin_productos' => 'No hay productos en la lista de deseos.',
            'nombre' => 'Nombre',
            'precio' => 'Precio (€)',
            'total' => 'Total de la lista:',
            'eliminar' => 'Eliminar lista de deseos'
        ],
        'en' => [
            'titulo' => 'Wishlist',
            'volver' => 'Back to the store',
            'preferencias' => 'Preferences',
            'cerrar_sesion' => 'Log out',
            'sin_productos' => 'There are no products in the wishlist.',
            'nombre' => 'Name',
            'precio' => 'Price (€)',
            'total' => 'Wishlist total:',
            'eliminar' => 'Delete wishlist'
        ]
    ];

    $t = $textos[$idioma] ?? $textos['es'];

    if (isset($_GET['accion']) && $_GET['accion'] === 'borrar') {
        setcookie('listaDeseos', '', time() - 3600);
        header('Location: listaDeseos.php');
        exit;
    }

    $lista = [];
    if (!empty($_COOKIE['listaDeseos'])) {
        $lista = json_decode($_COOKIE['listaDeseos'], true) ?? [];
    }

    $total = 0;
    foreach ($lista as $item) {
        $total += floatval($item['precio'] ?? 0);
    }
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($idioma); ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($t['titulo']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="<?php echo htmlspecialchars($tema); ?> <?php echo 'fuente-' . htmlspecialchars($tamano); ?>">
    <div class="contenedor">
        <h1><?php echo htmlspecialchars($t['titulo']); ?></h1>
        <nav class="menu">
            <a href="index.php"><?php echo htmlspecialchars($t['volver']); ?></a>
            <a href="preferencias.php"><?php echo htmlspecialchars($t['preferencias']); ?></a>
            <a href="logout.php"><?php echo htmlspecialchars($t['cerrar_sesion']); ?></a>
        </nav>

        <?php if (empty($lista)): ?>
            <p><?php echo htmlspecialchars($t['sin_productos']); ?></p>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="tabla-productos">
                    <thead>
                        <tr>
                            <th><?php echo htmlspecialchars($t['nombre']); ?></th>
                            <th><?php echo htmlspecialchars($t['precio']); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista as $producto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td><?php echo number_format($producto['precio'], 2, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p><strong><?php echo htmlspecialchars($t['total']); ?></strong> <?php echo number_format($total, 2, ',', '.'); ?> €</p>
            <a class="btn" href="listaDeseos.php?accion=borrar"><?php echo htmlspecialchars($t['eliminar']); ?></a>
        <?php endif; ?>
    </div>
</body>
</html>
