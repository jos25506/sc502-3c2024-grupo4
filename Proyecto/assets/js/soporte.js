document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("contactForm");

    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const nombre = document.getElementById("nombre").value.trim();
        const correo = document.getElementById("correo").value.trim();
        const mensaje = document.getElementById("mensaje").value.trim();

        if (nombre && correo && mensaje) {
            Swal.fire({
                title: `¡Gracias, ${nombre}! 🎉`,
                text: "Tu mensaje ha sido enviado con éxito. Nos pondremos en contacto pronto.",
                icon: "success",
                confirmButtonColor: "#00b8a9",
                confirmButtonText: "Aceptar"
            });
            form.reset();
        } else {
            Swal.fire({
                title: "Campos incompletos ❗",
                text: "Por favor, completa todos los campos antes de enviar.",
                icon: "warning",
                confirmButtonColor: "#ff7f50",
                confirmButtonText: "Entendido"
            });
        }
    });
});

