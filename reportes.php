<?php
include 'proteger.php';
include 'conexion.php';

if ($_SESSION['rol'] != 'admin') {
    header("Location: panel.php");
    exit();
}

// --- AUTO-REPARACIÓN ---
$check = $conexion->query("SHOW COLUMNS FROM reportes_guardados LIKE 'mejor_cliente'");
if ($check->num_rows == 0) {
    $conexion->query("ALTER TABLE reportes_guardados ADD mejor_cliente VARCHAR(150) DEFAULT 'N/A'");
    $conexion->query("ALTER TABLE reportes_guardados ADD mejor_empleado VARCHAR(150) DEFAULT 'N/A'");
    $conexion->query("ALTER TABLE reportes_guardados ADD producto_estrella VARCHAR(150) DEFAULT 'N/A'");
}

// --- GUARDAR REPORTE ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inicio = $_POST['fecha_inicio'];
    $fin = $_POST['fecha_fin'];
    $id_usuario = $_SESSION['id_usuario'];

    // 1. Calcular Total
    $sql_total = "SELECT SUM(v.cantidad * p.precio) as total FROM numero_venta nv JOIN ventas v ON nv.id_numero_venta = v.id_venta JOIN producto p ON v.id_producto = p.id_producto WHERE nv.fecha BETWEEN '$inicio' AND '$fin'";
    $res_total = $conexion->query($sql_total)->fetch_assoc();
    $total_dinero = $res_total['total'] ? $res_total['total'] : 0;

    // 2. Estadísticas
    $res_cli = $conexion->query("SELECT CONCAT(c.nombre, ' ', c.apellido) as n, SUM(v.cantidad*p.precio) as g FROM numero_venta nv JOIN ventas v ON nv.id_numero_venta=v.id_venta JOIN producto p ON v.id_producto=p.id_producto JOIN clientes c ON nv.id_clientes=c.id_cliente WHERE nv.fecha BETWEEN '$inicio' AND '$fin' GROUP BY c.id_cliente ORDER BY g DESC LIMIT 1")->fetch_assoc();
    $mejor_cliente = ($res_cli) ? $res_cli['n'] : "N/A";

    $res_emp = $conexion->query("SELECT e.nombre as n, SUM(v.cantidad*p.precio) as venta FROM numero_venta nv JOIN ventas v ON nv.id_numero_venta=v.id_venta JOIN producto p ON v.id_producto=p.id_producto JOIN empleados e ON nv.id_empleados=e.id_empleado WHERE nv.fecha BETWEEN '$inicio' AND '$fin' GROUP BY e.id_empleado ORDER BY venta DESC LIMIT 1")->fetch_assoc();
    $mejor_empleado = ($res_emp) ? $res_emp['n'] : "N/A";

    $res_prod = $conexion->query("SELECT p.descripcion as d, SUM(v.cantidad) as c FROM numero_venta nv JOIN ventas v ON nv.id_numero_venta=v.id_venta JOIN producto p ON v.id_producto=p.id_producto WHERE nv.fecha BETWEEN '$inicio' AND '$fin' GROUP BY p.id_producto ORDER BY c DESC LIMIT 1")->fetch_assoc();
    $producto_estrella = ($res_prod) ? $res_prod['d'] : "N/A";

    // 3. Guardar
    $sql_insert = "INSERT INTO reportes_guardados (fecha_inicio, fecha_fin, total_ventas, mejor_cliente, mejor_empleado, producto_estrella, id_usuario) VALUES ('$inicio', '$fin', '$total_dinero', '$mejor_cliente', '$mejor_empleado', '$producto_estrella', '$id_usuario')";
    
    if ($conexion->query($sql_insert) === TRUE) {
        echo "<script>window.location.href='reportes.php';</script>";
    }
}

// --- LEER HISTORIAL ---
$sql_historial = "SELECT r.*, u.nombre as generador FROM reportes_guardados r JOIN usuarios u ON r.id_usuario = u.id_usuario ORDER BY r.fecha_generacion DESC";
$historial = $conexion->query($sql_historial);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes - MarketOS</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .stat-badge { font-size: 0.85em; padding: 4px 8px; border-radius: 6px; display: block; margin-bottom: 4px; }
        .stat-client { background: rgba(255, 206, 86, 0.2); color: #f59e0b; border: 1px solid #f59e0b; }
        .stat-emp { background: rgba(54, 162, 235, 0.2); color: #3b82f6; border: 1px solid #3b82f6; }
        .stat-prod { background: rgba(255, 99, 132, 0.2); color: #ef4444; border: 1px solid #ef4444; }
        
        /* Botón de Borrar */
        .btn-delete {
            background-color: rgba(239, 68, 68, 0.1); 
            color: #ef4444; 
            border: 1px solid #ef4444;
            padding: 8px 12px; 
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-delete:hover { background-color: #ef4444; color: white; }
    </style>
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="main-content">
        <div class="header-title"><h1>Analíticas y Reportes</h1></div>

        <div class="content" style="margin-bottom: 30px;">
            <h2 style="color: var(--secondary-color); margin-bottom: 20px;">📊 Generar Reporte Avanzado</h2>
            <form action="" method="POST" style="flex-direction: row; align-items: flex-end; gap: 20px;">
                <div style="flex: 1;"><label>Desde:</label><input type="date" name="fecha_inicio" required></div>
                <div style="flex: 1;"><label>Hasta:</label><input type="date" name="fecha_fin" value="<?php echo date('Y-m-d'); ?>" required></div>
                <div style="flex: 1;"><button type="submit" class="btn-main" style="width: 100%;">🚀 Procesar Datos</button></div>
            </form>
        </div>

        <div class="content">
            <h3 style="margin-bottom: 20px;">📂 Archivo de Reportes</h3>
            <table>
                <thead>
                    <tr>
                        <th>Período</th>
                        <th>Resumen Destacado</th>
                        <th style="text-align: right;">Ingresos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $historial->fetch_assoc()) { ?>
                    <tr>
                        <td>
                            <div style="font-weight:bold;"><?php echo date("d/m/Y", strtotime($fila['fecha_inicio'])); ?></div>
                            <div style="font-weight:bold;"><?php echo date("d/m/Y", strtotime($fila['fecha_fin'])); ?></div>
                            <div style="font-size:0.8em; color:var(--text-muted); margin-top:5px;">Por: <?php echo $fila['generador']; ?></div>
                        </td>
                        
                        <td>
                            <span class="stat-badge stat-client">👑 Cli: <?php echo $fila['mejor_cliente']; ?></span>
                            <span class="stat-badge stat-emp">💼 Vend: <?php echo $fila['mejor_empleado']; ?></span>
                            <span class="stat-badge stat-prod">📦 Prod: <?php echo $fila['producto_estrella']; ?></span>
                        </td>

                        <td style="text-align: right; font-size: 1.2em; font-weight: bold; color: var(--secondary-color);">
                            $<?php echo number_format($fila['total_ventas'], 2); ?>
                        </td>
                        
                        <td style="display: flex; gap: 10px;">
                            <a href="generar_pdf_ventas.php?id=<?php echo $fila['id_reporte']; ?>" target="_blank" class="btn-main" style="padding: 8px 12px; font-size: 0.9em; background: #fff; color: #333; border: 1px solid #ccc;">📄 PDF</a>
                            
                            <a href="borrar_reporte.php?id=<?php echo $fila['id_reporte']; ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de borrar este reporte del historial?');">
                                🗑️
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
