// ============================
//  Confirmar eliminar producto
// ============================
document.querySelectorAll(".eliminar-item").forEach(boton => {
    boton.addEventListener("click", function (e) {
        e.preventDefault();

        const url = this.getAttribute("href");

        Swal.fire({
            title: "¿Eliminar este producto?",
            text: "Se quitará del carrito",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});






// ============================
//  Vaciar carrito
// ============================
const botonVaciar = document.querySelector("a[href*='vaciar']");
if (botonVaciar) {
    botonVaciar.addEventListener("click", function (e) {
        e.preventDefault();
        const url = this.getAttribute("href");

        Swal.fire({
            title: "¿Vaciar carrito?",
            text: "Se eliminarán todos los productos",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, vaciar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
}


// ============================
//  Finalizar compra
// ============================
const finalizarCompra = document.querySelector(".finalizar-compra");
if (finalizarCompra) {
    finalizarCompra.addEventListener("click", function (e) {
        e.preventDefault();
        const url = this.getAttribute("href");

        Swal.fire({
            icon: "success",
            title: "¡Compra realizada!",
            text: "Gracias por tu compra procede a realizar el pago ",
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = url;
        });
    });
}