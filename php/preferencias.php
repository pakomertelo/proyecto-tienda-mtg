<?php
    session_start();

    $idioma = $_COOKIE['idioma'] ?? 'es';
    $tema = $_COOKIE['tema'] ?? 'claro';
    $tamano = $_COOKIE['tamano_fuente'] ?? 'normal';

    $textos = [
        'es' => [
            'titulo' => 'Preferencias',
            'volver' => 'Volver a la tienda',
            'login' => 'Login',
            'idioma' => 'Idioma:',
            'tema' => 'Tema:',
            'tema_claro' => 'Claro',
            'tema_oscuro' => 'Oscuro',
            'tamano' => 'Tamaño de fuente:',
            'tamano_pequena' => 'Pequeña',
            'tamano_normal' => 'Normal',
            'tamano_grande' => 'Grande',
            'guardar' => 'Guardar',
            'guardado' => 'Preferencias guardadas.'
        ],
        'en' => [
            'titulo' => 'Preferences',
            'volver' => 'Back to the store',
            'login' => 'Login',
            'idioma' => 'Language:',
            'tema' => 'Theme:',
            'tema_claro' => 'Light',
            'tema_oscuro' => 'Dark',
            'tamano' => 'Font size:',
            'tamano_pequena' => 'Small',
            'tamano_normal' => 'Normal',
            'tamano_grande' => 'Large',
            'guardar' => 'Save',
            'guardado' => 'Preferences saved.'
        ]
    ];

    $t = $textos[$idioma] ?? $textos['es'];

    $mensaje = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idioma = $_POST['idioma'] ?? 'es';
        $tema = $_POST['tema'] ?? 'claro';
        $tamano = $_POST['tamano_fuente'] ?? 'normal';

        $t = $textos[$idioma] ?? $textos['es'];

        setcookie('idioma', $idioma, time() + 60 * 60 * 24 * 30);
        setcookie('tema', $tema, time() + 60 * 60 * 24 * 30);
        setcookie('tamano_fuente', $tamano, time() + 60 * 60 * 24 * 30);

        $mensaje = $t['guardado'];
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
            <a href="login.php"><?php echo htmlspecialchars($t['login']); ?></a>
        </nav>

        <?php if (!empty($mensaje)) { echo '<p class="ok">' . $mensaje . '</p>'; } ?>

        <form method="post" class="formulario">
            <label for="idioma"><?php echo htmlspecialchars($t['idioma']); ?></label>
            <select name="idioma" id="idioma">
                <option value="es" <?php if ($idioma === 'es') echo 'selected'; ?>>Español</option>
                <option value="en" <?php if ($idioma === 'en') echo 'selected'; ?>>English</option>
            </select>

            <label for="tema"><?php echo htmlspecialchars($t['tema']); ?></label>
            <select name="tema" id="tema">
                <option value="claro" <?php if ($tema === 'claro') echo 'selected'; ?>><?php echo htmlspecialchars($t['tema_claro']); ?></option>
                <option value="oscuro" <?php if ($tema === 'oscuro') echo 'selected'; ?>><?php echo htmlspecialchars($t['tema_oscuro']); ?></option>
            </select>

            <label for="tamano_fuente"><?php echo htmlspecialchars($t['tamano']); ?></label>
            <select name="tamano_fuente" id="tamano_fuente">
                <option value="pequena" <?php if ($tamano === 'pequena') echo 'selected'; ?>><?php echo htmlspecialchars($t['tamano_pequena']); ?></option>
                <option value="normal" <?php if ($tamano === 'normal') echo 'selected'; ?>><?php echo htmlspecialchars($t['tamano_normal']); ?></option>
                <option value="grande" <?php if ($tamano === 'grande') echo 'selected'; ?>><?php echo htmlspecialchars($t['tamano_grande']); ?></option>
            </select>

            <button type="submit"><?php echo htmlspecialchars($t['guardar']); ?></button>
        </form>
    </div>
</body>
</html>
