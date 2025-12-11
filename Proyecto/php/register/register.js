document.getElementById("registerForm").addEventListener('submit', async function (e) {

    e.preventDefault();

    const nombre = document.getElementById("nombre").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const telefono = document.getElementById("telefono").value.trim();
    const direccion = document.getElementById("direccion").value.trim();
    const contrasena = document.getElementById("contrasena").value.trim();
    const confirmarContrasena = document.getElementById("confirmarContrasena").value.trim();
    

    if (correo.length === 0 || contrasena.length === 0 || nombre.length === 0 || telefono.length === 0 || direccion.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Revise que todos los campos estén completos.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
        return;
    }

    if(contrasena !== confirmarContrasena){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Revise que las contraseñas coinciden.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
        return;
    }

    try {
        const formData = new FormData();
        formData.append("nombre", nombre);
        formData.append("correo", correo);
        formData.append("telefono", telefono);
        formData.append("direccion", direccion);
        formData.append("contrasena", contrasena);

        const respuesta = await fetch('php/register/register.php', {
    method: 'POST',
    body: formData
});


        const data = await respuesta.json();

        if (data.status === 'ok') {

            Swal.fire({
                icon: 'success',
                title: 'Usuario creado',
                text: 'Te has registrado exitosamente.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
            });

            setTimeout(() => {
                if (data.rol === 'admin') {
                    window.location.href = "index.php";
                } else {
                    window.location.href = "perfil.php";
                }
            }, 2000);

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.mensaje,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            });
        }

    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se logró contactar al servidor: ' + error,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
    }

});