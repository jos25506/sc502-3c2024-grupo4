<?php
session_start();
include 'php/conexionBD.php';
$mysqli = abrirConexion();

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto desde index.php o catálogo
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $mysqli->prepare("SELECT * FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $producto = $res->fetch_assoc();
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
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

// Editar cantidad desde formulario
if (isset($_POST['editar'])) {
    $id = intval($_POST['id']);
    $cantidad = intval($_POST['cantidad']);
    if ($cantidad > 0 && isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] = $cantidad;
    }
}

// Eliminar un producto
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
                    <td>
                        <form method="POST" class="d-flex justify-content-center align-items-center gap-2">
                            <input type="number" name="cantidad" value="<?= $item['cantidad'] ?>" min="1" class="form-control form-control-sm" style="width:70px">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" name="editar" class="btn btn-primary btn-sm editar-cantidad">Actualizar</button>
                        </form>
                    </td>
                    <td>₡<?= number_format($subtotal, 2) ?></td>
                    <td>
                        <a href="carrito.php?eliminar=<?= $item['id'] ?>" class="btn btn-danger btn-sm eliminar-item">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <h3>Total: ₡<?= number_format($total, 2) ?></h3>
            <div>
                <a href="catalogo.php" class="btn btn-primary">Volver a comprar</a>
                <a href="checkout.php" class="btn btn-success finalizar-compra">Finalizar Compra</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<footer class="text-center py-3 bg-dark text-white">
    © 2025 GameMasters - Todos los derechos reservados 🎮
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/carrito.js"></script>
</body>
</html>


