<?php

//Definición de parametros de BD
$host = "172.17.0.2"; 
$port = "5432"; 
$dbname = "mydb"; 
$user = "postgres"; 
$password = "postgres";

//Definición de conexión a BD Postgres
try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $clave = $_POST['clave'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];

        $query = "INSERT INTO ejemplo (clave, nombre, direccion) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$clave, $nombre, $direccion]);

        echo "Datos insertados exitosamente.";
    }
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>

