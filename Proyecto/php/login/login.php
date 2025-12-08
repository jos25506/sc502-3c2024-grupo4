<?php
header('Content-Type: application/json');

session_start();

$response = [
    'status' => 'error',
    'mensaje' => 'Error inesperado',
    'debug' => 'inicio'
];

try {

    include '../conexionBD.php';

    // Recibir datos vía POST (FormData)
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');
    

    if (!$correo || !$contrasena) {
        $response['mensaje'] = 'Correo o contraseña vacíos.';
        $response['debug'] = 'POST vacío';
        echo json_encode($response);
        exit();
    }

    $mysqli = abrirConexion();

    // Consulta según tu tabla "usuarios"
    $sql = "SELECT id_usuario, nombre, correo, contrasena, rol 
            FROM usuarios 
            WHERE correo = ?";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        $response['mensaje'] = 'Error al preparar consulta.';
        $response['debug'] = $mysqli->error;
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {

        $fila = $resultado->fetch_assoc();

        if ($contrasena === $fila['contrasena']) {

            $_SESSION['id_usuario'] = $fila['id_usuario'];
            $_SESSION['nombre']     = $fila['nombre'];
            $_SESSION['correo']     = $fila['correo'];
            $_SESSION['rol']        = $fila['rol'];

            $response = [
                'status' => 'ok',
                'nombre' => $fila['nombre'],
                'rol'    => $fila['rol'],
                'debug'  => 'login exitoso'
            ];

        } else {
            $response['mensaje'] = 'Contraseña incorrecta';
            $response['debug']   = 'password_verify false';
        }

    } else {
        $response['mensaje'] = 'Usuario no encontrado';
        $response['debug']   = 'no existe';
    }

    cerrarConexion($mysqli);

} catch (Exception $e) {
    $response['mensaje'] = 'Error en el login';
    $response['debug']   = $e->getMessage();
}

echo json_encode($response);
exit();
