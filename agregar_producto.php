<?php
include 'proteger.php';
include 'conexion.php';

if ($_SESSION['rol'] != 'admin') die("Acceso denegado.");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="dashboard-container">
        <div class="content" style="max-width: 500px; margin: 0 auto;">
            
            <h2 style="color: #4338ca;">📦 Nuevo Producto</h2>

            <form action="guardar_producto.php" method="POST">
                
                <label>Nombre del Producto:</label>
                <input type="text" name="descripcion" required placeholder="Ej: Alfajor Triple">

                <label>Precio de Venta ($):</label>
                <input type="number" name="precio" step="0.01" required placeholder="Ej: 1500.00">

                <label>Stock Inicial:</label>
                <input type="number" name="stock" required placeholder="Ej: 50">

                <label>Sucursal:</label>
                <select name="sucursal" required>
                    <option value="Centro">Sucursal Centro</option>
                    <option value="Norte">Sucursal Norte</option>
                </select>

                <br>
                <button type="submit" class="btn-main" style="width:100%; background-color: #4338ca;">Guardar Producto</button>
                
                <a href="ver_productos.php" style="display:block; text-align:center; margin-top:15px; color:#666;">Cancelar</a>

            </form>
        </div>
    </div>

</body>
</html>
