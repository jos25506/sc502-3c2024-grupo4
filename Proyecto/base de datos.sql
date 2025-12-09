-- =======================================================
-- BASE DE DATOS GAMEMASTERS
-- =======================================================
CREATE DATABASE gamemasters;

USE gamemasters;

-- =======================================================
-- TABLA: USUARIOS
-- =======================================================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    rol ENUM('cliente','admin') DEFAULT 'cliente'
);
INSERT INTO usuarios (nombre, correo, contrasena, rol)
VALUES ('Administrador', 'admin@gamemasters.com', '1234', 'admin');

INSERT INTO usuarios (nombre, correo, contrasena, rol)
VALUES ('Cliente Ejemplo', 'cliente@gmail.com', '1234', 'cliente');

-- =======================================================
-- TABLA: CATEGORIA
-- =======================================================
CREATE TABLE categoria (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(100) NOT NULL
);
INSERT INTO categoria (nombre_categoria)
VALUES
('Acción'),
('Aventura'),
('Deportes'),
('Carreras'),
('Lucha'),
('Shooter'),
('Mundo Abierto');


-- =======================================================
-- TABLA: PRODUCTOS
-- =======================================================
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    categoria_id INT,
    imagen VARCHAR(255), -- URL o ruta de la imagen
    tipo_producto ENUM('Consola', 'Accesorio', 'Videojuego') NOT NULL DEFAULT 'Videojuego',

    FOREIGN KEY (categoria_id) REFERENCES categoria(id_categoria)
        ON UPDATE CASCADE 
        ON DELETE SET NULL
);


-- Juegos (Videojuegos)
INSERT INTO productos (nombre_producto, descripcion, precio, stock, categoria_id, imagen, tipo_producto)
VALUES
('FIFA 2025', 'Juego de fútbol para PS5 y Xbox', 25000, 10, 3, 'https://www.fifa-fc.com/wp-content/uploads/2024/09/EA-SPORTS-FC-25-Standard-Edition-PS5-Jeu-Video.jpg', 'Videojuego'),
('GTA VI', 'Juego de mundo abierto, PS5 / Xbox Series', 40000, 8, 7, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9wRd0aYD_BFCxeanJiSTbpP_KJevEGbPOSQ&s', 'Videojuego'),
('Mortal Kombat 12', 'Juego de peleas para PS5', 30000, 5, 5, 'https://i0.wp.com/www.pcmrace.com/wp-content/uploads/2023/02/mortal-kombat-12-pc-juego-cover.jpg', 'Videojuego'),
('Call of Duty Modern Warfare 3', 'Juego shooter primera persona', 35000, 6, 6, 'https://www.callofduty.com/content/dam/atvi/callofduty/cod-touchui/store/games/mw3/overview/Store_GamesPDP_Hero01.png', 'Videojuego');

-- Consolas
INSERT INTO productos (nombre_producto, descripcion, precio, stock, categoria_id, imagen, tipo_producto)
VALUES
('PlayStation 5', 'Consola de última generación Sony', 450000, 5, NULL, 'https://www.sony.com/image/ps5.jpg', 'Consola'),
('Xbox Series X', 'Consola de última generación Microsoft', 430000, 4, NULL, 'https://images-cdn.ubuy.co.in/664e1cfddecc0a08e224a6f2-microsoft-xbox-series-x-gaming-console.jpg', 'Consola');

-- Accesorios
INSERT INTO productos (nombre_producto, descripcion, precio, stock, categoria_id, imagen, tipo_producto)
VALUES
('Control DualSense PS5', 'Control inalámbrico para PS5', 50000, 15, NULL, 'https://www.techzilla.cr/wp-content/uploads/2024/04/Sin-titulo-2-126.jpg', 'Accesorio'),
('Auriculares Xbox', 'Auriculares con micrófono para Xbox', 30000, 12, NULL, 'https://m.media-amazon.com/images/I/61pumpz+46L._SL1500_.jpg', 'Accesorio');




-- =======================================================
-- TABLA: PEDIDO
-- =======================================================
CREATE TABLE pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente','pagado','enviado','cancelado') DEFAULT 'pendiente',
    
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE ON DELETE CASCADE
);
INSERT INTO pedido (id_usuario, total, estado)
VALUES
(2, 25000, 'pagado'),
(2, 65000, 'pendiente');

-- =======================================================
-- TABLA: DETALLE PEDIDO
-- =======================================================
CREATE TABLE detalle_pedido (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido)
        ON UPDATE CASCADE ON DELETE CASCADE,
        
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
        ON UPDATE CASCADE ON DELETE CASCADE
);
INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario)
VALUES
(1, 5, 1, 25000),   
(2, 6, 1, 40000),   
(2, 8, 1, 35000);   

-- =======================================================
-- TABLA: PAGO
-- =======================================================
CREATE TABLE pago (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    metodo_pago ENUM('tarjeta','sinpe','paypal','efectivo') NOT NULL,
    fecha_pago DATETIME DEFAULT CURRENT_TIMESTAMP,
    monto DECIMAL(10,2) NOT NULL,
    estado_pago ENUM('pendiente','completado','fallido') DEFAULT 'pendiente',
    
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido)
        ON UPDATE CASCADE ON DELETE CASCADE
);
INSERT INTO pago (id_pedido, metodo_pago, monto, estado_pago)
VALUES
(1, 'sinpe', 25000, 'completado'),
(2, 'tarjeta', 65000, 'pendiente');

-- =======================================================
-- TABLA: HISTORIAL PEDIDOS
-- =======================================================
CREATE TABLE historial_pedidos (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    fecha_evento DATETIME DEFAULT CURRENT_TIMESTAMP,
    descripcion_evento VARCHAR(255),
    
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido)
        ON UPDATE CASCADE ON DELETE CASCADE
);
INSERT INTO historial_pedidos (id_pedido, descripcion_evento)
VALUES
(1, 'Pedido pagado y procesado'),
(2, 'Pedido recibido, en espera de pago');