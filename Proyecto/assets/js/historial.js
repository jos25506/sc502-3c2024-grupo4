document.addEventListener("DOMContentLoaded", () => {

    // Interceptar todos los formularios de "cambiar estado"
    const forms = document.querySelectorAll(".cambiar-estado-form");

    forms.forEach(form => {
        form.addEventListener("submit", async (e) => {
            e.preventDefault(); // evita envío inmediato

            const estado = form.querySelector("select[name='estado']").value;

            const confirmacion = await Swal.fire({
                title: "¿Actualizar estado?",
                text: "El pedido cambiará a: " + estado,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#9333ea",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Sí, actualizar",
                cancelButtonText: "Cancelar"
            });

            if (confirmacion.isConfirmed) {
                // Enviar formulario
                form.submit();
            }
        });
    });

    // Mostrar alerta tras actualizar (viene desde PHP por GET)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get("estado") === "ok") {
        Swal.fire({
            title: "¡Estado actualizado!",
            text: "El pedido se actualizó correctamente.",
            icon: "success",
            confirmButtonColor: "#9333ea"
        });
    }

});

