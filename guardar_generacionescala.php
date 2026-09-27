<?php

$servername = "localhost";
$username = "duovpzgt_Admin";
$password = "";
$dbname = "duovpzgt_clientes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$celular = $_POST['celular'];
$ubicacion = $_POST['ubicacion'];
$area = $_POST['area'];
$sql = "INSERT INTO generacionescala
(nombre, correo, celular, ubicacion, area)
VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sssss",
    $nombre,
    $correo,
    $celular,
    $ubicacion,
    $area
);

if ($stmt->execute()) {

    $destinatario = "admin@duovolt.co";
    $asunto = "Lead Web - Generacion a gran escala";

    $mensaje = "
Nueva solicitud recibida desde DuoVolt

Nombre: $nombre

Correo: $correo

Celular: $celular

Ubicación: $ubicacion

Área: $area
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