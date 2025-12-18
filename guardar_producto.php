<?php
include 'proteger.php';
include 'conexion.php';

if ($_SESSION['rol'] != 'admin') die("Acceso denegado.");

// --- AUTO-REPARACIÓN DE LA BASE DE DATOS ---
// Si la columna 'sucursal' no existe, la creamos antes de guardar.
$check = $conexion->query("SHOW COLUMNS FROM producto LIKE 'sucursal'");
if ($check->num_rows == 0) {
    $conexion->query("ALTER TABLE producto ADD sucursal VARCHAR(100) DEFAULT 'Centro'");
}
// -------------------------------------------

// Recibimos los datos
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$sucursal = $_POST['sucursal'];

// Insertamos
$sql = "INSERT INTO producto (descripcion, precio, stock, sucursal) VALUES ('$descripcion', '$precio', '$stock', '$sucursal')";

if ($conexion->query($sql) === TRUE) {
    echo "<script>
            alert('¡Producto agregado correctamente!');
            window.location.href = 'ver_productos.php';
          </script>";
} else {
    echo "Error al guardar: " . $conexion->error;
    echo "<br><a href='agregar_producto.php'>Volver a intentar</a>";
}
?>
