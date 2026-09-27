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
$tipo_vivienda = $_POST['tipo_vivienda'];

// Insertar datos
$sql = "INSERT INTO movilidad
(nombre, correo, celular, tipo_vivienda)
VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssss",
    $nombre,
    $correo,
    $celular,
    $tipo_vivienda
);

if ($stmt->execute()) {

    // Correo de notificación
    $destinatario = "comercial@duovolt.co";
    $asunto = "Lead Web - Tipo de Vivienda";

    $mensaje = "
Nueva solicitud recibida desde DuoVolt

Nombre: $nombre

Correo: $correo

Celular: $celular

Tipo de vivienda: $tipo_vivienda
";

    $headers = "From: admin@duovolt.co\r\n";
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