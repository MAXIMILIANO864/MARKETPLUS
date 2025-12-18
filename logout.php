<?php
// Iniciar la sesión para poder acceder a ella
session_start();

// Eliminar todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario al formulario de inicio de sesión (index.php)
header("Location: index.php");
exit();
?>
