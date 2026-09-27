<?php

$claveCorrecta = "DuoVolt2026";

if (
    !isset($_POST['clave']) ||
    $_POST['clave'] !== $claveCorrecta
){
    die("Contraseña incorrecta");
}

$servername = "localhost";
$username   = "duovpzgt_Admin";
$password   = "TU_PASSWORD";
$dbname     = "duovpzgt_clientes";

$conn = new mysqli(
    $servername,
    $username,
    $password,
    $dbname
);

if ($conn->connect_error){
    die("Error de conexión");
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Leads_DuoVolt.csv');

$output = fopen('php://output', 'w');

/* ENERGIA SOLAR */

fputcsv($output, ['ENERGIA SOLAR']);
fputcsv($output, [
    'ID',
    'Nombre',
    'Correo',
    'Celular',
    'Ciudad',
    'Tipo Proyecto',
    'Consumo',
    'Fecha Registro'
]);

$result = $conn->query(
    "SELECT * FROM energiasolar"
);

while($row = $result->fetch_assoc()){
    fputcsv($output, $row);
}

fputcsv($output, []);
fputcsv($output, []);

/* MOVILIDAD */

fputcsv($output, ['MOVILIDAD ELECTRICA']);
fputcsv($output, [
    'ID',
    'Nombre',
    'Correo',
    'Celular',
    'Tipo Vivienda',
    'Fecha Registro'
]);

$result = $conn->query(
    "SELECT * FROM movilidad"
);

while($row = $result->fetch_assoc()){
    fputcsv($output, $row);
}

fputcsv($output, []);
fputcsv($output, []);

/* BENEFICIOS TRIBUTARIOS */

fputcsv($output, ['BENEFICIOS TRIBUTARIOS']);
fputcsv($output, [
    'ID',
    'Nombre',
    'Correo',
    'Celular',
    'Marca',
    'Fecha Factura',
    'Fecha Registro'
]);

$result = $conn->query(
    "SELECT * FROM beneficiostributarios"
);

while($row = $result->fetch_assoc()){
    fputcsv($output, $row);
}

fputcsv($output, []);
fputcsv($output, []);

/* GENERACION A GRAN ESCALA */

fputcsv($output, ['GENERACION A GRAN ESCALA']);
fputcsv($output, [
    'ID',
    'Nombre',
    'Correo',
    'Celular',
    'Ubicacion',
    'Area'
]);

$result = $conn->query(
    "SELECT * FROM generacionescala"
);

while($row = $result->fetch_assoc()){
    fputcsv($output, $row);
}

fclose($output);

$conn->close();

exit;
?>