<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

session_start();

// Solo administradores
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

include '../conexionBD.php';
$mysqli = abrirConexion();

$id = intval($_GET['id'] ?? 0);
if($id <= 0){
    header("Location: ../catalogo.php");
    exit();
}

// Buscar producto
$stmt = $mysqli->prepare("SELECT * FROM productos WHERE id_producto = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows === 0){
    $stmt->close();
    header("Location:  ../../catalogo.php");
    exit();
}

$producto = $res->fetch_assoc();
$stmt->close();

$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $nombre = trim($_POST['nombre_producto'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $categoria = intval($_POST['categoria_id']);

    // Validaciones
    if($nombre === '') $errors[] = "El nombre del producto es obligatorio";
    if(strlen($nombre) > 150) $errors[] = "El nombre no puede exceder 150 caracteres";
    if($precio <= 0) $errors[] = "El precio debe ser mayor a 0";
    if($stock < 0) $errors[] = "El stock no puede ser negativo";
    if($categoria <= 0) $errors[] = "Debe seleccionar una categoría válida";

    // Manejo de imagen
    $uploadPath = $producto['imagen'] ?? '';

    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE){

        $f = $_FILES['imagen'];
        $maxBytes = 2 * 1024 * 1024;
        $allowed = ['image/jpeg','image/png','image/webp'];

        if($f['size'] > $maxBytes) $errors[] = "La imagen excede 2MB";
        if(!in_array(mime_content_type($f['tmp_name']), $allowed)) $errors[] = "Formato de imagen no permitido";

        if(empty($errors)){
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $newName = uniqid('prod_') . "." . $ext;

            $targetDir = __DIR__ . '/../../Imagenes/';
            if(!is_dir($targetDir)) mkdir($targetDir, 0755, true);

            $dest = $targetDir . $newName;

            if(move_uploaded_file($f['tmp_name'], $dest)){
                $uploadPath = '/../../Imagenes/' . $newName;

                // eliminar foto anterior
                if(!empty($producto['imagen'])){
                    $old = __DIR__ . '/../' . $producto['imagen'];
                    if(file_exists($old)) @unlink($old);
                }
            }
        }
    }

    if(empty($errors)){
        $sql = "UPDATE productos 
                SET nombre_producto = ?, descripcion = ?, precio = ?, stock = ?, categoria_id = ?, imagen = ?
                WHERE id_producto = ?";

        $stmt = $mysqli->prepare($sql);
        if(!$stmt){
            $errors[] = "Error SQL: " . $mysqli->error;
        } else {
            $stmt->bind_param("ssdiisi", $nombre, $descripcion, $precio, $stock, $categoria, $uploadPath, $id);

            if($stmt->execute()){
                header("Location: ../../catalogo.php");
                exit();
            } else {
                $errors[] = "No se pudo actualizar el producto";
            }

            $stmt->close();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card shadow p-4">
        <h3 class="mb-4">Editar Producto</h3>

        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach($errors as $e) echo "<li>$e</li>"; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre_producto" class="form-control"
                       value="<?= htmlspecialchars($producto['nombre_producto']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control"
                       value="<?= $producto['precio'] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control"
                       value="<?= $producto['stock'] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select name="categoria_id" class="form-select">
                    <option value="">-- Seleccione --</option>
                    <?php
                    $cats = $mysqli->query("SELECT * FROM categoria");
                    while($c = $cats->fetch_assoc()):
                    ?>
                    <option value="<?= $c['id_categoria'] ?>" <?= $producto['categoria_id'] == $c['id_categoria'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['nombre_categoria']) ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen actual</label><br>
                <?php if(!empty($producto['imagen'])): ?>
                    <img src="../<?= $producto['imagen'] ?>" width="150" class="rounded shadow">
                <?php else: ?>
                    <p class="text-muted">Sin imagen</p>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label>Cambiar imagen (opcional)</label>
                <input type="file" name="imagen" class="form-control">
            </div>

            <div class="text-end">
                <button class="btn btn-success">Actualizar</button>
                <a href="../../catalogo.php" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>

</div>

</body>
</html>

<?php cerrarConexion($mysqli); ?>

