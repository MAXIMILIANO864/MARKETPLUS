<?php
include 'conexion.php';

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$contrasena = $_POST['contrasena']; 

// 1. VERIFICAR SI YA EXISTE EL CORREO (Evitar duplicados)
$check = $conexion->query("SELECT * FROM usuarios WHERE email = '$email'");
if ($check->num_rows > 0) {
    header("Location: registro.php?error=existe");
    exit();
}

// 2. CREAR EL USUARIO (Para poder iniciar sesión)
// Unimos nombre y apellido para el campo nombre de usuario
$nombre_completo = $nombre . " " . $apellido;
$rol_defecto = "empleado";

$sql_usuario = "INSERT INTO usuarios (nombre, email, contrasena, rol) 
                VALUES ('$nombre_completo', '$email', '$contrasena', '$rol_defecto')";

if ($conexion->query($sql_usuario) === TRUE) {
    
    // 3. CREAR EL EMPLEADO (¡ESTO ES LO QUE FALTABA!)
    // Al mismo tiempo, creamos la ficha de empleado para que pueda vender.
    // Lo ponemos por defecto en sucursal "Centro" y cargo "Empleado".
    
    $sql_empleado = "INSERT INTO empleados (nombre, apellido, email, cargo, sucursal) 
                     VALUES ('$nombre', '$apellido', '$email', 'Empleado', 'Centro')";
    
    if ($conexion->query($sql_empleado) === TRUE) {
        // ¡Éxito total!
        echo "<script>
                alert('¡Cuenta creada! Ya eres usuario y empleado habilitado para vender.');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Se creó el usuario pero falló al crear empleado: " . $conexion->error;
    }

} else {
    echo "Error al registrar usuario: " . $conexion->error;
}
?>
