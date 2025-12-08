<?php
session_start();
include 'php/conexionBD.php';
$mysqli = abrirConexion();

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Si llega un ID desde el catálogo, agregar al carrito
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Buscar producto en la BD
    $stmt = $mysqli->prepare("SELECT * FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $producto = $res->fetch_assoc();

        // Si ya existe en el carrito, aumentar cantidad
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
            // Crear item en el carrito
            $_SESSION['carrito'][$id] = [
                'id' => $producto['id_producto'],
                'nombre' => $producto['nombre_producto'],
                'precio' => $producto['precio'],
                'imagen' => $producto['imagen'],
                'cantidad' => 1
            ];
        }
    }
}

// Eliminar un producto del carrito
if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);
    unset($_SESSION['carrito'][$idEliminar]);
}

// Vaciar carrito
if (isset($_GET['vaciar'])) {
    $_SESSION['carrito'] = [];
}

cerrarConexion($mysqli);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛒 Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/carrito.css">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark shadow">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
            <img src="Imagenes/logo.jpg" alt="Logo" width="40" class="me-2">
            GameMasters
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="catalogo.php">Catálogo</a></li>
                <li class="nav-item"><a class="nav-link active" href="carrito.php">Carrito</a></li>
                <li class="nav-item"><a class="nav-link" href="noticias.php">Noticias</a></li>
                <li class="nav-item"><a class="nav-link" href="soporte.php">Soporte</a></li>
                <li class="nav-item"><a class="nav-link" href="sobrenosotros.php">Sobre Nosotros</a></li>

                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <?= htmlspecialchars($_SESSION['nombre']); ?>
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

    <h2 class="fw-bold mb-4">🛒 Tu Carrito</h2>

    <?php if (empty($_SESSION['carrito'])): ?>

        <div class="alert alert-info text-center">
            Tu carrito está vacío.  
            <a href="catalogo.php">Ir al catálogo</a>
        </div>

    <?php else: ?>

        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['carrito'] as $item):
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><img src="<?= $item['imagen'] ?>" width="70"></td>
                    <td><?= htmlspecialchars($item['nombre']) ?></td>
                    <td>₡<?= number_format($item['precio'], 2) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td>₡<?= number_format($subtotal, 2) ?></td>
                    <td>
                        <a href="carrito.php?eliminar=<?= $item['id'] ?>" 
                           class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <h3>Total: ₡<?= number_format($total, 2) ?></h3>

            <div>
                <a href="catalogo.php" class="btn btn-primary">Volver a comprar</a>

                <a href="#" class="btn btn-success">Finalizar Compra</a>
            </div>
        </div>

    <?php endif; ?>

</div>

<footer class="text-center py-3 bg-dark text-white">
    © 2025 GameMasters - Todos los derechos reservados 🎮
</footer>

</body>
</html>
