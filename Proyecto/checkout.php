<?php
session_start();
include 'php/conexionBD.php';
$mysqli = abrirConexion();

// Verificar login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: cuenta.php");
    exit();
}

// Verificar carrito
if (empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit();
}

$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/checkout.css">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark shadow">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
            <img src="Imagenes/logo.jpg" alt="Logo" width="40" class="me-2">GameMasters
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
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

                <!-- SOLO ADMIN lo abre -->
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="historial_compras.php">Historial de compras</a></li>
                <?php endif; ?>

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

<div class="container mt-5">
    <h2 class="fw-bold mb-4">Finalizar Compra</h2>

    <div class="row">
        <!-- LISTA DE PRODUCTOS -->
        <div class="col-md-7">
            <div class="card shadow p-3">
                <h4 class="mb-3">🛒 Productos</h4>
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['carrito'] as $item): 
                            $subtotal = $item['precio'] * $item['cantidad'];
                        ?>
                        <tr>
                            <td><img src="<?= $item['imagen'] ?>" width="60"></td>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td><?= $item['cantidad'] ?></td>
                            <td>₡<?= number_format($subtotal, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h4 class="text-end me-2">
                    Total: <span class="fw-bold text-success">₡<?= number_format($total, 2) ?></span>
                </h4>
            </div>
        </div>

        <!-- FORMULARIO -->
        <div class="col-md-5">
            <div class="card shadow p-4">
                <h4 class="mb-3">Datos de Pago</h4>

                <form action="php/checkout/procesar-compra.php" method="POST">

                    <label class="form-label">Método de pago</label>
                    <select class="form-select mb-3" name="metodo_pago" required>
                        <option value="">Seleccione...</option>
                        <option value="sinpe">SINPE</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="efectivo">Efectivo</option>
                    </select>

                    <button class="btn btn-success w-100 mt-3">
                        ✔ Confirmar compra
                    </button>

                </form>

            </div>
        </div>
    </div>

</div>

<footer class="text-center py-3 bg-dark text-white">
    © 2025 GameMasters - Todos los derechos reservados 🎮
</footer>

</body>
</html>
