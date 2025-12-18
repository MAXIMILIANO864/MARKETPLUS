<?php
include 'proteger.php';
include 'conexion.php';

// Seguridad: Solo admin puede borrar
if ($_SESSION['rol'] != 'admin') {
    die("Acceso denegado.");
}

// Verificamos si recibimos el ID del empleado a borrar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Borramos de la base de datos
    $sql = "DELETE FROM empleados WHERE id_empleado = '$id'";

    if ($conexion->query($sql) === TRUE) {
        // Si funcionó, volvemos a la lista
        header("Location: gestion_empleados.php");
    } else {
        // Si falla (por ejemplo, si el empleado ya tiene ventas registradas y la base de datos lo protege)
        echo "Error al borrar: " . $conexion->error;
        echo "<br><a href='gestion_empleados.php'>Volver</a>";
    }
} else {
    header("Location: gestion_empleados.php");
}
?>
