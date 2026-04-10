<?php
    session_start();
    require_once __DIR__ . '/db.php';

    $idioma = $_COOKIE['idioma'] ?? 'es';
    $tema = $_COOKIE['tema'] ?? 'oscuro';
    $tamano = $_COOKIE['tamano_fuente'] ?? 'normal';

    if (isset($_SESSION['username'])) {
        header('Location: index.php');
        exit;
    }

    $textos = [
        'es' => [
            'titulo' => 'Inicio de sesión - Tienda de Cartas Magic',
            'preferencias' => 'Preferencias',
            'usuario' => 'Usuario:',
            'contrasena' => 'Contraseña:',
            'entrar' => 'Entrar',
            'error' => 'Nombre de usuario o contraseña incorrectos.',
            'login' => 'Login',
            'usuarios' => 'Usuarios de prueba',
            'admin' => 'Admin → usuario: admin, contraseña: 1234',
            'cliente' => 'Cliente genérico → cualquier usuario y contraseña'
        ],
        'en' => [
            'titulo' => 'Login - Magic Cards Store',
            'preferencias' => 'Preferences',
            'usuario' => 'User:',
            'contrasena' => 'Password:',
            'entrar' => 'Sign in',
            'error' => 'Wrong user or password.',
            'login' => 'Login',
            'usuarios' => 'Test users',
            'admin' => 'Admin → user: admin, password: 1234',
            'cliente' => 'Generic customer → any user and password: 1234'
        ]
    ];

    $t = $textos[$idioma] ?? $textos['es'];

    $error = '';

    function asegurarUsuarioEnBD(string $usuario, string $rol): void
    {
        try {
            $pdo = obtenerConexion();
            $sql = 'INSERT INTO usuarios(usuario, password, rol) VALUES(:usuario, :password, :rol)
                    ON DUPLICATE KEY UPDATE rol = VALUES(rol)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':usuario' => $usuario,
                ':password' => '1234',
                ':rol' => $rol,
            ]);
        } catch (Throwable $e) {
            // Si la BD no está preparada todavía, no bloqueamos el login.
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($usuario === 'admin' && $password === '1234') {
            $_SESSION['username'] = 'admin';
            $_SESSION['rol'] = 'admin';
            asegurarUsuarioEnBD('admin', 'admin');
            header('Location: index.php');
            exit;
        } elseif (!empty($usuario) && !empty($password)) {
            $_SESSION['username'] = $usuario;
            $_SESSION['rol'] = 'cliente';
            asegurarUsuarioEnBD($usuario, 'cliente');
            header('Location: index.php');
            exit;
        } else {
            $error = $t['error'];
        }
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
        <p><a href="preferencias.php"><?php echo htmlspecialchars($t['preferencias']); ?></a></p>
        <hr>

        <?php
            if (!empty($error)) {
                echo '<p class="error">' . $error . '</p>';
            }
        ?>

        <form method="post" action="login.php" class="formulario">
            <label for="username"><?php echo htmlspecialchars($t['usuario']); ?></label>
            <input type="text" name="username" id="username">

            <label for="password"><?php echo htmlspecialchars($t['contrasena']); ?></label>
            <input type="password" name="password" id="password">

            <button type="submit"><?php echo htmlspecialchars($t['entrar']); ?></button>
        </form>

        <hr>
        <p><strong><?php echo htmlspecialchars($t['usuarios']); ?>:</strong></p>
        <ul>
            <li><?php echo htmlspecialchars($t['admin']); ?></li>
            <li><?php echo htmlspecialchars($t['cliente']); ?></li>
        </ul>
    </div>
</body>
</html>
