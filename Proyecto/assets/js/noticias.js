document.addEventListener("DOMContentLoaded", () => {
    console.log("Blog de GameMasters cargado correctamente 🎮");

    // Ejemplo: animación al abrir los modales
    const modals = document.querySelectorAll(".modal");
    modals.forEach(modal => {
        modal.addEventListener("show.bs.modal", () => {
            document.body.style.filter = "brightness(0.95)";
        });
        modal.addEventListener("hidden.bs.modal", () => {
            document.body.style.filter = "brightness(1)";
        });
    });
});
