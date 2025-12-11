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

    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');
    $rol = 'cliente'; //Se asigna cliente por defecto

    if (!$correo || !$contrasena || !$telefono || !$direccion || !$nombre) {
        $response['mensaje'] = 'Revise que todos los campos estén completos.';
        $response['debug'] = 'POST vacío';
        echo json_encode($response);
        exit();
    }

    $mysqli = abrirConexion();

    $sql_ya_existe = "SELECT id_usuario FROM usuarios WHERE correo = ?";
    $stmt_existencia = $mysqli->prepare($sql_ya_existe);

    if (!$stmt_existencia) {
        $response['mensaje'] = 'Error al preparar consulta de existencia.';
        $response['debug'] = $mysqli->error;
        cerrarConexion($mysqli);
        echo json_encode($response);
        exit();
    }

    $stmt_existencia->bind_param("s", $correo);
    $stmt_existencia->execute();
    $resultado_existencia = $stmt_existencia->get_result();
    $stmt_existencia->close();

    if ($resultado_existencia && $resultado_existencia->num_rows > 0) {
        $response['mensaje'] = 'Ese correo electrónico ya está registrado.';
        $response['debug']  = 'el usuario ya existe';
        cerrarConexion($mysqli);
        echo json_encode($response);
        exit();
    }

    $sql_insert = "INSERT INTO usuarios (nombre, correo, telefono, direccion, contrasena, rol) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert = $mysqli->prepare($sql_insert);

    if (!$stmt_insert) {
        $response['mensaje'] = 'Error al crear nuevo usuario. Intenta de nuevo.';
        $response['debug'] = $mysqli->error;
        cerrarConexion($mysqli);
        echo json_encode($response);
        exit();
    }

    $stmt_insert->bind_param("ssssss", $nombre, $correo, $telefono, $direccion, $contrasena, $rol);
    
    if ($stmt_insert->execute()) {
        $response = [
            'status' => 'ok',
            'mensaje' => '¡Registro exitoso! Ya puedes iniciar sesión.',
            'debug' => 'registro exitoso'
        ];
        
    } else {
        $response['mensaje'] = 'Error al crear el usuario. Intenta de nuevo.';
        $response['debug'] = $stmt_insert->error;
    }

    $stmt_insert->close();
    cerrarConexion($mysqli);

} catch (Exception $e) {
    $response['mensaje'] = 'Error en el proceso de registro';
    $response['debug']  = $e->getMessage();
}

echo json_encode($response);
exit();
