<?php
include 'proteger.php';
include 'conexion.php';

// Auto-reparación (por si acaso falta la columna sucursal)
$check = $conexion->query("SHOW COLUMNS FROM producto LIKE 'sucursal'");
if ($check->num_rows == 0) {
    $conexion->query("ALTER TABLE producto ADD sucursal VARCHAR(100) DEFAULT 'Centro'");
}

$resultado = $conexion->query("SELECT * FROM producto ORDER BY stock ASC"); // Ordenado por stock (los que faltan primero)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - MarketOS</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos específicos para la tabla de productos */
        .stock-badge {
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 0.85em;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
        .stock-ok { background: rgba(80, 227, 194, 0.15); color: var(--secondary-color); border: 1px solid rgba(80, 227, 194, 0.3); }
        .stock-low { background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); animation: pulse 2s infinite; }
        
        .price-tag {
            color: #a78bfa; /* Violeta claro */
            font-weight: bold;
            font-family: monospace;
            font-size: 1.1em;
        }

        /* Input chiquito para agregar stock */
        .input-mini {
            width: 60px !important;
            padding: 6px !important;
            text-align: center;
            background: #1f2937;
            border: 1px solid #374151;
            color: white;
            border-radius: 4px;
        }

        .btn-icon-only {
            padding: 6px 10px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-icon-only:hover { opacity: 0.8; }

        @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.7; } 100% { opacity: 1; } }
    </style>
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="main-content">
        
        <div class="header-title" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>Gestión de Inventario</h1>
                <p style="color: var(--text-muted); font-size: 0.9em;">Control de stock y precios en tiempo real.</p>
            </div>
            
            <?php if ($_SESSION['rol'] == 'admin') { ?>
                <a href="agregar_producto.php" class="btn-main" style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);">
                    📦 Nuevo Producto
                </a>
            <?php } ?>
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Sucursal</th>
                        <th style="text-align: right;">Precio Unit.</th>
                        <th style="text-align: center;">Estado de Stock</th>
                        <?php if ($_SESSION['rol'] == 'admin') { ?>
                            <th style="text-align: center;">Acciones Rápidas</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($p = $resultado->fetch_assoc()) { 
                        // Lógica visual para el stock
                        $es_critico = ($p['stock'] <= 5);
                        $clase_stock = $es_critico ? 'stock-low' : 'stock-ok';
                        $icono_stock = $es_critico ? '⚠️' : '✅';
                    ?>
                        <tr>
                            <td>
                                <div style="font-weight:bold; font-size:1.05em;"><?php echo $p['descripcion']; ?></div>
                                <div style="font-size:0.8em; color: var(--text-muted);">ID: #<?php echo $p['id_producto']; ?></div>
                            </td>
                            
                            <td><?php echo isset($p['sucursal']) ? $p['sucursal'] : 'Centro'; ?></td>
                            
                            <td style="text-align: right;">
                                <span class="price-tag">$<?php echo number_format($p['precio'], 2); ?></span>
                            </td>
                            
                            <td style="text-align: center;">
                                <span class="stock-badge <?php echo $clase_stock; ?>">
                                    <?php echo $icono_stock . " " . $p['stock']; ?> un.
                                </span>
                            </td>

                            <?php if ($_SESSION['rol'] == 'admin') { ?>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                    
                                    <form action="actualizar_stock.php" method="POST" style="display: flex; gap: 5px; margin: 0;">
                                        <input type="hidden" name="id_producto" value="<?php echo $p['id_producto']; ?>">
                                        <input type="number" name="cantidad" class="input-mini" placeholder="+1" min="1" required>
                                        <button type="submit" class="btn-icon-only" title="Sumar Stock">➕</button>
                                    </form>

                                    <a href="editar_producto.php?id=<?php echo $p['id_producto']; ?>" 
                                       style="background: #f59e0b; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none; font-size: 0.9em;" 
                                       title="Editar Producto">
                                        ✏️
                                    </a>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
