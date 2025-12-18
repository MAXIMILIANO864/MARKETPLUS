<?php
include 'proteger.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - MarketPlus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="dashboard-container">
        
        <div class="header-title">
            <h1>Hola, <?php echo $_SESSION['nombre']; ?></h1>
        </div>

        <div class="content">
            <h3>Bienvenido al sistema</h3>
            <p>Selecciona una opción del menú lateral para comenzar.</p>
        </div>

    </div>

</body>
</html>
