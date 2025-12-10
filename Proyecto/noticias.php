<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog / Noticias | GameMasters</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


  <link rel="stylesheet" href="assets/css/noticias.css">
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


  <!-- HERO -->
  <section class="hero bg-dark text-light text-center py-5">
    <div class="container">
      <h1 class="fw-bold">Noticias y Tendencias del Mundo Gamer</h1>
      <p class="lead text-secondary">Mantente al día con los lanzamientos, eventos y curiosidades más recientes del
        universo gamer.</p>
    </div>
  </section>

  <!-- SECCIÓN DE NOTICIAS -->
  <section class="container my-5">
    <div class="row g-4">

      <!-- NOTICIA 1 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="imagenes/gta6.jpg" class="card-img-top" alt="Grand Theft Auto VI">
          <div class="card-body">
            <h5 class="card-title text-info">Rockstar confirma lanzamiento de GTA VI</h5>
            <p class="card-text">Después de años de espera, Rockstar Games anuncia la fecha oficial de lanzamiento de
              GTA VI junto con un nuevo tráiler lleno de acción.</p>
            <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalGTA">Leer
              más</button>
          </div>
        </div>
      </div>

      <!-- NOTICIA 2 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="Imagenes/zelda.jpg" class="card-img-top" alt="The Legend of Zelda">
          <div class="card-body">
            <h5 class="card-title text-success">Nintendo presenta nuevo Zelda</h5>
            <p class="card-text">Nintendo sorprende con un nuevo título de Zelda que promete revolucionar la saga con
              mecánicas nunca vistas.</p>
            <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalZelda">Leer
              más</button>
          </div>
        </div>
      </div>

      <!-- NOTICIA 3 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="Imagenes/esports.jpg" class="card-img-top" alt="eSports mundial">
          <div class="card-body">
            <h5 class="card-title text-warning">Los eSports dominan el 2025</h5>
            <p class="card-text">El auge competitivo continúa creciendo con torneos internacionales y nuevas
              oportunidades para los jugadores profesionales.</p>
            <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEsports">Leer
              más</button>
          </div>
        </div>
      </div>

      <!-- NOTICIA 4 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="Imagenes/ghost-of-yotei.jpg" class="card-img-top" alt="Ghost of Yotei">
          <div class="card-body">
            <h5 class="card-title text-danger">Ghost of Yotei: Un precioso mundo abierto guiado por una historia de
              venganza</h5>
            <p class="card-text">Ghost of Yotei es un videojuego precioso, especialmente por sus paisajes, que retratan
              la belleza de la región de Hokkaido.</p>
            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalyotei">Leer
              más</button>
          </div>
        </div>
      </div>

      <!-- NOTICIA 5 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="Imagenes/Resident.jpg" class="card-img-top" alt="Resident Evil: Requiem">
          <div class="card-body">
            <h5 class="card-title text-primary">Resident Evil: Requiem</h5>
            <p class="card-text">Nueva entrega de terror y supervivencia desarrollado y publicado por Capcom. Es la
              secuela de Resident Evil Village (2021) y la undécima entrega principal de la serie de videojuegos
              Resident Evil.</p>
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalResident">Leer
              más</button>
          </div>
        </div>
      </div>

      <!-- NOTICIA  6 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="imagenes/code-violet.jpg" class="card-img-top"
            alt="Próximos lanzamientos para lo que resta del año">
          <div class="card-body">
            <h5 class="card-title text-primary">Próximos Lanzamientos 2025</h5>
            <p class="card-text">Grandes estrenos que llegan este fin de año: nuevas entregas, sagas y títulos que
              dejaran de que hablar.</p>
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
              data-bs-target="#modalLanzamientos">Leer más</button>
          </div>
        </div>
      </div>


    </div>
  </section>

  <!-- VIDEO -->
  <section class="container text-center my-5">
    <h2 class="fw-bold text-info mb-4"> Videojuego Destacado de la Semana</h2>
    <div class="ratio ratio-16x9 shadow">
      <iframe src="https://www.youtube.com/embed/wFGEMfyAQtI" title="Tráiler Battlefield 6" allowfullscreen></iframe>
    </div>
  </section>

  <!-- MODALES -->
  <!-- MODAL: GTA VI -->
  <div class="modal fade" id="modalGTA" tabindex="-1" aria-labelledby="modalGTA" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header border-0">
          <h5 class="modal-title text-info">Rockstar confirma lanzamiento de GTA VI</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>
            Rockstar Games ha anunciado oficialmente el lanzamiento de Grand Theft Auto VI,
            prometiendo un salto gráfico revolucionario y una historia más profunda que nunca.
            El juego estará disponible para consolas de nueva generación y PC en 2025.
          </p>
          <img src="imagenes/gta6.jpg" class="img-fluid rounded mt-2" alt="GTA VI">
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL: Zelda -->
  <div class="modal fade" id="modalZelda" tabindex="-1" aria-labelledby="modalZelda" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header border-0">
          <h5 class="modal-title text-success">Nintendo presenta nuevo Zelda</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>
            El nuevo Zelda promete llevarnos a un mundo más misterioso, con una historia más oscura
            y mecánicas completamente innovadoras. La comunidad ya lo considera uno de los lanzamientos
            más esperados del año.
          </p>
          <img src="imagenes/zelda.jpg" class="img-fluid rounded mt-2" alt="Zelda nuevo">
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL: eSports -->
  <div class="modal fade" id="modalEsports" tabindex="-1" aria-labelledby="modalEsports" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header border-0">
          <h5 class="modal-title text-warning">Los eSports dominan el 2025</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>
            Los eSports alcanzan cifras récord en audiencia y premios, consolidándose como una de las
            industrias más lucrativas del entretenimiento digital. Equipos de todo el mundo compiten
            en eventos internacionales de gran magnitud.
          </p>
          <img src="imagenes/esports.jpg" class="img-fluid rounded mt-2" alt="eSports">
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL: yotei -->
  <div class="modal fade" id="modalyotei" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header border-0">
          <h5 class="modal-title text-danger">Ghost of Yotei:Una historia de venganza</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Ghost of Yotei narrativamente se sitúa 300 años después y escoge la venganza como temática principal. Lo
            hace a través de una protagonista, Atsu, con la que logramos conectar casi inmediatamente. La narración
            cinematográfica está muy cuidada y es efectiva. Nos sumerge en el pasado traumático de una mujer que perdió
            a su familia ante sus ojos, con un dolor desgarrador que la persigue durante la aventura. La premisa
            evoluciona mientras jugamos, y comprobar hacia dónde nos dirige su propósito es tremendamente interesante.
          </p>
          <img src="Imagenes/ghost-of-yotei.jpg" class="img-fluid rounded mt-2" alt="Ghost of yotei">
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL: Resident -->
  <div class="modal fade" id="modalResident" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header border-0">
          <h5 class="modal-title text-primary">Resident Evil Requiem: La nueva entrega de Capcom</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>La historia de Resident Evil Requiem se lleva a cabo en el año 2028, cuando se suceden eventos extraños en
            una ciudad del medio oeste estadounidense, es entonces cuando la agente del FBI Grace Ashcroft, es enviada a
            investigar las misteriosas muertes; todo ello sucediéndose en la ciudad estadounidense más cercana a donde
            estuvo alguna vez Raccoon City; siendo el Hotel Wrenwood, entre ambas, el lugar de las muertes, que además
            es el lugar donde la madre de Grace falleció hace ocho años.</p>
          <img src="Imagenes/Resident.jpg" class="img-fluid rounded mt-2" alt="Resident">
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL: Próximos Lanzamientos -->
  <div class="modal fade" id="modalLanzamientos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header border-0">
          <h5 class="modal-title text-info">🎮 Próximos Lanzamientos 2025</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <img src="imagenes/code-violet.jpg" class="img-fluid rounded mb-4" alt="Próximos lanzamientos 2025">

          <p>Este cierre de año es prometedor para los videojuegos. Desde aventuras épicas hasta simuladores de nueva
            generación, estos son los títulos más esperados que llegarán en los próximos meses:</p>

          <ul class="list-group list-group-flush bg-dark text-light mt-3">
            <li class="list-group-item bg-dark text-light border-secondary">
              <strong class="text-primary">Assassin's Creed Shadows</strong> — Disponible en <em>Switch 2</em>.
              Ubisoft lleva la saga al Japón feudal con un nuevo enfoque de sigilo y combate dual.
            </li>

            <li class="list-group-item bg-dark text-light border-secondary">
              <strong class="text-success">Metroid Prime 4: Beyond</strong> — Disponible en <em>Switch / Switch 2</em>.
              Samus Aran regresa en una misión cósmica que redefine la serie con mecánicas avanzadas.
            </li>

            <li class="list-group-item bg-dark text-light border-secondary">
              <strong class="text-warning">Age of Empires IV</strong> — Disponible en <em>PS5</em>.
              El clásico de estrategia llega por primera vez a consolas PlayStation con optimización total.
            </li>

            <li class="list-group-item bg-dark text-light border-secondary">
              <strong class="text-danger">Monster Hunter Stories 2: Wings of Ruin</strong> — Disponible en
              <em>Xbox</em>.
              Caza y entrena monstruos en una nueva experiencia RPG llena de acción y exploración.
            </li>

            <li class="list-group-item bg-dark text-light border-secondary">
              <strong class="text-info">Code Violet</strong> — Exclusivo para <em>PS5</em>.
              Un thriller futurista con una historia cinematográfica llena de misterio y tecnología avanzada.
            </li>

            <li class="list-group-item bg-dark text-light border-secondary">
              <strong class="text-secondary">Project Motor Racing</strong> — Disponible en <em>PC / Xbox / PS5</em>.
              Un simulador realista con físicas de nueva generación y circuitos de todo el mundo.
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="bg-dark text-light text-center py-3 mt-5">
    <p>© 2025 GameMasters. Todos los derechos reservados. | <a href="soporte.html" class="text-info">Contáctanos</a></p>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/blog.js"></script>
</body>

</html>