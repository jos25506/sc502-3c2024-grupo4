<?php 
session_start();
include 'php/conexionBD.php';
$mysqli = abrirConexion();

// Detectar si es admin
$esAdmin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');

// Filtrado por tipo y búsqueda
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

$where = [];
if ($tipo !== '') {
    $tipo = $mysqli->real_escape_string($tipo);
    $where[] = "tipo_producto='$tipo'";
}
if ($busqueda !== '') {
    $buscar = $mysqli->real_escape_string($busqueda);
    $where[] = "nombre_producto LIKE '%$buscar%'";
}

$query = "SELECT * FROM productos";
if (count($where) > 0) {
    $query .= " WHERE " . implode(' AND ', $where);
}

$res = $mysqli->query($query);
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🎮 GameMasters - Catálogo</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/stylos.css">
  <link rel="stylesheet" href="assets/css/catalogo.css">

  <!-- SWEETALERT2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

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
                <?php if ($esAdmin): ?>
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


<header class="text-center py-5 bg-primary text-white">
    <h1 class="display-5 fw-bold">🕹️ Catálogo de Videojuegos</h1>
    <p class="lead">Explora todos nuestros productos.</p>

    <!-- Botones de categorías -->
    <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
        <a href="catalogo.php?tipo=Consola" class="btn btn-outline-light <?= $tipo==='Consola'?'active':'' ?>">Consolas</a>
        <a href="catalogo.php?tipo=Accesorio" class="btn btn-outline-light <?= $tipo==='Accesorio'?'active':'' ?>">Accesorios</a>
        <a href="catalogo.php?tipo=Videojuego" class="btn btn-outline-light <?= $tipo==='Videojuego'?'active':'' ?>">Videojuegos</a>
        <a href="catalogo.php" class="btn btn-outline-light <?= $tipo===''?'active':'' ?>">Todos</a>
    </div>

    <!-- Barra de búsqueda -->
    <form class="mt-3 d-flex justify-content-center" method="GET">
        <input type="text" name="busqueda" class="form-control w-50 me-2" placeholder="Buscar..." value="<?= htmlspecialchars($busqueda) ?>">
        <?php if ($tipo !== ''): ?>
            <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo) ?>">
        <?php endif; ?>
        <button class="btn btn-light">Buscar</button>
    </form>

    <?php if ($esAdmin): ?>
      <a href="php/botones/agregar_producto.php" class="btn btn-warning mt-3">➕ Agregar Nuevo Producto</a>
    <?php endif; ?>
</header>

<!-- CATÁLOGO -->
<section class="container py-5">
    <div class="row g-4 justify-content-center">
        <?php if ($res->num_rows == 0): ?>
            <p class="text-center text-muted">No hay productos que coincidan con tu búsqueda.</p>
        <?php else: ?>
            <?php while ($p = $res->fetch_assoc()): ?>
            <div class="col-md-4 col-lg-3">
                <div class="card shadow h-100">
                    <img src="<?= htmlspecialchars($p['imagen']) ?>" class="card-img-top" style="height:250px; object-fit:cover;">
                    <div class="card-body">

                        <h5 class="card-title text-center"><?= htmlspecialchars($p['nombre_producto']) ?></h5>
                        <p class="small text-muted"><?= htmlspecialchars($p['descripcion']) ?></p>
                        <p class="fw-bold text-primary fs-5 text-center">₡<?= number_format($p['precio'],2) ?></p>
                        <p class="text-center"><b>Stock:</b> <?= $p['stock'] ?></p>

                        <div class="d-grid gap-2">

                        <?php if ($esAdmin): ?>
                            <a href="php/botones/editar_producto.php?id=<?= $p['id_producto'] ?>" class="btn btn-success">✏️ Editar</a>

                            <!-- SWEETALERT2 PARA ELIMINAR -->
                            <button class="btn btn-danger" onclick="confirmarEliminacion(<?= $p['id_producto'] ?>)">
                                🗑️ Eliminar
                            </button>

                        <?php elseif (isset($_SESSION['id_usuario'])): ?>

                            <!-- SWEETALERT2 AL AGREGAR AL CARRITO -->
                            <button class="btn btn-primary"
                                onclick="agregarCarritoReal(<?= $p['id_producto'] ?>, '<?= htmlspecialchars($p['nombre_producto']) ?>')">
                                🛒 Añadir al Carrito
                            </button>

                        <?php else: ?>
                            <a href="cuenta.php" class="btn btn-primary">🛒 Inicia sesión para comprar</a>
                        <?php endif; ?>

                        </div>

                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>

<!-- FOOTER -->
<footer class="text-center py-3 pastel-footer">
    <p class="mb-0">© 2025 GameMasters - Todos los derechos reservados 🎮</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/catalogo.js"></script>

<script>
// Confirmación SweetAlert2 para eliminar
function confirmarEliminacion(id) {
    Swal.fire({
        title: "¿Eliminar producto?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#d33"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "php/botones/eliminar_producto.php?id=" + id;
        }
    });
}

// Agregar al carrito con SweetAlert2 y redirección
function agregarCarritoReal(id, nombre) {
    Swal.fire({
        title: "Producto añadido",
        text: nombre + " se agregó al carrito.",
        icon: "success",
        timer: 1500,
        showConfirmButton: false
    });

    setTimeout(() => {
        window.location.href = "carrito.php?id=" + id;
    }, 1500);
}
</script>


</body>
</html>

<?php cerrarConexion($mysqli); ?>

