<?php
session_start();

// Si no está logueado → redirigir
if (!isset($_SESSION['id_usuario'])) {
    header("Location: cuenta.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$correo = $_SESSION['correo'];
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta - GameMasters</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="assets/css/perfil.css">
    
</head>

<body>
<?php include 'php/componentes/navbar.php'?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="perfil-card">

                <div class="perfil-header">
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Avatar">
                    <h2 class="mt-3"><?php echo htmlspecialchars($nombre); ?></h2>
                    <span class="badge bg-primary">
                        <?php echo htmlspecialchars(ucfirst($rol)); ?>
                    </span>
                </div>

                <hr>

                <h5 class="mb-3">Información de la cuenta</h5>

                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
                <p><strong>Correo:</strong> <?php echo htmlspecialchars($correo); ?></p>
                <p><strong>Rol:</strong> <?php echo htmlspecialchars($rol); ?></p>

                <hr>

                <div class="d-grid gap-2 mt-4">
                    <a href="index.php" class="btn btn-outline-primary">Volver al inicio</a>
                    <a href="php/logout.php" class="btn btn-danger">Cerrar sesión</a>
                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>
