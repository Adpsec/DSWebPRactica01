<?php
include 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave = $_POST['clave'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    $query = "INSERT INTO ejemplo (clave, nombre, direccion, telefono) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$clave, $nombre, $direccion, $telefono]);

    if ($result) {
        // El registro se insertó exitosamente
        $response = array("status" => "success", "message" => "Datos insertados exitosamente.");
    } else {
        // Hubo un error al insertar el registro
        $response = array("status" => "error", "message" => "Error al insertar datos en la base de datos.");
    }

    echo json_encode($response);
}
?>