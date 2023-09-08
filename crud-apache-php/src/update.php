<?php
include 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clave = $_POST['clave'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    try {
        $query = "UPDATE ejemplo SET nombre = :nombre, direccion = :direccion, telefono = :telefono WHERE clave = :clave";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':clave', $clave);
        $stmt->execute();

        echo "<script>alert('Registro actualizado correctamente.'); window.location.href='index.html';</script>";
        exit(); 
    } catch (PDOException $e) {
        echo "Error al actualizar los datos: " . $e->getMessage();
    }
} else {
   
    $clave = $_GET['clave'];

    try {
        // Obtener los datos actuales de la base de datos para mostrar en el formulario
        $query = "SELECT * FROM ejemplo WHERE clave = :clave";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':clave', $clave);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los datos de la base de datos: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Formulario de edición -->
        <div class="card">
            <div class="card-header">
                Editar Registro
            </div>
            <div class="card-body">
                <form action="update.php" method="POST">
                    <input type="hidden" name="clave" value="<?php echo $row['clave']; ?>">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Direccion:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $row['direccion']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Telefono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $row['telefono']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

