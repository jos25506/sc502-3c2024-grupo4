<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

session_start();

// Solo ADMIN puede eliminar productos
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

include '../conexionBD.php';
$mysqli = abrirConexion();

// ID del producto
$id = intval($_GET['id'] ?? 0);

if ($id > 0) {

    // 1️⃣ Obtener la imagen del producto antes de borrarlo
    $stmt = $mysqli->prepare("SELECT imagen FROM productos WHERE id_producto = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        $fila = $res->fetch_assoc();

        // Si tiene imagen → eliminar del servidor
        if (!empty($fila['imagen'])) {
            $path = __DIR__ . '/../../' . $fila['imagen']; // ruta absoluta

            if (file_exists($path)) {
                @unlink($path); // borrar imagen
            }
        }
        $stmt->close();

        // 2️⃣ Eliminar producto de la base de datos
        $del = $mysqli->prepare("DELETE FROM productos WHERE id_producto = ?");
        $del->bind_param("i", $id);
        $del->execute();
        $del->close();
    } else {
        $stmt->close();
    }
}

cerrarConexion($mysqli);

// Redirigir a la lista
header("Location: ../../catalogo.php");
exit();
?>
