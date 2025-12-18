<?php
include 'proteger.php';
include 'conexion.php';

if ($_SESSION['rol'] != 'admin') {
    die("Acceso denegado.");
}

// Recibir datos del formulario de 'anadir_venta.php'
$id_cliente = $_POST['cliente'];
$id_empleado = $_POST['empleado'];
$id_producto = $_POST['producto'];
$cantidad_solicitada = 1; // Por ahora asumimos que vende de a 1 unidad, luego podemos poner un input para cantidad

// 1. VERIFICAR SI HAY STOCK SUFICIENTE
$consulta_stock = $conexion->query("SELECT stock, precio FROM producto WHERE id_producto = '$id_producto'");
$producto = $consulta_stock->fetch_assoc();

if ($producto['stock'] < $cantidad_solicitada) {
    // Si no hay stock, detenemos todo y mostramos error
    echo "<script>
            alert('¡ERROR! No hay stock suficiente de este producto.');
            window.location.href = 'anadir_venta.php';
          </script>";
    exit();
}

// 2. CREAR EL REGISTRO DE VENTA (Cabecera)
// Insertamos en la tabla 'numero_venta'
$fecha = date('Y-m-d');
$sql_venta = "INSERT INTO numero_venta (fecha, id_clientes, id_empleados) VALUES ('$fecha', '$id_cliente', '$id_empleado')";

if ($conexion->query($sql_venta) === TRUE) {
    $id_venta_generada = $conexion->insert_id; // Obtenemos el ID de la venta recién creada

    // 3. INSERTAR EL DETALLE DE LA VENTA
    // Insertamos en la tabla 'ventas'
    $sql_detalle = "INSERT INTO ventas (id_venta, id_producto, cantidad) VALUES ('$id_venta_generada', '$id_producto', '$cantidad_solicitada')";
    $conexion->query($sql_detalle);

    // 4. DESCONTAR EL STOCK (LA MAGIA)
    $sql_update = "UPDATE producto SET stock = stock - $cantidad_solicitada WHERE id_producto = '$id_producto'";
    $conexion->query($sql_update);

    // Redirigir con éxito
    echo "<script>
            alert('¡Venta registrada correctamente!');
            window.location.href = 'ver_ventas.php';
          </script>";

} else {
    echo "Error al registrar la venta: " . $conexion->error;
}
?>
