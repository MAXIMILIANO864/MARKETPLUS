<?php
include 'proteger.php';
include 'conexion.php';

if ($_SESSION['rol'] != 'admin') die("Acceso denegado.");

// --- AUTO-REPARACIÓN DE BASE DE DATOS (CRÍTICO) ---
// Verificamos si la columna 'sucursal' existe en la tabla empleados.
// Si no existe, la creamos AHORA MISMO para evitar el error.
$check = $conexion->query("SHOW COLUMNS FROM empleados LIKE 'sucursal'");
if ($check->num_rows == 0) {
    // Creamos la columna y la ponemos después de 'cargo'
    $conexion->query("ALTER TABLE empleados ADD sucursal VARCHAR(100) DEFAULT 'Centro' AFTER cargo");
}
// --------------------------------------------------

// Ahora sí, hacemos la consulta (ya es seguro porque la columna existe)
$sql = "SELECT e.id_empleado, e.nombre, e.apellido, e.email, e.cargo, e.sucursal, 
               g.nombre AS nombre_gerente, g.apellido AS apellido_gerente 
        FROM empleados e 
        LEFT JOIN empleados g ON e.id_gerente = g.id_empleado 
        ORDER BY e.id_empleado";

$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Personal</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .btn-add-emp {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white; padding: 12px 25px; text-decoration: none; border-radius: 50px; font-weight: bold;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4); display: inline-flex; align-items: center; gap: 8px;
        }
        .action-link { text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 4px; font-size: 0.9em; }
        .edit { color: #d97706; background: #fef3c7; }
        .delete { color: #dc2626; background: #fee2e2; }
        
        /* Etiquetas de estilo */
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.85em; display: inline-block; }
        .badge-sucursal { background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; }
        .badge-cargo { background: #e0f2fe; color: #0369a1; }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<div class="dashboard-container">
    <div class="header-title" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h1>Gestión de Personal</h1>
        <a href="agregar_empleado.php" class="btn-add-emp"><span>👤+</span> Nuevo Empleado</a>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Datos Laborales</th>
                    <th>Email</th>
                    <th>Reporta a</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $fila['id_empleado']; ?></td>
                    
                    <td><strong><?php echo $fila['nombre'] . " " . $fila['apellido']; ?></strong></td>
                    
                    <td>
                        <span class="badge badge-cargo"><?php echo $fila['cargo']; ?></span>
                        <span class="badge badge-sucursal">📍 <?php echo $fila['sucursal'] ? $fila['sucursal'] : 'Centro'; ?></span>
                    </td>
                    
                    <td><?php echo $fila['email']; ?></td>
                    
                    <td><?php echo $fila['nombre_gerente'] ? $fila['nombre_gerente']." ".$fila['apellido_gerente'] : 'Nadie'; ?></td>
                    
                    <td>
                        <a href="editar_empleado.php?id=<?php echo $fila['id_empleado']; ?>" class="action-link edit">✏️</a>
                        <a href="borrar_empleado.php?id=<?php echo $fila['id_empleado']; ?>" class="action-link delete" onclick="return confirm('¿Eliminar?')">🗑️</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
