<?php
include 'proteger.php';
include 'conexion.php';

// Verificar que sea administrador
if ($_SESSION['rol'] != 'admin') {
    die("Acceso denegado.");
}

// Recibir datos del formulario
$id_producto = $_POST['id_producto'];
$cantidad_agregar = $_POST['cantidad'];

// Verificar que la cantidad sea válida
if ($cantidad_agregar > 0) {
    
    // Consulta SQL para SUMAR stock (stock actual + lo nuevo)
    $sql = "UPDATE producto SET stock = stock + $cantidad_agregar WHERE id_producto = '$id_producto'";

    if ($conexion->query($sql) === TRUE) {
        // Redirigir de vuelta a productos
        header("Location: ver_productos.php");
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }

} else {
    // Si puso 0 o menos, solo regresar
    header("Location: ver_productos.php");
}
?>
