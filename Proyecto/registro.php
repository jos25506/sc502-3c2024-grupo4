<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎮 GameMasters - Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/cuenta.css">
</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <img src="Imagenes/logo.jpg" alt="Logo" width="40" class="me-2">
                GameMasters
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalogo.html">Catálogo</a></li>
                    <li class="nav-item"><a class="nav-link" href="carrito.html">Carrito</a></li>
                    <li class="nav-item"><a class="nav-link" href="cuenta.php">Cuenta</a></li>
                    <li class="nav-item"><a class="nav-link" href="noticias.html">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link" href="soporte.html">Soporte</a></li>
                    <li class="nav-item"><a class="nav-link" href="sobrenosotros.html">Sobre Nosotros</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- BANNER PRINCIPAL -->
    <header class="banner text-center text-white d-flex align-items-center justify-content-center">
        <div class="container">
            <h1 class="display-5 fw-bold">👤 Registro de usuario</h1>
            <p class="lead">Aquí puedes registrarte en el sistema.</p>
        </div>
    </header>

    <!-- SECCIÓN DE NUEVO USUARIO -->
    <section class="container py-5" id="registerFormContainer">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <h2 class="mb-4 text-center">Crear nueva cuenta</h2>

                    <!-- FORMULARIO REGISTRO -->
                    <form id="registerForm" action="javascript:void(0)">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" minlength="2" class="form-control" id="nombre" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" minlength="8" class="form-control" id="telefono" name="telefono" required>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>

                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" minlength="8" class="form-control" id="contrasena" name="contrasena" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirmarContrasena" class="form-label">Confirmar Contraseña</label>
                            <input type="password" minlength="8" class="form-control" id="confirmarContrasena" name="confirmarContrasena" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Registrarme</button>
                    </form>

                    <p class="text-center">¿Ya tienes una cuenta?
                        <a href="cuenta.php">Inicia sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-3 pastel-footer">
        <p class="mb-0">© 2025 GameMasters - Todos los derechos reservados 🎮</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- AHORA LA RUTA ES LA CORRECTA -->
    <script src="php/register/register.js"></script>

</body>

</html>

