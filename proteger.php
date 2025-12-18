<?php
// Iniciar la sesión
session_start();

// Comprobar si la variable de sesión 'id_usuario' NO existe
if (!isset($_SESSION['id_usuario'])) {
    // Si no existe, significa que el usuario no ha iniciado sesión
    // Redirigir al formulario de inicio de sesión (index.php)
    header("Location: index.php");
    // Detener la ejecución del script actual
    exit();
}
// Si la sesión existe, el script que incluyó este archivo continuará ejecutándose.
?>
