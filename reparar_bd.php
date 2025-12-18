<?php
include 'conexion.php';

echo "<h1>🔧 Reparando Base de Datos...</h1>";

// 1. Intentar agregar la columna APELLIDO si no existe
$sql1 = "ALTER TABLE empleados ADD COLUMN apellido VARCHAR(100) AFTER nombre";
if ($conexion->query($sql1) === TRUE) {
    echo "<p style='color:green'>✅ Columna 'apellido' agregada correctamente.</p>";
} else {
    // Si falla es porque ya existe o hay otro error
    echo "<p style='color:orange'>⚠️ Aviso sobre 'apellido': " . $conexion->error . "</p>";
}

// 2. Intentar agregar la columna CARGO si no existe
$sql2 = "ALTER TABLE empleados ADD COLUMN cargo VARCHAR(100) AFTER email";
if ($conexion->query($sql2) === TRUE) {
    echo "<p style='color:green'>✅ Columna 'cargo' agregada correctamente.</p>";
} else {
    echo "<p style='color:orange'>⚠️ Aviso sobre 'cargo': " . $conexion->error . "</p>";
}

echo "<h3>🎉 ¡Listo! Ahora tu base de datos acepta Apellidos y Cargos.</h3>";
echo "<a href='agregar_empleado.php'>Ir a Agregar Empleado</a>";
?>
