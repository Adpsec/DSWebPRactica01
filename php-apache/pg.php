<?php
$host = "172.17.0.2"; // Cambia esto al nombre o dirección IP de tu servidor PostgreSQL
$port = "5433"; // Cambia esto al puerto en el que PostgreSQL está escuchando (por lo general es 5432)
$dbname = "ejemplo"; // Cambia esto al nombre de tu base de datos
$user = "postgres"; // Cambia esto al nombre de usuario de PostgreSQL
$password = "postgres"; // Cambia esto a la contraseña del usuario

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos PostgreSQL.";
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
