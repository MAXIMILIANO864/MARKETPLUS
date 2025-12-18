<?php
include 'proteger.php';
include 'conexion.php';

if ($_SESSION['rol'] != 'admin') die("Acceso denegado.");

// Recibir datos
$id = $_POST['id_empleado'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido']; // Nuevo
$email = $_POST['email'];
$cargo = $_POST['cargo'];       // Nuevo
$id_gerente = $_POST['id_gerente'];

$campo_gerente = ($id_gerente == "NULL") ? "NULL" : "'$id_gerente'";

// Actualizar TODO
$sql = "UPDATE empleados SET 
        nombre='$nombre', 
        apellido='$apellido', 
        email='$email', 
        cargo='$cargo', 
        id_gerente=$campo_gerente 
        WHERE id_empleado='$id'";

if ($conexion->query($sql) === TRUE) {
    header("Location: gestion_empleados.php");
} else {
    echo "Error actualizando: " . $conexion->error;
}
?>
