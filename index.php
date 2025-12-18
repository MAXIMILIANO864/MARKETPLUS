<?php
session_start();
if (isset($_SESSION['id_usuario'])) {
    header("Location: panel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MarketPlus</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

    <div class="login-wrapper">
        <div class="bg-image">
            <div class="capa-texto">
                <h2>Bienvenido a MarketPlus</h2>
                <p>Gestiona tu kiosco de manera inteligente.</p>
            </div>
        </div>

        <div class="form-section">
            <div class="login-container">
                <h2>Iniciar Sesión</h2>
                <p style="color: #666; margin-bottom: 30px;">Ingresa tus datos para continuar</p>

                <form action="login.php" method="POST">
                    <?php if (isset($_GET['error'])) { echo '<p class="error">Datos incorrectos</p>'; } ?>
                    
                    <label>Email</label>
                    <input type="email" name="email" placeholder="ejemplo@correo.com" required>
                    
                    <label>Contraseña</label>
                    <input type="password" name="contrasena" placeholder="********" required>
                    
                    <button type="submit">INGRESAR</button>
                </form>
                
                <p class="register-link">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>

</body>
</html>
