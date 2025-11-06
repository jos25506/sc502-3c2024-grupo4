document.addEventListener("DOMContentLoaded", () => {
  const catalogo = document.getElementById("catalogo");

  const videojuegos = [
    {
      titulo: "FIFA 2024 Playstation 5",
      descripcion: "Vive la experiencia del fútbol con gráficos y jugabilidad mejorados en tu consola PS5.",
      precio: 28000,
      categoria: "Deportes",
      proveedor: "Sony",
      imagen: "Imagenes/juego-para-consola-sony-fifa-2024-189447.webp"
    },
    {
      titulo: "Dios de la Guerra: Ragnarok",
      descripcion: "Acompaña a Kratos en una épica aventura mitológica llena de acción y combate intenso.",
      precio: 20000,
      categoria: "Acción",
      proveedor: "Sony",
      imagen: "Imagenes/Dios de la guerra.jpeg"
    },
    {
      titulo: "Elden Ring",
      descripcion: "Explora un vasto mundo abierto lleno de desafíos, jefes legendarios y misterios épicos.",
      precio: 32000,
      categoria: "RPG",
      proveedor: "FromSoftware",
      imagen: "Imagenes/The ring.avif"
    },
  ];

  videojuegos.forEach(juego => {
    const card = document.createElement("div");
    card.className = "col-md-4";
    card.innerHTML = `
      <div class="card shadow h-100">
        <img src="${juego.imagen}" class="card-img-top" alt="${juego.titulo}" style="height: 220px; object-fit: cover;">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">${juego.titulo}</h5>
          <p class="card-text">${juego.descripcion}</p>
          <ul class="list-unstyled mt-auto">
            <li><strong>Categoría:</strong> ${juego.categoria}</li>
            <li><strong>Proveedor:</strong> ${juego.proveedor}</li>
            <li class="fw-bold text-success">₡${juego.precio}</li>
          </ul>
          <button class="btn btn-primary mt-2" onclick="agregarCarrito('${juego.titulo}')">Agregar al carrito</button>
        </div>
      </div>
    `;
    catalogo.appendChild(card);
  });
});

// Función para alerta al agregar al carrito
function agregarCarrito(nombre) {
  Swal.fire({
    title: "¡Agregado al carrito!",
    text: `${nombre} se añadió correctamente.`,
    icon: "success",
    timer: 1500,
    showConfirmButton: false
  });
  window.location.href = "carrito.html?item=" + encodeURIComponent(nombre);
}