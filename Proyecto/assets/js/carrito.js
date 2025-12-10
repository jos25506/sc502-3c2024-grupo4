const carrito = document.getElementById("carrito");
const totalCarrito = document.getElementById("total-carrito");
let carritoItems = [];

document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const itemId = urlParams.get("item");
    if (itemId) {
        agregarItem(itemId);
    }

    mostrarItems();
});

function agregarItem(itemId) {
    carritoItems.push(itemId);
    Swal.fire({
        title: "¡Añadido al carrito! 🛒",
        icon: "success",
        confirmButtonColor: "#00b8a9",
        confirmButtonText: "Aceptar"
    });
}

function eliminarItem(itemId) {
    if (itemId == null) {
        carritoItems = [];
        Swal.fire({
            title: "¡Carrito vaciado! 🛒",
            icon: "success",
            confirmButtonColor: "#00b8a9",
            confirmButtonText: "Aceptar"
        });
    } else {
        carritoItems = carritoItems.filter(item => item !== itemId);
    }
    mostrarItems();
}

function mostrarItems() {
    let total = 0;
    if (carritoItems.length > 0) {
        carrito.innerHTML = "";
        totalCarrito.innerText = "20000.00";
    } else {
        carrito.innerHTML = "<tr id='carrito-vacio'><td colspan='5' class='text-center'>Tu carrito está vacío. Visita nuestro <a href='catalogo.html'>catálogo</a> para agregar productos.</td></tr>"
        totalCarrito.innerText = "0.00";
        return;
    }
    for (let i in carritoItems) {
        let item = document.createElement("tr");
        item.innerHTML = `<td>${carritoItems[i]}</td><td>₡20000.00</td><td>1</td><td>₡20000.00</td><td><button class="btn btn-danger" onclick="eliminarItem('${carritoItems[i]}')">Eliminar</button></td>`;
        carrito.appendChild(item);
    }


    const botonesEditar = document.querySelectorAll(".editar-cantidad");
    botonesEditar.forEach(btn=>{
        btn.addEventListener("click",()=>{
            Swal.fire({
                icon:"success",
                title:"Cantidad actualizada",
                showConfirmButton:false,
                timer:1200
            });
        });
    });

    // Vaciar carrito
    const vaciar = document.querySelector("#vaciar-carrito");
    if(vaciar){
        vaciar.addEventListener("click",(e)=>{
            e.preventDefault();
            Swal.fire({
                title:"¿Vaciar carrito?",
                icon:"warning",
                showCancelButton:true,
                confirmButtonColor:"#3085d6",
                cancelButtonColor:"#d33",
                confirmButtonText:"Sí, vaciar"
            }).then((result)=>{
                if(result.isConfirmed){
                    window.location.href="carrito.php?vaciar=1";
                }
            });
        });
    }

    // Finalizar compra
    const finalizar = document.querySelector("#finalizar-compra");
    if(finalizar){
        finalizar.addEventListener("click",(e)=>{
            e.preventDefault();
            Swal.fire({
                icon:"success",
                title:"Compra realizada",
                text:"Gracias por tu compra",
                showConfirmButton:false,
                timer:1500
            }).then(()=>{
                window.location.href="carrito.php?vaciar=1";
            });
        });
    }

}