<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

session_start();

// Solo ADMIN puede agregar productos
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

include '../conexionBD.php';
$mysqli = abrirConexion();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre_producto'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $categoria = intval($_POST['categoria_id'] ?? 0);

    // VALIDACIONES
    if ($nombre === '') $errors[] = "El nombre del producto es obligatorio";
    if (strlen($nombre) > 150) $errors[] = "El nombre no puede exceder 150 caracteres";
    if ($precio <= 0) $errors[] = "El precio debe ser mayor a 0";
    if ($stock < 0) $errors[] = "El stock no puede ser negativo";
    if ($categoria <= 0) $errors[] = "Debe seleccionar una categoría válida";

    // IMAGEN (opcional)
    $uploadPath = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {

        $f = $_FILES['imagen'];
        $maxBytes = 2 * 1024 * 1024;
        $allowed = ['image/jpeg','image/png','image/webp'];

        if ($f['size'] > $maxBytes) $errors[] = "La imagen excede 2MB";
        if (!in_array(mime_content_type($f['tmp_name']), $allowed)) {
            $errors[] = "Formato de imagen no permitido";
        }

        if (empty($errors)) {
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $newName = uniqid('prod_') . "." . $ext;

            $dir = __DIR__ . '/../../Imagenes/';
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            $dest = $dir . $newName;

            if (move_uploaded_file($f['tmp_name'], $dest)) {
                $uploadPath = 'Imagenes/' . $newName;
            }
        }
    }

    // SI TODO BIEN → INSERTAR
    if (empty($errors)) {

        $sql = "INSERT INTO productos (nombre_producto, descripcion, precio, stock, categoria_id, imagen)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            $errors[] = "Error preparar consulta: " . $mysqli->error;
        } else {
            $stmt->bind_param("ssdiis", 
                $nombre, 
                $descripcion, 
                $precio, 
                $stock, 
                $categoria, 
                $uploadPath
            );

            if ($stmt->execute()) {
                header("Location: ../../catalogo.php");
                exit();
            } else {
                $errors[] = "Error al insertar producto: " . $mysqli->error;
            }

            $stmt->close();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Agregar Producto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card p-4 shadow">

        <h3 class="mb-4">Agregar Nuevo Producto</h3>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach($errors as $e) echo "<li>$e</li>"; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Nombre del producto</label>
                <input type="text" name="nombre_producto" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select name="categoria_id" class="form-select">
                    <option value="">-- Seleccione --</option>
                    <?php
                    $cats = $mysqli->query("SELECT * FROM categoria ORDER BY nombre_categoria");
                    while($c = $cats->fetch_assoc()):
                    ?>
                    <option value="<?= $c['id_categoria'] ?>">
                        <?= htmlspecialchars($c['nombre_categoria']) ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen (opcional)</label>
                <input type="file" name="imagen" class="form-control">
            </div>

            <div class="text-end">
                <button class="btn btn-success">Guardar</button>
                <a href="../../catalogo.php" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>

    </div>
</div>

</body>
</html>

