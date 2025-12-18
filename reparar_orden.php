<?php
include 'conexion.php';

echo "<h1>🔧 Ajustando el contador...</h1>";

// 1. Buscamos cuál es el número más alto actual (Debería ser 12, el de Lucas)
$consulta = $conexion->query("SELECT MAX(id_empleado) as max_id FROM empleados");
$fila = $consulta->fetch_assoc();
$ultimo_id = $fila['max_id'];

echo "<p>El último empleado (Lucas) es el ID: <strong>$ultimo_id</strong></p>";

// 2. Calculamos el siguiente (12 + 1 = 13)
$siguiente_id = $ultimo_id + 1;

// 3. Forzamos a la base de datos a usar ese número
$sql = "ALTER TABLE empleados AUTO_INCREMENT = $siguiente_id";

if ($conexion->query($sql) === TRUE) {
    echo "<h2 style='color:green'>✅ ¡LISTO!</h2>";
    echo "<p>La base de datos ha sido corregida.</p>";
    echo "<p>El próximo empleado que registres será el número: <strong style='font-size:20px'>$siguiente_id</strong></p>";
} else {
    echo "<p style='color:red'>❌ Error: " . $conexion->error . "</p>";
}

echo "<br><a href='gestion_empleados.php'>Volver a Gestión de Empleados</a>";
?>
