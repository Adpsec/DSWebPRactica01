<?php
session_start();
// Establece la información de conexión a la base de datos
$dsn = "pgsql:host=172.17.0.2;port=5432;dbname=mydb;";
$username = "postgres";
$password = "postgres";

try {
    // Crea una instancia de PDO
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica si se ha enviado el formulario de inicio de sesión
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtiene los datos del formulario
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        // Consulta la base de datos para verificar las credenciales
        $stmt = $pdo->prepare("SELECT * FROM users WHERE usuario = :usuario");
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $contrasena === $user["contrasena"]) {
            // Las credenciales son válidas, redirige al usuario a index.php
            $_SESSION["loggedin"] = true;
            header("Location: index.php");
            exit();
        } else {
            // Las credenciales son incorrectas, muestra un mensaje de error
            $mensajeError = "Credenciales incorrectas";
        }
        
    }
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-5">
        <h2>Iniciar sesión</h2>
        <?php if (isset($mensajeError)) : ?>
            <p style="color: red;"><?php echo $mensajeError; ?></p>
        <?php endif; ?>
        <!-- Agrega el formulario con clases de Bootstrap -->
        <form method="post" class="col-md-4">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>
