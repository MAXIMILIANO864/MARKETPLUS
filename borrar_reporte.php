<?php
include 'proteger.php';
include 'conexion.php';

// Seguridad: Solo admin
if ($_SESSION['rol'] != 'admin') {
    die("Acceso denegado.");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Borramos el reporte
    $sql = "DELETE FROM reportes_guardados WHERE id_reporte = '$id'";
    
    if ($conexion->query($sql) === TRUE) {
        // Redirigir rápido
        header("Location: reportes.php");
    } else {
        echo "Error al borrar: " . $conexion->error;
        echo "<br><a href='reportes.php'>Volver</a>";
    }
} else {
    header("Location: reportes.php");
}
?>
