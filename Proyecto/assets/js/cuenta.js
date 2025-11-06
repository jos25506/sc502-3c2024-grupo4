const loginForm = document.getElementById('loginFormContainer');
const registerForm = document.getElementById('registerFormContainer');
const logEmail = document.getElementById('logEmail');
const logPassword = document.getElementById('logPassword');
const regEmail = document.getElementById('regEmail');
const regPassword = document.getElementById('regPassword');
const regConfirmPassword = document.getElementById('regConfirmPassword');
let usuarios = [];

document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const email = logEmail.value;
    const password = logPassword.value;

    for (let usuario of usuarios) {
        if (usuario.email === email && usuario.password === password) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Inicio de sesión exitoso.',
            });
            window.location.href = 'index.html';
            return;
        }
    }
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Correo electrónico o contraseña incorrectos.',
    });

});

document.getElementById('registerForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const email = regEmail.value;
    const password = regPassword.value;
    const confirmPassword = regConfirmPassword.value;

    if (password !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Las contraseñas no coinciden.',
        });
        return;
    }

    usuarios.push({ email: email, password: password });

    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'Registro exitoso. Ahora puedes iniciar sesión.',
    });
    cambiarFormulario();
});

function cambiarFormulario() {

    loginForm.classList.toggle('d-none');
    registerForm.classList.toggle('d-none');
    window.scrollTo(0, 1000);
    logEmail.value = '';
    logPassword.value = '';
    regEmail.value = '';
    regPassword.value = '';
    regConfirmPassword.value = '';
}