<?php

$servername = "localhost";
$username = "duovpzgt_Admin";
$password = "";
$dbname = "duovpzgt_clientes";

// Conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$celular = $_POST['celular'];
$ciudad = $_POST['ciudad'];
$tipo_proyecto = $_POST['tipo_proyecto'];
$consumo = $_POST['consumo'];

// Insertar datos
$sql = "INSERT INTO energiasolar
(nombre, correo, celular, ciudad, tipo_proyecto, consumo)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssss",
    $nombre,
    $correo,
    $celular,
    $ciudad,
    $tipo_proyecto,
    $consumo
);

if ($stmt->execute()) {

    // Enviar correo
    $destinatario = "admin@duovolt.co";
    $asunto = "Lead Web - Energía Solar";

    $mensaje = "
Nueva solicitud recibida desde DuoVolt

Nombre: $nombre

Correo: $correo

Celular: $celular

Ciudad: $ciudad

Tipo de proyecto: $tipo_proyecto

Consumo mensual: $consumo
";

    $headers = "From: comercial@duovolt.co\r\n";
    $headers .= "Reply-To: $correo\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    mail($destinatario, $asunto, $mensaje, $headers);

    header("Location: gracias.html");
    exit();

} else {

    echo "Error al guardar: " . $stmt->error;

}

$stmt->close();
$conn->close();

?>