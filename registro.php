<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - MarketOS</title>
    <link rel="stylesheet" href="style.css"> <style>
        /* Ajustes para que se vea bien con el estilo nuevo */
        body { display: block; } 
        .login-wrapper { display: flex; min-height: 100vh; background-color: #1A202C; }
        .bg-image { flex: 1; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; position: relative; }
        .form-section { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; }
        .login-container { background-color: #2D3748; padding: 40px; border-radius: 10px; width: 100%; max-width: 450px; border: 1px solid #4A5568; color: white; }
        input { background: #1A202C; color: white; border: 1px solid #4A5568; margin-bottom: 15px; }
        h2 { color: #4A90E2; margin-bottom: 10px; }
        p { color: #A0AEC0; margin-bottom: 20px; }
        a { color: #50E3C2; }
    </style>
</head>
<body>

    <div class="login-wrapper">
        
        <div class="bg-image" style="background-image: url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1932&auto=format&fit=crop');">
            <div style="position: absolute; background: rgba(0,0,0,0.7); padding: 20px; border-radius: 10px; text-align: center;">
                <h2 style="color: white;">Únete al Equipo</h2>
                <p style="color: #ddd;">Gestiona ventas y stock de forma inteligente.</p>
            </div>
        </div>

        <div class="form-section">
            <div class="login-container">
                <h2>Crear Cuenta Nueva</h2>
                <p>Ingresa tus datos para registrarte como empleado.</p>

                <form action="guardar_registro.php" method="POST">
                    
                    <?php
                    if (isset($_GET['error'])) {
                        echo '<p style="color: #ef4444; background: rgba(239,68,68,0.1); padding: 10px; border-radius: 5px;">⚠️ Ese correo ya está registrado.</p>';
                    }
                    ?>

                    <label>Nombre</label>
                    <input type="text" name="nombre" placeholder="Ej: Juan" required>

                    <label>Apellido</label> <input type="text" name="apellido" placeholder="Ej: Pérez" required>

                    <label>Email</label>
                    <input type="email" name="email" placeholder="juan@correo.com" required>
                    
                    <label>Contraseña</label>
                    <input type="password" name="contrasena" placeholder="Crea una contraseña segura" required>
                    
                    <button type="submit" class="btn-main" style="width: 100%; margin-top: 10px;">REGISTRARSE</button>
                </form>
                
                <div style="text-align: center; margin-top: 20px;">
                    ¿Ya tienes cuenta? <a href="index.php">Inicia Sesión aquí</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
