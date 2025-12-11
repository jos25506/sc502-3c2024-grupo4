<?php
session_start();
require_once 'php/conexionBD.php';
$mysqli = abrirConexion();

// Solo admin puede acceder
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Cambiar estado de pedido
if (isset($_POST['cambiar_estado'])) {

    $id_pedido = intval($_POST['id_pedido']);
    $nuevo_estado = $_POST['estado'];

    // Actualizar estado del pedido
    $stmt = $mysqli->prepare("UPDATE pedido SET estado = ? WHERE id_pedido = ?");
    $stmt->bind_param("si", $nuevo_estado, $id_pedido);
    $stmt->execute();
    $stmt->close();

    // Registrar el historial
    $descripcion = "Estado cambiado a '$nuevo_estado'";
    $stmtHist = $mysqli->prepare("INSERT INTO historial_pedidos (id_pedido, descripcion_evento) VALUES (?, ?)");
    $stmtHist->bind_param("is", $id_pedido, $descripcion);
    $stmtHist->execute();
    $stmtHist->close();

    header("Location: historial_compras.php");
    exit();
}

// Obtener todos los pedidos
$pedidos = $mysqli->query("
    SELECT p.*, u.nombre AS cliente 
    FROM pedido p 
    JOIN usuarios u ON p.id_usuario = u.id_usuario
    ORDER BY p.fecha_pedido DESC
");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Historial de Pedidos - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/historial.css">
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
    <h2 class="fw-bold mb-4 text-center">📦 Historial de Pedidos</h2>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID Pedido</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Actualizar</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = $pedidos->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_pedido'] ?></td>
                <td><?= htmlspecialchars($row['cliente']) ?></td>
                <td><?= $row['fecha_pedido'] ?></td>
                <td>₡<?= number_format($row['total'], 2) ?></td>

                <td>
                    <?= ucfirst($row['estado']) ?>
                </td>

                <td>
                    <form method="POST" class="d-flex justify-content-center gap-2">
                        <input type="hidden" name="id_pedido" value="<?= $row['id_pedido'] ?>">

                        <select name="estado" class="form-select form-select-sm">
                            <option value="pendiente"  <?= $row['estado']=='pendiente'?'selected':'' ?>>Pendiente</option>
                            <option value="pagado"     <?= $row['estado']=='pagado'?'selected':'' ?>>Pagado</option>
                            <option value="enviado"    <?= $row['estado']=='enviado'?'selected':'' ?>>Enviado</option>
                            <option value="cancelado"  <?= $row['estado']=='cancelado'?'selected':'' ?>>Cancelado</option>
                        </select>

                        <button type="submit" name="cambiar_estado" class="btn btn-primary btn-sm">
                            Actualizar
                        </button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/historial.js"></script>
</body>
</html>

<?php cerrarConexion($mysqli); ?>



