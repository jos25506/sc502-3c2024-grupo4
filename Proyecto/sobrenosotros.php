<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros | GameMasters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sobrenosotros.css">
</head>

<body>

    <?php include 'php/componentes/navbar.php'?>

    <section class="hero">
        <h1>Conoce a GameMasters</h1>
        <p>Tu tienda gamer de confianza, donde la pasión por los videojuegos se convierte en experiencia.</p>
    </section>

    <!-- HISTORIA -->
    <section class="historia container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="text-info fw-bold mb-3">Nuestra Historia</h2>
                <p>
                    GameMasters nació del sueño de un grupo de gamers apasionados que querían ofrecer más que una
                    tienda:
                    un espacio donde los jugadores pudieran encontrar consolas, videojuegos y accesorios de calidad,
                    acompañados de un servicio confiable y cercano.
                </p>
                <p>
                    Desde nuestros inicios como tienda física, entendimos que el futuro estaba en lo digital.
                    Por eso, dimos el salto a crear una tienda en línea moderna, rápida y segura, para que nuestros
                    clientes
                    puedan comprar desde cualquier lugar y disfrutar de lo mejor del mundo gamer.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="Imagenes/logo.jpg" alt="GameMasters tienda gamer">
            </div>
        </div>
    </section>

    <!-- EQUIPO Y VALORES -->
    <section class="container py-5">
        <h2 class="text-center text-info fw-bold mb-4">Nuestro Equipo y Valores</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 equipo-card text-center">
                    <h5 class="fw-bold text-primary">Pasión Gamer</h5>
                    <p>Vivimos y respiramos videojuegos. Cada recomendación que hacemos viene de la experiencia real de
                        jugar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 equipo-card text-center">
                    <h5 class="fw-bold text-success">Compromiso</h5>
                    <p>Nos esforzamos por ofrecer siempre lo mejor: productos originales, precios justos y atención
                        personalizada.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 equipo-card text-center">
                    <h5 class="fw-bold text-warning">Innovación</h5>
                    <p>Nos mantenemos al día con las últimas tendencias tecnológicas para brindar una experiencia
                        moderna y eficiente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACTO -->
    <section class="contacto container">
        <h3>📞 Contáctanos</h3>
        <p><strong>Dirección:</strong> Avenida Central, San José, Costa Rica</p>
        <p><strong>Teléfono:</strong> +506 8898-7802</p>
        <p><strong>Correo electrónico:</strong> contacto@gamemasters.cr</p>
        <p>¡Escríbenos o visítanos para vivir la experiencia gamer completa!</p>
    </section>


    <footer>
        <p>© 2025 GameMasters. Todos los derechos reservados. | <a href="soporte.html">Contáctanos</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>