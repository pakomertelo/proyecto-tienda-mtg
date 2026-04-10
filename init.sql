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
(1, 'Aloy, Savior of Meridian', 18.59, 'Aloy, Savior of Meridian.jpg'),
(2, 'Ancient Stone Idol (Clawstrider Rider)', 13.49, 'Ancient Stone Idol (Clawstrider Rider).png'),
(3, 'Arcane Signet (Metal Flower)', 6.28, 'Arcane Signet (Metal Flower).png'),
(4, 'Basking Broodscale (Burrower)', 3.91, 'Basking Broodscale (Burrower).png'),
(5, 'Cityscape Leveler (Scorcher)', 20.62, 'Cityscape Leveler (Scorcher).png'),
(6, 'Cloud Key (Metal Shards)', 8.45, 'Cloud Key (Metal Shards).png'),
(7, 'Command Tower (The Spire)', 9.82, 'Command Tower (The Spire).png'),
(8, 'Cooper Myr (Grazer)', 9.02, 'Cooper Myr (Grazer).png'),
(9, 'Cultivate', 3.83, 'Cultivate.png'),
(10, 'Cyberdrive Awakener (Dreadwing)', 6.37, 'Cyberdrive Awakener (Dreadwing).png'),
(11, 'Cyberdrive Awakener (Stormbird)', 3.16, 'Cyberdrive Awakener (Stormbird).png'),
(12, 'Cyberman Patrol (Sawtooth)', 5.11, 'Cyberman Patrol (Sawtooth).png'),
(13, 'Cybermen Squadron (Behemoth Convoy)', 1.73, 'Cybermen Squadron (Behemoth Convoy).png'),
(14, 'Darksteel Juggernaut (Shellsnaper)', 9.07, 'Darksteel Juggernaut (Shellsnaper).jpg'),
(15, 'Diamond Weapon (Tallneck)', 8.78, 'Diamond Weapon (Tallneck).png'),
(16, 'Dreamroot Cascade', 7.11, 'Dreamroot Cascade.png'),
(17, 'Emissary Escort (Frostclaw)', 5.96, 'Emissary Escort (Frostclaw).png'),
(18, 'Emry, Lurker of the Loch (Beta, Second Echo of Sobeck)', 15.19, 'Emry, Lurker of the Loch (Beta, Second Echo of Sobeck).png'),
(19, 'Flooded Grove', 4.97, 'Flooded Grove.png'),
(20, 'Foundry Inspector (Clawstrider)', 5.25, 'Foundry Inspector (Clawstrider).png'),
(21, 'Garruk’s Uprising (Faro Plague)', 5.48, 'Garruk’s Uprising (Faro Plague).png'),
(22, 'Guardian Project (Cauldron SIGMA)', 10.12, 'Guardian Project (Cauldron SIGMA).png'),
(23, 'Hedge Maze', 9.74, 'Hedge Maze.png'),
(24, 'Hinterland Harbor', 11.22, 'Hinterland Harbor.png'),
(25, 'Inkwell Leviathan (Stalker)', 10.60, 'Inkwell Leviathan (Stalker).png'),
(26, 'Kappa Cannoneer (Rockbreaker)', 19.45, 'Kappa Cannoneer (Rockbreaker).png'),
(27, 'Kodama’s Reach (Mark of the Seeker)', 6.58, 'Kodama’s Reach (Mark of the Seeker).png'),
(28, 'Liquimetal Torque (Corruption Arrow)', 7.65, 'Liquimetal Torque (Corruption Arrow).png'),
(29, 'Maestrom Colossus (Slaughterspine)', 7.56, 'Maestrom Colossus (Slaughterspine).png'),
(30, 'Master of Eterium (Sylens, Cherished Wanderer)', 6.49, 'Master of Eterium (Sylens, Cherished Wanderer).png'),
(31, 'Memnarch (Corruptor)', 9.65, 'Memnarch (Corruptor).png'),
(32, 'Mistrise Village', 9.09, 'Mistrise Village.png'),
(33, 'Myr Galvanizer (Longleg)', 9.48, 'Myr Galvanizer (Longleg).png'),
(34, 'Nature´s Lore (Forbidden West Map)', 3.41, 'Nature´s Lore (Forbidden West Map).png'),
(35, 'Ornithopter of Paradise (Stingspawn)', 4.60, 'Ornithopter of Paradise (Stingspawn).png'),
(36, 'Overflowing Basin', 9.29, 'Overflowing Basin.png'),
(37, 'Padeem, Consul of Innovation_ (Erend Vanguardsman)', 2.03, 'Padeem, Consul of Innovation_ (Erend Vanguardsman).png'),
(38, 'Palladium Myr (Charger)', 4.63, 'Palladium Myr (Charger).png'),
(39, 'Phyrexian Metamorph (Specter)', 15.53, 'Phyrexian Metamorph (Specter).png'),
(40, 'Rampant Growth (Spurflints Hunting Grounds)', 3.08, 'Rampant Growth (Spurflints Hunting Grounds).png'),
(41, 'Roaming Throne (Deathbringer)', 23.01, 'Roaming Throne (Deathbringer).png'),
(42, 'Scour for Scrap', 8.08, 'Scour for Scrap.png'),
(43, 'Silver Myr (Scrapper)', 6.97, 'Silver Myr (Scrapper).png'),
(44, 'Simic Growth Chamber', 7.12, 'Simic Growth Chamber.png'),
(45, 'Simic Signet (Thenderjaw Heart)', 8.44, 'Simic Signet (Thenderjaw Heart).png'),
(46, 'Sol Ring (Focus)', 20.92, 'Sol Ring (Focus).png'),
(47, 'Solemn Simulacrum (Strider)', 3.98, 'Solemn Simulacrum (Strider).png'),
(48, 'Steel Overseer (Redeye Watcher)', 2.25, 'Steel Overseer (Redeye Watcher).png'),
(49, 'Steelswarm Operator (Glinthawk)', 8.25, 'Steelswarm Operator (Glinthawk).jpeg'),
(50, 'Talisman of Curiosity (Stormbird Heart)', 8.03, 'Talisman of Curiosity (Stormbird Heart).png'),
(51, 'Temple of Mystery', 10.66, 'Temple of Mystery.png'),
(52, 'Thought Monitor (Sunwing)', 3.51, 'Thought Monitor (Sunwing).png'),
(53, 'Thought Vessel (Power Cell)', 3.46, 'Thought Vessel (Power Cell).png'),
(54, 'Traxos, Scourge of Kroog (Control Tower)', 8.52, 'Traxos, Scourge of Kroog (Control Tower).png'),
(55, 'Unnatural Growth', 3.55, 'Unnatural Growth.png'),
(56, 'Verdurous Gearhulk (Tremortusk)', 14.74, 'Verdurous Gearhulk (Tremortusk).png'),
(57, 'Vineglimmer Snarl', 5.31, 'Vineglimmer Snarl.png'),
(58, 'Webspinner Cuff (Aloy’s Machine Override)', 24.97, 'Webspinner Cuff (Aloy’s Machine Override).png'),
(59, 'Webspinner Cuff (Corruptor)', 1.56, 'Webspinner Cuff (Corruptor).png'),
(60, 'Willowrush Verge', 5.04, 'Willowrush Verge.png'),
(61, 'Wurmcoil Engine (Slitherfang)', 22.30, 'Wurmcoil Engine (Slitherfang).png'),
(62, 'Yamivaya Coast', 6.24, 'Yamivaya Coast.png')
ON DUPLICATE KEY UPDATE
nombre = VALUES(nombre),
precio = VALUES(precio),
imagen = VALUES(imagen);
