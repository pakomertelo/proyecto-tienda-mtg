CREATE DATABASE IF NOT EXISTS tienda_mtg CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tienda_mtg;

DROP TABLE IF EXISTS votos;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    usuario VARCHAR(20) PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    rol VARCHAR(20) NOT NULL DEFAULT 'cliente'
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(150) NOT NULL
);

CREATE TABLE votos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cantidad INT DEFAULT 0,
    idPr INT NOT NULL,
    idUs VARCHAR(20) NOT NULL,
    CONSTRAINT fk_votos_usu FOREIGN KEY(idUs) REFERENCES usuarios(usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_votos_pro FOREIGN KEY(idPr) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT chk_voto_rango CHECK (cantidad BETWEEN 1 AND 5),
    CONSTRAINT uq_voto_unico UNIQUE (idPr, idUs)
);

INSERT INTO usuarios(usuario, password, rol) VALUES
('admin', '1234', 'admin')
ON DUPLICATE KEY UPDATE rol = VALUES(rol);

INSERT INTO productos (id, nombre, precio, imagen) VALUES
(1, 'Aloy, Savior of Meridian', 29.50, 'Aloy, Savior of Meridian.jpg'),
(2, 'Cooper Myr (Grazer)', 3.00, 'Cooper Myr (Grazer).png'),
(3, 'Cultivate', 1.20, 'Cultivate.png'),
(4, 'Cyberdrive Awakener (Dreadwing)', 2.80, 'Cyberdrive Awakener (Dreadwing).png'),
(5, 'Cyberman Patrol (Sawtooth)', 4.50, 'Cyberman Patrol (Sawtooth).png'),
(6, 'Darksteel Juggernaut (Shellsnaper)', 0.80, 'Darksteel Juggernaut (Shellsnaper).jpg'),
(7, 'Diamond Weapon (Tallneck)', 2.00, 'Diamond Weapon (Tallneck).png'),
(8, 'Garruk''s Uprising (Faro Plague)', 5.00, 'Garruk’s Uprising (Faro Plague).png'),
(9, 'Guardian Project (Cauldron SIGMA)', 12.00, 'Guardian Project (Cauldron SIGMA).png'),
(10, 'Inkwell Leviathan (Stalker)', 3.50, 'Inkwell Leviathan (Stalker).png'),
(11, 'Kappa Cannnoneer (Rockbreaker)', 30.00, 'Kappa Cannoneer (Rockbreaker).png'),
(12, 'Kodama''s Reach (Mark of the Seeker)', 25.00, 'Kodama’s Reach (Mark of the Seeker).png'),
(13, 'Master of Eterium (Sylens, Cherised Wanderer)', 2.20, 'Master of Eterium (Sylens, Cherished Wanderer).png'),
(14, 'Myr Galvanizer (Longleg)', 1.50, 'Myr Galvanizer (Longleg).png'),
(15, 'Phyrexian Metamorph (Specter)', 8.00, 'Phyrexian Metamorph (Specter).png'),
(16, 'Roaming Throne (Deathbringer)', 8.00, 'Roaming Throne (Deathbringer).png'),
(17, 'Silver Myr (Scrapper)', 8.00, 'Silver Myr (Scrapper).png'),
(18, 'Sol Ring (Focus)', 8.00, 'Sol Ring (Focus).png'),
(19, 'Steel Overseer (Redeye Watcher)', 8.00, 'Steel Overseer (Redeye Watcher).png'),
(20, 'Verdurous Gearhulk (Tremortusk)', 8.00, 'Verdurous Gearhulk (Tremortusk).png'),
(21, 'Webspinner Cuff (Corruptor)', 8.00, 'Webspinner Cuff (Corruptor).png'),
(22, 'Wurmcoil Engine (Slitherfang)', 8.00, 'Wurmcoil Engine (Slitherfang).png')
ON DUPLICATE KEY UPDATE
nombre = VALUES(nombre),
precio = VALUES(precio),
imagen = VALUES(imagen);
