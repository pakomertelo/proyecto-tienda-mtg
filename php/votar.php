<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode([
        'ok' => false,
        'mensaje' => 'Debes iniciar sesión para votar.'
    ]);
    exit;
}

require_once __DIR__ . '/valoraciones.php';

$idProducto = (int) ($_POST['idPr'] ?? 0);
$cantidad = (int) ($_POST['cantidad'] ?? 0);
$usuario = $_SESSION['username'];

if ($idProducto <= 0 || $cantidad < 1 || $cantidad > 5) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'mensaje' => 'Datos de voto no válidos.'
    ]);
    exit;
}

try {
    $pdo = obtenerConexion();

    if (usuarioYaVoto($pdo, $idProducto, $usuario)) {
        echo json_encode([
            'ok' => false,
            'yaVoto' => true,
            'mensaje' => 'Ya habías votado este producto.'
        ]);
        exit;
    }

    insertarVoto($pdo, $idProducto, $usuario, $cantidad);
    $resumen = obtenerResumenProducto($pdo, $idProducto);

    echo json_encode([
        'ok' => true,
        'mensaje' => 'Voto guardado correctamente.',
        'total_votos' => $resumen['total_votos'],
        'media' => round((float) $resumen['media'], 1),
        'estrellas' => estrellasHtml((float) $resumen['media']),
        'texto' => textoValoracion($resumen)
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'mensaje' => 'Error al guardar el voto.'
    ]);
}
