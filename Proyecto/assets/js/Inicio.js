document.addEventListener("DOMContentLoaded", () => {
    // SweetAlert bienvenida
    Swal.fire({
        title: "🎮 Bienvenido a GameMasters",
        text: "Explora las mejores promociones y videojuegos del momento.",
        icon: "info",
        confirmButtonColor: "#3b82f6",
        confirmButtonText: "Empezar"
    });




    // Botones Agregar al carrito
    const botonesAgregar = document.querySelectorAll(".agregar-carrito");
    botonesAgregar.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault(); // Evita redirigir de inmediato

            const nombre = btn.dataset.nombre;
            const id = btn.dataset.id;

            Swal.fire({
                icon: "success",
                title: "Producto agregado",
                text: `${nombre} se agregó al carrito`,
                showConfirmButton: false,
                timer: 1200
            }).then(() => {
                // Redirige al carrito después de que cierre la alerta
                window.location.href = `carrito.php?id=${id}`;
            });
        });
    });
});


