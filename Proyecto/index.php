<?php
session_start();
include 'php/conexionBD.php';
$mysqli = abrirConexion();

// Ofertas (3 productos aleatorios)
$ofertas = $mysqli->query("SELECT * FROM productos ORDER BY RAND() LIMIT 3");

// Recomendados (6 productos aleatorios)
$recomendados = $mysqli->query("SELECT * FROM productos ORDER BY RAND() LIMIT 6");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>🎮 GameMasters - Inicio</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/stylos.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark shadow">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
            <img src="Imagenes/logo.jpg" alt="Logo" width="40" class="me-2">GameMasters
        </a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="catalogo.php">Catálogo</a></li>
                <li class="nav-item"><a class="nav-link" href="carrito.php">Carrito</a></li>
                <li class="nav-item"><a class="nav-link" href="noticias.php">Noticias</a></li>
                <li class="nav-item"><a class="nav-link" href="soporte.php">Soporte</a></li>
                <li class="nav-item"><a class="nav-link" href="sobrenosotros.php">Sobre Nosotros</a></li>

                <?php if (isset($_SESSION['id_usuario'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <?= htmlspecialchars($_SESSION['nombre']) ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="perfil.php">Mi Perfil</a></li>
                        <li><a class="dropdown-item" href="php/login/logout.php">Cerrar sesión</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="cuenta.php">Cuenta</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- BANNER -->
<header class="banner text-white text-center d-flex align-items-center justify-content-center">
    <div class="container">
        <h1 class="display-4 fw-bold">⚡ Semana Gamer - Ofertas Especiales</h1>
        <p class="lead mt-2">
            <?= isset($_SESSION['nombre']) ? "Bienvenido, " . htmlspecialchars($_SESSION['nombre']) : "Consolas, accesorios y videojuegos con descuento." ?>
        </p>
    </div>
</header>
<!-- CATEGORÍAS -->
<section class="container my-5">
    <h2 class="fw-bold text-center mb-4">Categorías destacadas</h2>
    <section class="container text-center my-5">
    <h2 class="fw-bold text-center mb-4">Explora por género</h2>

    <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="catalogo.php?tipo=Consola" class="genero-btn">🎮 Consolas</a>
        <a href="catalogo.php?tipo=Accesorio" class="genero-btn">🕹️ Accesorios</a>
        <a href="catalogo.php?tipo=Videojuego" class="genero-btn">📀 Videojuegos</a>
    </div>
</section>

</section>

<!-- OFERTAS -->
<section class="container py-5">
    <h2 class="fw-bold text-center mb-4">🔥 Ofertas destacadas</h2>
    <div class="row g-4">
        <?php while($row = $ofertas->fetch_assoc()): ?>
            <?php $descuento = $row['precio'] * 0.25; ?>
            <?php $precioOferta = $row['precio'] - $descuento; ?>
            <div class="col-md-4">
                <div class="card oferta-card shadow text-center position-relative">
                    <span class="oferta-badge">-25% OFF</span>
                    <img src="<?= $row['imagen'] ?>" class="card-img-top" alt="<?= $row['nombre_producto'] ?>">
                    <div class="card-body">
                        <h5 class="fw-bold"><?= $row['nombre_producto'] ?></h5>
                        <p class="mb-1 text-muted text-decoration-line-through">₡<?= number_format($row['precio'],2) ?></p>
                        <p class="text-success fs-4 fw-bold">₡<?= number_format($precioOferta,2) ?></p>

                        <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente'): ?>
                            <button class="btn btn-primary agregar-carrito" data-id="<?= $row['id_producto'] ?>" data-nombre="<?= htmlspecialchars($row['nombre_producto']) ?>" data-precio="<?= $precioOferta ?>" data-imagen="<?= $row['imagen'] ?>">🛒 Agregar al carrito</button>
                        <?php elseif(!isset($_SESSION['id_usuario'])): ?>
                            <a href="cuenta.php" class="btn btn-primary">🛒 Inicia sesión para comprar</a>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                            <div class="d-flex justify-content-center gap-2 mt-2">
                                <a href="php/botones/editar_producto.php?id=<?= $row['id_producto'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="php/botones/eliminar_producto.php?id=<?= $row['id_producto'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- RECOMENDADOS -->
<section class="container py-5">
    <h2 class="fw-bold text-center mb-4">⭐ Recomendados para ti</h2>
    <div class="row g-4">
        <?php while($p = $recomendados->fetch_assoc()): ?>
<div class="col-md-4 col-lg-2">
    <div class="card shadow-sm text-center oferta-card">
        <img src="<?= $p['imagen'] ?>" class="card-img-top" alt="<?= $p['nombre_producto'] ?>">
        <div class="card-body">
            <h6 class="fw-bold"><?= $p['nombre_producto'] ?></h6>
            <p class="fw-bold text-success">₡<?= number_format($p['precio']) ?></p>

            <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente'): ?>
                <a href="carrito.php?id=<?= $p['id_producto'] ?>&agregado=1" class="btn btn-sm btn-primary">Agregar</a>
            <?php elseif(!isset($_SESSION['id_usuario'])): ?>
                <a href="cuenta.php" class="btn btn-primary">🛒 Inicia sesión para comprar</a>
            <?php endif; ?>

            <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
            <div class="d-flex justify-content-center gap-2 mt-2">
                <a href="php/botones/editar_producto.php?id=<?= $p['id_producto'] ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="php/botones/eliminar_producto.php?id=<?= $p['id_producto'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endwhile; ?>

    </div>
</section>

<footer class="text-center py-3 pastel-footer">
    © <?= date("Y") ?> GameMasters - Todos los derechos reservados 🎮
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/Inicio.js"></script>
<?php cerrarConexion($mysqli); ?>
</body>
</html>

