<?php
require_once __DIR__ . '/db.php';

function usuarioYaVoto(PDO $pdo, int $idProducto, string $usuario): bool
{
    $sql = 'SELECT id FROM votos WHERE idPr = :idPr AND idUs = :idUs LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':idPr' => $idProducto,
        ':idUs' => $usuario,
    ]);

    return (bool) $stmt->fetch();
}

function insertarVoto(PDO $pdo, int $idProducto, string $usuario, int $cantidad): bool
{
    $sql = 'INSERT INTO votos(cantidad, idPr, idUs) VALUES(:cantidad, :idPr, :idUs)';
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':cantidad' => $cantidad,
        ':idPr' => $idProducto,
        ':idUs' => $usuario,
    ]);
}

function obtenerResumenProducto(PDO $pdo, int $idProducto): array
{
    $sql = 'SELECT COUNT(*) AS total_votos, AVG(cantidad) AS media FROM votos WHERE idPr = :idPr';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':idPr' => $idProducto]);

    $fila = $stmt->fetch();

    return [
        'total_votos' => (int) ($fila['total_votos'] ?? 0),
        'media' => isset($fila['media']) ? (float) $fila['media'] : 0,
    ];
}

function obtenerResumenValoraciones(PDO $pdo): array
{
    $sql = 'SELECT idPr, COUNT(*) AS total_votos, AVG(cantidad) AS media FROM votos GROUP BY idPr';
    $stmt = $pdo->query($sql);

    $resumen = [];
    while ($fila = $stmt->fetch()) {
        $resumen[(int) $fila['idPr']] = [
            'total_votos' => (int) $fila['total_votos'],
            'media' => (float) $fila['media'],
        ];
    }

    return $resumen;
}

function estrellasHtml(float $media): string
{
    $entero = (int) floor($media);
    $decimal = $media - $entero;
    $mediaEstrella = $decimal >= 0.5 ? 1 : 0;
    $vacias = 5 - $entero - $mediaEstrella;

    $html = str_repeat('★', $entero);
    if ($mediaEstrella === 1) {
        $html .= '⯪';
    }
    $html .= str_repeat('☆', $vacias);

    return $html;
}

function textoValoracion(array $resumen): string
{
    $total = (int) ($resumen['total_votos'] ?? 0);
    $media = (float) ($resumen['media'] ?? 0);

    if ($total === 0) {
        return '☆☆☆☆☆ (0)';
    }

    return estrellasHtml($media) . ' (' . $total . ')';
}
