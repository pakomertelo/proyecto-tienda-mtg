# Tienda MTG (2º DAW)

Proyecto sencillo de tienda online de cartas de Magic con:
- login básico,
- carrito con `localStorage`,
- lista de deseos,
- sistema de valoración por estrellas (1 a 5) con `fetch`.

## 1) Preparar base de datos

Importa `init.sql` en MySQL/MariaDB:

```bash
mysql -u root -p < init.sql
```

Esto crea:
- `usuarios`
- `productos`
- `votos`

y añade productos de ejemplo + usuario `admin`.

## 2) Configurar conexión

Archivo: `php/db.php`

Por defecto usa:
- host: `127.0.0.1`
- db: `tienda_mtg`
- user: `root`
- pass: vacía

También puedes usar variables de entorno:
- `DB_HOST`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`

## 3) Ejecutar

Coloca la carpeta en tu servidor local (XAMPP/Laragon/WAMP) y abre:

- `php/login.php`

Usuarios:
- `admin / 1234`
- cualquier usuario + contraseña (se guarda automáticamente en tabla `usuarios` al iniciar sesión)

## 4) Valoraciones

- Solo usuarios logueados pueden votar.
- Un usuario no puede votar dos veces el mismo producto.
- Se muestra `Sin valorar` si no hay votos.
- Si hay votos: total + media con estrellas.
- La media usa media estrella cuando decimal `>= 0.5`.
- El voto se envía con `fetch` a `php/votar.php` sin recargar la página.

## 5) Diseño

- Productos en cuadrícula tipo tienda.
- Carrito lateral desplegable desde la derecha.
- Estilo visual sencillo y defendible para nivel DAW.
