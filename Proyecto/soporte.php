<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte - GameMasters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/soporte.css">
</head>

<body>

    <!-- NAV -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">GameMasters</a>

            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalogo.php">Catálogo</a></li>
                    <li class="nav-item"><a class="nav-link" href="carrito.php">Carrito</a></li>
                    <li class="nav-item"><a class="nav-link" href="cuenta.php">Cuenta</a></li>
                    <li class="nav-item"><a class="nav-link" href="noticias.php">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link active" href="soporte.php">Soporte</a></li>
                    <li class="nav-item"><a class="nav-link" href="sobrenosotros.php">Sobre Nosotros</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HEADER -->
    <header class="header">
        <h1>Centro de Soporte GameMasters 🎮</h1>
        <p>Encuentra respuestas rápidas o contáctanos para recibir ayuda personalizada.</p>
    </header>

    <!-- FAQ -->
    <section class="faq-section">
        <h2>Preguntas Frecuentes (FAQ)</h2>

        <div class="faq-item">
            <h3>📦 ¿Cuánto tarda en llegar mi pedido?</h3>
            <p>Los envíos nacionales tardan entre 2 y 5 días hábiles dependiendo de tu ubicación.</p>
        </div>

        <div class="faq-item">
            <h3>💳 ¿Qué métodos de pago aceptan?</h3>
            <p>Aceptamos tarjetas Visa, MasterCard, PayPal y pagos por transferencia bancaria.</p>
        </div>

        <div class="faq-item">
            <h3>🔄 ¿Puedo devolver un producto?</h3>
            <p>Sí, puedes solicitar una devolución dentro de los primeros 7 días hábiles tras recibir tu pedido.</p>
        </div>
    </section>

    <!-- CONTACT -->
    <section class="contact-section">
        <h2>¿No encontraste tu respuesta? Envíanos tu duda 👇</h2>

        <form id="contactForm">
            <input type="text" id="nombre" placeholder="Tu nombre" required>
            <input type="email" id="correo" placeholder="Tu correo electrónico" required>
            <textarea id="mensaje" rows="4" placeholder="Escribe tu mensaje aquí..." required></textarea>
            <button type="submit">Enviar Mensaje</button>
        </form>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 GameMasters. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/soporte.js"></script>

</body>
</html>
