<?php
include 'proteger.php';
include 'conexion.php';

if ($_SESSION['rol'] != 'admin') die("Acceso denegado.");

// --- AUTO-REPARACIÓN DE LA BASE DE DATOS ---
// Verificamos si la columna 'sucursal' existe. Si no, la creamos aquí mismo.
$check = $conexion->query("SHOW COLUMNS FROM producto LIKE 'sucursal'");
if ($check->num_rows == 0) {
    $conexion->query("ALTER TABLE producto ADD sucursal VARCHAR(100) DEFAULT 'Centro'");
}
// -------------------------------------------

// Recibir datos
$id_original = $_POST['id_original'];
$id_nuevo = $_POST['id_nuevo'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$sucursal = $_POST['sucursal'];

// Actualizar datos
$sql = "UPDATE producto SET 
        id_producto = '$id_nuevo', 
        descripcion = '$descripcion', 
        precio = '$precio', 
        sucursal = '$sucursal' 
        WHERE id_producto = '$id_original'";

if ($conexion->query($sql) === TRUE) {
    echo "<script>
            alert('¡Producto modificado correctamente!');
            window.location.href = 'ver_productos.php';
          </script>";
} else {
    echo "<div style='font-family:sans-serif; padding:20px;'>";
    echo "<h2 style='color:red'>Ocurrió un error</h2>";
    echo "<p>Detalle: " . $conexion->error . "</p>";
    echo "<br><a href='ver_productos.php'>Volver</a>";
    echo "</div>";
}
?>
