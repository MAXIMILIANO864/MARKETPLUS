<?php
include 'proteger.php';
include 'conexion.php';

if ($_SESSION['rol'] != 'admin') die("Acceso denegado.");

// --- AUTO-REPARACIÓN BASE DE DATOS (EMPLEADOS) ---
// Verificamos si existe la columna 'sucursal'. Si no, la creamos.
$check = $conexion->query("SHOW COLUMNS FROM empleados LIKE 'sucursal'");
if ($check->num_rows == 0) {
    $conexion->query("ALTER TABLE empleados ADD sucursal VARCHAR(100) DEFAULT 'Centro' AFTER cargo");
}
// ------------------------------------------------

// --- LÓGICA DE GUARDADO ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $cargo = $_POST['cargo'];
    $sucursal = $_POST['sucursal']; // Nuevo campo
    $id_gerente = $_POST['id_gerente'];

    $valor_gerente = ($id_gerente == "NULL") ? "NULL" : "'$id_gerente'";

    // Insertamos incluyendo la sucursal
    $sql = "INSERT INTO empleados (nombre, apellido, email, cargo, sucursal, id_gerente) 
            VALUES ('$nombre', '$apellido', '$email', '$cargo', '$sucursal', $valor_gerente)";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>
            alert('¡Empleado registrado correctamente en sucursal $sucursal!');
            window.location.href = 'gestion_empleados.php'; 
            </script>";
    } else {
        echo "<div style='background:red; color:white; padding:10px; text-align:center;'>ERROR SQL: " . $conexion->error . "</div>";
    }
}

// Obtener lista de gerentes
$gerentes = $conexion->query("SELECT id_empleado, nombre, apellido FROM empleados");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Empleado</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="dashboard-container">
        <div class="content" style="max-width: 500px; margin: 0 auto;">
            
            <h2 style="color: #2563eb;">👤 Nuevo Empleado</h2>
            
            <form action="" method="POST">
                
                <label>Nombre:</label>
                <input type="text" name="nombre" required placeholder="Ej: Laura">

                <label>Apellido:</label>
                <input type="text" name="apellido" required placeholder="Ej: Martínez">

                <label>Email Corporativo:</label>
                <input type="email" name="email" required placeholder="laura@marketplus.com">

                <div style="display:flex; gap:10px;">
                    <div style="flex:1;">
                        <label>Cargo:</label>
                        <select name="cargo" required>
                            <option value="Empleado">Empleado</option>
                            <option value="Gerente">Gerente</option>
                        </select>
                    </div>
                    <div style="flex:1;">
                        <label>Sucursal:</label>
                        <select name="sucursal" required>
                            <option value="Centro">📍 Centro</option>
                            <option value="Norte">📍 Norte</option>
                        </select>
                    </div>
                </div>

                <label>¿Quién es su Jefe Directo?</label>
                <select name="id_gerente">
                    <option value="NULL">-- Sin Jefe / Es Gerente General --</option>
                    <?php while ($g = $gerentes->fetch_assoc()) { ?>
                        <option value="<?php echo $g['id_empleado']; ?>">
                            <?php echo $g['nombre'] . " " . $g['apellido']; ?>
                        </option>
                    <?php } ?>
                </select>

                <br>
                <button type="submit" class="btn-main" style="width:100%; background-color: #2563eb;">Guardar Empleado</button>
                
                <a href="gestion_empleados.php" style="display:block; text-align:center; margin-top:15px; color:#666;">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>
