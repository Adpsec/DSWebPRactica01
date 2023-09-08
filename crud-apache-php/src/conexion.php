

<?php
$host = "172.17.0.2";
$port = "5432";
$dbname = "mydb";
$user = "postgres";
$password = "postgres";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new Exception("Error al conectar a la base de datos: " . $e->getMessage());
}
?>