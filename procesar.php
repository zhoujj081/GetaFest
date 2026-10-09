<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$edad = isset($_POST['edad']) ? $_POST['edad'] : 0;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
$pago = isset($_POST['pago']) ? $_POST['pago'] : '';
$observaciones= isset($_POST['observaciones']) ? $_POST['observaciones'] : '';

$dias = array();
if (isset($_POST['dias'])) {
    $dias = $_POST['dias'];
}

include 'header.php';

if ($edad < 18) {
    echo "<div class='card'>";
    echo "<h2>Inscripción denegada</h2>";
    echo "<p>Lo sentimos <b>" . $nombre . "</b>, el evento GetaFest es exclusivo para mayores de 18 años.</p>";
    echo "<a href='index.php' class='btn'>Volver al formulario</a>";
    echo "</div>";
    echo "</main></body></html>";
    exit;
}

$rutaFoto = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $origen   = $_FILES['foto']['tmp_name'];
    $rutaFoto = 'imagenes/' . $_FILES['foto']['name'];
    if (!move_uploaded_file($origen, $rutaFoto)) {
        $rutaFoto = '';
    }
}

$precios = array("General" => 50, "VIP" => 120, "SuperVIP" => 180);
$precioBase = isset($precios[$tipo]) ? $precios[$tipo] : 0;
$suplemento = count($dias) * 10;
$precioTotal = $precioBase + $suplemento;
?>

<div class="card profile-card">
    <h2>🎫 Acreditación Virtual - Ticket</h2>

    <?php if ($rutaFoto != '') { ?>
        <img src="<?php echo $rutaFoto; ?>" alt="Foto del asistente" width="200">
    <?php } ?>

    <h3><?php echo $nombre; ?></h3>
    <p><b>Email:</b> <?php echo $correo; ?></p>
    <p><b>Tipo de pase:</b> <?php echo $tipo; ?></p>

    <p><b>Días de asistencia:</b></p>
    <ul>
        <?php foreach ($dias as $dia) { ?>
            <li><?php echo $dia; ?></li>
        <?php } ?>
    </ul>

    <p><b>Método de pago:</b> <?php echo $pago; ?></p>

    <?php if ($observaciones!= '') { ?>
        <p><b>Observaciones:</b> <?php echo $observaciones; ?></p>
    <?php } ?>

    <h3>Desglose del precio</h3>
    <p>Precio Base: <?php echo $precioBase; ?> €</p>
    <p>Suplemento por <?php echo count($dias); ?> día(s): <?php echo $suplemento; ?> €</p>
    <p><b>Precio Total a Pagar: <?php echo $precioTotal; ?> €</b></p>

    <a href="index.php" class="btn">Realizar otra reserva</a>
</div>

</main>
</body>
</html>