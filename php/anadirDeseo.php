<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }

    $nombre = $_POST['nombre'] ?? '';
    $precio = floatval($_POST['precio'] ?? 0);

    if (!empty($nombre)) {
        $lista = [];
        if (!empty($_COOKIE['listaDeseos'])) {
            $lista = json_decode($_COOKIE['listaDeseos'], true) ?? [];
        }

        $lista[] = ['nombre' => $nombre, 'precio' => $precio];
        setcookie('listaDeseos', json_encode($lista), time() + 60 * 60 * 24 * 7);
    }

    header('Location: index.php');
    exit;
?>
