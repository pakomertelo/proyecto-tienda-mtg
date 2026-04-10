<?php
function obtenerConexion(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = '127.0.0.1';
    $bd = 'tienda_mtg';
    $usuario = 'root';
    $password = '';

    $dsn = "mysql:host=$host;dbname=$bd;charset=utf8mb4";
    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, $usuario, $password, $opciones);
    return $pdo;
}
