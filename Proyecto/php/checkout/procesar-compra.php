<?php
session_start();
include '../conexionBD.php';

$mysqli = abrirConexion();

// Validaciones
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../cuenta.php");
    exit();
}

if (empty($_SESSION['carrito'])) {
    header("Location: ../../carrito.php");
    exit();
}

$metodo = $_POST['metodo_pago'] ?? '';
if ($metodo === '') {
    exit("Error: seleccione un método de pago.");
}

$id_usuario = $_SESSION['id_usuario'];
$total = 0;

foreach ($_SESSION['carrito'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

// --------------- INSERTAR PEDIDO -----------------

$sql = "INSERT INTO pedido (id_usuario, fecha_pedido, total, estado)
        VALUES (?, NOW(), ?, 'pendiente')";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("id", $id_usuario, $total);
$stmt->execute();

$id_pedido = $stmt->insert_id;
$stmt->close();

// --------------- INSERT DETALLE -------------------

$sql_det = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario)
            VALUES (?, ?, ?, ?)";

$stmt_det = $mysqli->prepare($sql_det);

foreach ($_SESSION['carrito'] as $item) {
    $stmt_det->bind_param(
        "iiid",
        $id_pedido,
        $item['id'],
        $item['cantidad'],
        $item['precio']
    );
    $stmt_det->execute();
}

$stmt_det->close();

// --------------- INSERT PAGO -----------------------

$sql_pago = "INSERT INTO pago (id_pedido, metodo_pago, fecha_pago, monto, estado_pago)
             VALUES (?, ?, NOW(), ?, 'pendiente')";

$stmt_pago = $mysqli->prepare($sql_pago);
$stmt_pago->bind_param("isd", $id_pedido, $metodo, $total);
$stmt_pago->execute();
$stmt_pago->close();

// --------------- HISTORIAL -------------------------

$sql_h = "INSERT INTO historial_pedidos (id_pedido, fecha_evento, descripcion_evento)
          VALUES (?, NOW(), 'Pedido registrado, pendiente de pago')";

$stmt_h = $mysqli->prepare($sql_h);
$stmt_h->bind_param("i", $id_pedido);
$stmt_h->execute();
$stmt_h->close();

// Vaciar carrito
unset($_SESSION['carrito']);

header("Location: ../../confirmacion.php?pedido=$id_pedido");
exit();
