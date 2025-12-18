<?php
include 'conexion.php';

echo "<h1>🔧 Migrando Usuarios a Empleados...</h1>";

// 1. Buscamos TODOS los usuarios registrados
$sql_usuarios = "SELECT * FROM usuarios";
$res_usuarios = $conexion->query($sql_usuarios);

$contador = 0;

while ($usuario = $res_usuarios->fetch_assoc()) {
    $email = $usuario['email'];
    $nombre_completo = $usuario['nombre']; // En usuarios viejos, esto puede ser "Juan" o "Juan Perez"
    
    // 2. Verificamos si este email YA EXISTE en empleados
    $check = $conexion->query("SELECT id_empleado FROM empleados WHERE email = '$email'");
    
    if ($check->num_rows == 0) {
        // ¡NO EXISTE! Hay que crearlo.
        
        // Intentamos separar Nombre y Apellido (si están juntos)
        $partes = explode(" ", $nombre_completo, 2);
        $nombre = $partes[0];
        $apellido = isset($partes[1]) ? $partes[1] : "SinApellido"; // Si no tiene apellido, ponemos uno genérico
        
        // Insertamos en empleados
        // Asumimos que son 'Empleado' y de la sucursal 'Centro'
        $sql_insert = "INSERT INTO empleados (nombre, apellido, email, cargo, sucursal) 
                       VALUES ('$nombre', '$apellido', '$email', 'Empleado', 'Centro')";
        
        if ($conexion->query($sql_insert) === TRUE) {
            echo "<p style='color:green'>✅ Usuario <strong>$email</strong> convertido a Empleado.</p>";
            $contador++;
        } else {
            echo "<p style='color:red'>❌ Error con $email: " . $conexion->error . "</p>";
        }
    } else {
        echo "<p style='color:gray'>ℹ️ $email ya es empleado. Se omite.</p>";
    }
}

echo "<h2>🎉 Proceso terminado. Se crearon $contador empleados nuevos.</h2>";
echo "<a href='gestion_empleados.php' style='font-size:20px; font-weight:bold;'>🔙 Ver Lista de Empleados</a>";
?>
