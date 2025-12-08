document.getElementById("loginForm").addEventListener('submit', async function (e) {

    e.preventDefault();

    const correo = document.getElementById("correo").value.trim();
    const contrasena = document.getElementById("contrasena").value.trim();

    if (correo.length === 0 || contrasena.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe ingresar correo y contraseña.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
        return;
    }

    try {
        const formData = new FormData();
        formData.append("correo", correo);
        formData.append("contrasena", contrasena);

        const respuesta = await fetch('php/login/login.php', {
    method: 'POST',
    body: formData
});


        const data = await respuesta.json();

        if (data.status === 'ok') {

            Swal.fire({
                icon: 'success',
                title: 'Bienvenido',
                text: 'Inicio de sesión exitoso',
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


