<?php
include 'proteger.php';
include 'conexion.php';

if ($_SESSION['rol'] != 'admin') die("Acceso denegado.");

if (!isset($_GET['id'])) header("Location: gestion_empleados.php");
$id = $_GET['id'];

// Datos del empleado a editar
$empleado = $conexion->query("SELECT * FROM empleados WHERE id_empleado = '$id'")->fetch_assoc();

// Lista de posibles jefes
$gerentes = $conexion->query("SELECT id_empleado, nombre, apellido FROM empleados WHERE id_empleado != '$id'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="dashboard-container">
        <div class="content" style="max-width: 500px; margin: 0 auto;">
            <h2>✏️ Editar Datos</h2>
            
            <form action="actualizar_empleado.php" method="POST">
                <input type="hidden" name="id_empleado" value="<?php echo $empleado['id_empleado']; ?>">

                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $empleado['nombre']; ?>" required>

                <label>Apellido:</label>
                <input type="text" name="apellido" value="<?php echo $empleado['apellido']; ?>" required>

                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $empleado['email']; ?>" required>

                <label>Cargo:</label>
                <select name="cargo" required>
                    <option value="Empleado" <?php if($empleado['cargo'] == 'Empleado') echo 'selected'; ?>>Empleado</option>
                    <option value="Gerente" <?php if($empleado['cargo'] == 'Gerente') echo 'selected'; ?>>Gerente</option>
                </select>

                <label>Jefe Directo:</label>
                <select name="id_gerente">
                    <option value="NULL">-- Sin Jefe --</option>
                    <?php while ($g = $gerentes->fetch_assoc()) { 
                        $selected = ($g['id_empleado'] == $empleado['id_gerente']) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $g['id_empleado']; ?>" <?php echo $selected; ?>>
                            <?php echo $g['nombre'] . " " . $g['apellido']; ?>
                        </option>
                    <?php } ?>
                </select>

                <br>
                <button type="submit" class="btn-main" style="width:100%; background:#d97706;">Actualizar Datos</button>
            </form>
        </div>
    </div>
</body>
</html>
