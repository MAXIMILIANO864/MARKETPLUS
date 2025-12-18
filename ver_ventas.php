<?php
include 'proteger.php';
include 'conexion.php';

$rol = $_SESSION['rol'];
$nombre_usuario = $_SESSION['nombre'];

// Consulta (Misma lógica, solo visualización cambia)
$sql = "SELECT 
            nv.fecha,
            CONCAT(c.nombre, ' ', c.apellido) AS cliente,
            e.nombre AS empleado,
            p.descripcion AS producto,
            v.cantidad,
            p.precio,
            (v.cantidad * p.precio) AS total
        FROM numero_venta nv
        JOIN ventas v ON nv.id_numero_venta = v.id_venta
        JOIN clientes c ON nv.id_clientes = c.id_cliente
        JOIN empleados e ON nv.id_empleados = e.id_empleado
        JOIN producto p ON v.id_producto = p.id_producto";

if ($rol != 'admin') {
    $sql .= " WHERE e.nombre LIKE '%$nombre_usuario%' ";
}

$sql .= " ORDER BY nv.fecha DESC";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas - MarketOS</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos exclusivos para embellecer la tabla de ventas */
        .table-wrapper {
            overflow-x: auto; /* Para que no rompa en pantallas pequeñas */
        }
        
        /* Alineaciones específicas para datos financieros */
        th.text-right, td.text-right { text-align: right; }
        th.text-center, td.text-center { text-align: center; }

        /* Etiquetas de estilo tecnológico */
        .tag-user {
            background-color: rgba(74, 144, 226, 0.15);
            color: #4A90E2;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 600;
            border: 1px solid rgba(74, 144, 226, 0.3);
        }

        .tag-total {
            color: #50E3C2; /* Verde Tech */
            font-weight: bold;
            font-size: 1.1em;
            text-shadow: 0 0 10px rgba(80, 227, 194, 0.3);
        }

        .date-style {
            color: #A0AEC0;
            font-size: 0.9em;
            font-family: monospace; /* Fuente tipo código */
        }
        
        /* Iconos pequeños en texto */
        .icon-small { margin-right: 5px; opacity: 0.7; }
    </style>
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="main-content">
        
        <div class="header-title" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>Historial de Ventas</h1>
                <p style="color: var(--text-muted); font-size: 0.9em;">Transacciones registradas en el sistema.</p>
            </div>
            
            <?php if ($rol == 'admin' || true) { // Habilitado para todos por ahora ?>
            <a href="anadir_venta.php" class="btn-main" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4); color: white;">
    🛒 Nueva Venta
</a>
            </a>
            <?php } ?>
        </div>

        <div class="content">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>📅 Fecha</th>
                            <th>👤 Cliente</th>
                            <th>📦 Producto</th>
                            <th>🆔 Vendedor</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-right">Precio Unit.</th>
                            <th class="text-right">💰 Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($resultado && $resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) { ?>
                            <tr>
                                <td><span class="date-style"><?php echo date("d/m/Y", strtotime($row['fecha'])); ?></span></td>
                                
                                <td style="font-weight: 500;"><?php echo $row['cliente']; ?></td>
                                
                                <td style="color: var(--text-color); opacity: 0.9;"><?php echo $row['producto']; ?></td>
                                
                                <td><span class="tag-user"><?php echo $row['empleado']; ?></span></td>
                                
                                <td class="text-center" style="font-weight: bold;"><?php echo $row['cantidad']; ?></td>
                                
                                <td class="text-right" style="color: var(--text-muted);">$<?php echo number_format($row['precio'], 2); ?></td>
                                
                                <td class="text-right tag-total">$<?php echo number_format($row['total'], 2); ?></td>
                            </tr>
                            <?php } 
                        } else {
                            echo "<tr><td colspan='7' style='text-align:center; padding:40px; color: var(--text-muted); font-style: italic;'>No se encontraron registros de ventas.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>
