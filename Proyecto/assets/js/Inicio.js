document.addEventListener("DOMContentLoaded", () => {
    // Mensaje de bienvenida
    Swal.fire({
        title: "🎮 Bienvenido a GameMasters",
        text: "Explora las mejores promociones y videojuegos del momento.",
        icon: "info",
        confirmButtonColor: "#3b82f6",
        confirmButtonText: "Empezar"
    });

    // Funcionalidad de botones de género
    const botonesGenero = document.querySelectorAll(".genero-btn");

    botonesGenero.forEach(boton => {
        boton.addEventListener("click", () => {
            const genero = boton.dataset.genero;
            Swal.fire({
                title: `🎮 Género: ${genero}`,
                text: `Estás explorando los mejores juegos de ${genero}.`,
                icon: "success",
                confirmButtonColor: "#9333ea",
                confirmButtonText: "Ver más"
            });
        });
    });
});
