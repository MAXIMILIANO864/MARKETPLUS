<?php
session_start();
include 'conexion.php'; // Incluye tu archivo de conexión

// Verificar que la conexión se estableció (la variable $conexion existe)
if (!$conexion) {
    die("Error crítico: No se pudo conectar a la base de datos.");
}

// Recibir datos del formulario
$email = $_POST['email'];
$contrasena = $_POST['contrasena'];

if (empty($email) || empty($contrasena)) {
    header("Location: index.php?error=1");
    exit();
}

// --- Consulta Preparada (para evitar Inyección SQL) ---
// La consulta busca un usuario con el email y la contraseña proporcionados
// ADVERTENCIA: Se compara la contraseña en texto plano, coincidiendo con tu DB.
$sql = "SELECT * FROM usuarios WHERE email = ? AND contrasena = ?";

$stmt = $conexion->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $conexion->error);
}

// "ss" significa que estamos pasando dos variables de tipo String
$stmt->bind_param("ss", $email, $contrasena);

// Ejecutar la consulta
$stmt->execute();

// Obtener el resultado
$resultado = $stmt->get_result();

// Comprobar si se encontró un usuario
if ($resultado->num_rows == 1) {
    // Usuario encontrado
    $usuario = $resultado->fetch_assoc();

    // Guardar datos del usuario en la sesión
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['rol'] = $usuario['rol'];

    // Redirigir al panel de control
    header("Location: panel.php");
    exit();

} else {
    // Usuario no encontrado o credenciales incorrectas
    header("Location: index.php?error=1");
    exit();
}

// Cerrar statement y conexión
$stmt->close();
$conexion->close();
?>
