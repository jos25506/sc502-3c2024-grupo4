<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: cuenta.php");
    exit();
}

if (!isset($_GET['pedido'])) {
    echo "<h2>Error: No se recibió el número de pedido.</h2>";
    exit();
}

$idPedido = intval($_GET['pedido']);

include 'php/conexionBD.php';
$mysqli = abrirConexion();

// Traer datos del pedido
$sqlPedido = $mysqli->prepare("
    SELECT id_pedido, fecha_pedido, total, estado 
    FROM pedido 
    WHERE id_pedido = ? AND id_usuario = ?
");
$sqlPedido->bind_param("ii", $idPedido, $_SESSION['id_usuario']);
$sqlPedido->execute();
$resPedido = $sqlPedido->get_result();

if ($resPedido->num_rows === 0) {
    echo "<h2>No tienes permiso para ver este pedido.</h2>";
    exit();
}

$pedido = $resPedido->fetch_assoc();

// Traer productos del detalle
$sqlDetalle = $mysqli->prepare("
    SELECT d.cantidad, d.precio_unitario, p.nombre_producto, p.imagen
    FROM detalle_pedido d
    JOIN productos p ON p.id_producto = d.id_producto
    WHERE d.id_pedido = ?
");
$sqlDetalle->bind_param("i", $idPedido);
$sqlDetalle->execute();
$resDetalle = $sqlDetalle->get_result();

// Traer historial
$sqlHist = $mysqli->prepare("
    SELECT fecha_evento, descripcion_evento 
    FROM historial_pedidos 
    WHERE id_pedido = ?
    ORDER BY fecha_evento DESC
");
$sqlHist->bind_param("i", $idPedido);
$sqlHist->execute();
$resHist = $sqlHist->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<link rel="stylesheet" href="assets/css/checkout.css">
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

<div class="container my-5">

    <div class="card shadow p-4">
        <h2 class="fw-bold mb-3 text-success">¡Compra realizada con éxito! 🎉</h2>
        <p class="mb-1"><strong>Número de pedido:</strong> <?= $pedido['id_pedido'] ?></p>
        <p class="mb-1"><strong>Fecha:</strong> <?= $pedido['fecha_pedido'] ?></p>
        <p class="mb-3"><strong>Estado:</strong> <?= ucfirst($pedido['estado']) ?></p>

        <h4 class="mt-4 mb-3">Productos comprados</h4>

        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $resDetalle->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= $item['imagen'] ?>" width="70"></td>
                    <td><?= htmlspecialchars($item['nombre_producto']) ?></td>
                    <td>₡<?= number_format($item['precio_unitario'], 2) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td>₡<?= number_format($item['cantidad'] * $item['precio_unitario'], 2) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3 class="mt-4 text-end">
            Total pagado: <span class="text-success">₡<?= number_format($pedido['total'], 2) ?></span>
        </h3>

        <hr>

        <h4 class="mt-4 mb-3">Historial del Pedido</h4>
        <ul class="list-group">
            <?php while ($h = $resHist->fetch_assoc()): ?>
                <li class="list-group-item">
                    <strong><?= $h['fecha_evento'] ?>:</strong> 
                    <?= htmlspecialchars($h['descripcion_evento']) ?>
                </li>
            <?php endwhile; ?>
        </ul>

        <div class="text-end mt-4">
            <a href="catalogo.php" class="btn btn-success">Seguir comprando</a>
        </div>
    </div>

</div>

<footer class="text-center py-3 bg-dark text-white">
    © 2025 GameMasters - Todos los derechos reservados 🎮
</footer>

</body>
</html>
