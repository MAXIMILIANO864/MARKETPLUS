<?php
include 'conexion.php';
echo "<h1>🔧 Creando Tabla de Historial de Reportes...</h1>";

$sql = "CREATE TABLE IF NOT EXISTS reportes_guardados (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    fecha_generacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_ventas DECIMAL(10,2) NOT NULL,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
)";

if ($conexion->query($sql) === TRUE) {
    echo "<h2 style='color:green'>✅ Tabla 'reportes_guardados' creada con éxito.</h2>";
    echo "<a href='reportes.php'>Ir a Reportes</a>";
} else {
    echo "<h2 style='color:red'>❌ Error: " . $conexion->error . "</h2>";
}
?>
