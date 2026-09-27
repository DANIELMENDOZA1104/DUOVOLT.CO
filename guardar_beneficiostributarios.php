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
$marca = $_POST['marca'];
$fecha = $_POST['fecha'];

// Insertar datos
$sql = "INSERT INTO beneficiostributarios
(nombre, correo, celular, marca, fecha)
VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sssss",
    $nombre,
    $correo,
    $celular,
    $marca,
    $fecha
);

if ($stmt->execute()) {

    // Enviar correo
    $destinatario = "comercial@duovolt.co";
    $asunto = "Lead Web - Beneficios Tributarios";

    $mensaje = "
Nueva solicitud recibida desde DuoVolt

Nombre: $nombre

Correo: $correo

Celular: $celular

Marca del vehículo: $marca

Fecha estimada: $fecha
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