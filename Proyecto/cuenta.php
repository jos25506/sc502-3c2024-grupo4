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

    <!-- BANNER PRINCIPAL -->
    <header class="banner text-center text-white d-flex align-items-center justify-content-center">
        <div class="container">
            <h1 class="display-5 fw-bold">👤 Cuenta de usuario</h1>
            <p class="lead">Aquí puedes iniciar sesión para acceder a tus compras.</p>
        </div>
    </header>

    <!-- SECCIÓN DE INICIO DE SESIÓN -->
    <section class="container py-5" id="loginFormContainer">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <h2 class="mb-4 text-center">Iniciar Sesión</h2>

                    <!-- FORMULARIO LOGIN -->
                    <form id="loginForm" action="javascript:void(0)">

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>

                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                    </form>

                    <p class="text-center">¿No tienes una cuenta?
                        <a href="#" onclick="cambiarFormulario()">Regístrate</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECCIÓN DE REGISTRO -->
    <section class="container py-5 d-none" id="registerFormContainer">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <h2 class="mb-4 text-center">¿No tienes una cuenta? Regístrate</h2>

                    <form id="registerForm" method="POST" action="backend/registrar.php">
                        <div class="mb-3">
                            <label for="regEmail" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="regEmail" name="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="regPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="regPassword" name="contrasena" required>
                        </div>
                        <div class="mb-3">
                            <label for="regConfirmPassword" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="regConfirmPassword" name="confirmar" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                    </form>

                    <p class="text-center">¿Ya tienes una cuenta?
                        <a href="#" onclick="cambiarFormulario()">Inicia Sesión</a>
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
    <script src="php/login/login.js"></script>

</body>

</html>

