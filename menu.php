<?php
// Obtener nombre del archivo para resaltar el link activo
$pagina = basename($_SERVER['PHP_SELF']);
?>

<div class="top-nav">
    <div class="logo">
        💻 MarketOS
    </div>

    <div class="menu-items">
        <a href="panel.php" class="<?php echo $pagina == 'panel.php' ? 'active' : '' ?>">📊 Panel</a>
        <a href="ver_ventas.php" class="<?php echo $pagina == 'ver_ventas.php' ? 'active' : '' ?>">💰 Ventas</a>
        <a href="ver_productos.php" class="<?php echo $pagina == 'ver_productos.php' ? 'active' : '' ?>">📦 Productos</a>
        
        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin') { ?>
            <a href="gestion_empleados.php" class="<?php echo $pagina == 'gestion_empleados.php' ? 'active' : '' ?>">👥 Empleados</a>
            <a href="reportes.php" class="<?php echo $pagina == 'reportes.php' ? 'active' : '' ?>">📄 Reportes</a>
        <?php } ?>
    </div>

    <div style="display: flex; align-items: center; gap: 15px;">
        <span style="color: #A0AEC0; font-size: 0.9em;">Hola, <?php echo $_SESSION['nombre']; ?></span>
        <a href="logout.php" class="logout-btn">Salir</a>
    </div>
</div>
