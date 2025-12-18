<?php
include 'proteger.php';
include 'conexion.php';

// --- PASO CRÍTICO: IDENTIFICAR AL VENDEDOR ---
$nombre_usuario = $_SESSION['nombre']; // Ej: "Juan Perez"
$id_vendedor_actual = 0;
$nombre_vendedor_mostrar = "Desconocido";

// 1. Intentamos buscar uniendo Nombre + Espacio + Apellido
$sql_buscar = "SELECT id_empleado, nombre, apellido 
               FROM empleados 
               WHERE CONCAT(nombre, ' ', apellido) LIKE '%$nombre_usuario%' 
               OR nombre LIKE '%$nombre_usuario%'";

// 2. Si por casualidad tienes el email en la sesión, úsalo (es más seguro)
if (isset($_SESSION['email'])) {
    $email_user = $_SESSION['email'];
    $sql_buscar .= " OR email = '$email_user'";
}

$sql_buscar .= " LIMIT 1"; // Solo queremos uno

$res_vendedor = $conexion->query($sql_buscar);

if ($res_vendedor && $res_vendedor->num_rows > 0) {
    $fila_vendedor = $res_vendedor->fetch_assoc();
    $id_vendedor_actual = $fila_vendedor['id_empleado'];
    $nombre_vendedor_mostrar = $fila_vendedor['nombre'] . " " . $fila_vendedor['apellido'];
} else {
    // Si falla, mostramos alerta roja
    $nombre_vendedor_mostrar = "ERROR: No encontrado. Usuario: " . $nombre_usuario;
}

// --- PROCESAR FORMULARIO ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_cliente = $_POST['cliente'];
    $id_producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $id_empleado = $id_vendedor_actual; // Usamos el ID detectado

    if ($id_empleado == 0) {
        echo "<script>alert('⛔ ERROR: El sistema no reconoce tu usuario como empleado. Asegúrate de que tu nombre en el Login coincida con el de la lista de Empleados.');</script>";
    } else {
        // Validar Stock
        $consulta_stock = $conexion->query("SELECT stock, precio FROM producto WHERE id_producto = '$id_producto'");
        
        if ($consulta_stock->num_rows > 0) {
            $producto = $consulta_stock->fetch_assoc();

            if ($producto['stock'] < $cantidad) {
                echo "<script>alert('⚠️ Stock insuficiente para realizar esta venta.');</script>";
            } else {
                // Guardar Venta
                $fecha = date('Y-m-d');
                $sql_venta = "INSERT INTO numero_venta (fecha, id_clientes, id_empleados) VALUES ('$fecha', '$id_cliente', '$id_empleado')";

                if ($conexion->query($sql_venta) === TRUE) {
                    $id_venta_generada = $conexion->insert_id;
                    $conexion->query("INSERT INTO ventas (id_venta, id_producto, cantidad) VALUES ('$id_venta_generada', '$id_producto', '$cantidad')");
                    $conexion->query("UPDATE producto SET stock = stock - $cantidad WHERE id_producto = '$id_producto'");

                    echo "<script>alert('✅ ¡Venta registrada con éxito!'); window.location.href = 'ver_ventas.php';</script>";
                } else {
                    echo "<script>alert('Error SQL: " . $conexion->error . "');</script>";
                }
            }
        }
    }
}

// Cargar listas para el formulario
$productos = $conexion->query("SELECT * FROM producto WHERE stock > 0");
$clientes = $conexion->query("SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Venta - MarketOS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="main-content">
        <div class="content" style="max-width: 500px; margin: 0 auto;">
            
            <h2 style="color: var(--secondary-color);">🛒 Registrar Venta</h2>

            <form action="" method="POST">

                <label>Vendedor (Tú):</label>
                <input type="text" value="<?php echo $nombre_vendedor_mostrar; ?>" readonly 
                       style="background-color: rgba(255,255,255,0.05); color: #ccc; cursor: not-allowed; font-weight:bold;">
                
                <?php if ($id_vendedor_actual == 0) { ?>
                    <div style="background: #7f1d1d; color: #fca5a5; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9em;">
                        <strong>⚠️ Problema de Identidad:</strong><br>
                        El sistema no encuentra un empleado llamado "<?php echo $nombre_usuario; ?>".<br>
                        <a href="gestion_empleados.php" style="color:white; text-decoration:underline;">Ir a Gestión de Empleados</a> y verifica que existas ahí.
                    </div>
                <?php } ?>

                <label>Cliente:</label>
                <select name="cliente" required>
                    <option value="">-- Seleccionar Cliente --</option>
                    <?php while ($c = $clientes->fetch_assoc()) { ?>
                        <option value="<?php echo $c['id_cliente']; ?>">
                            <?php echo $c['nombre'] . ' ' . $c['apellido']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label>Producto:</label>
                <select name="producto" required>
                    <option value="">-- Seleccionar Producto --</option>
                    <?php while ($p = $productos->fetch_assoc()) { ?>
                        <option value="<?php echo $p['id_producto']; ?>">
                            <?php echo $p['descripcion']; ?> ($<?php echo $p['precio']; ?>) - Stock: <?php echo $p['stock']; ?>
                        </option>
                    <?php } ?>
                </select>
                
                <label>Cantidad:</label>
                <input type="number" name="cantidad" value="1" min="1" required>

                <br>
                <button type="submit" class="btn-main" style="width:100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color:white;">
                    ✅ Confirmar Venta
                </button>
                <a href="ver_ventas.php" style="display:block; text-align:center; margin-top:15px; color: var(--text-muted);">Cancelar</a>
            </form>
        </div>
    </div>

</body>
</html>
