<?php
session_start();

try {
    $dsn = "pgsql:host=172.17.0.2;port=5432;dbname=mydb;";
    $username = "postgres";
    $password = "postgres";

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['submit'])) {
        
        $query = "INSERT INTO ejemplo(clave, nombre, direccion, telefono)
                  VALUES(:clave, :nombre, :direccion, :telefono)";

        $statement = $pdo->prepare($query);

        $parameters = [
            ':clave' => $_POST['clave'],
            ':nombre' => $_POST['name'],
            ':direccion' => $_POST['direccion'],
            ':telefono' => $_POST['telefono']
        ];

        $result = $statement->execute($parameters);

        if ($result) {
            echo "Se registró con éxito";

            $_POST['clave'] = '';
            $_POST['name'] = '';
            $_POST['direccion'] = '';
            $_POST['telefono'] = '';
        } else {
            echo "Error en la consulta.";
        }
    }

    if (isset($_GET['eliminar'])) {
        
        $claveEliminar = $_GET['eliminar'];

        if (is_numeric($claveEliminar)) {
            $query = "DELETE FROM ejemplo WHERE clave = :clave";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':clave', $claveEliminar, PDO::PARAM_INT);
            $result = $statement->execute();

            if ($result) {
                echo "Se eliminó el registro con clave: $claveEliminar";
            } else {
                echo "Error al eliminar el registro.";
            }
        } else {
            echo "Clave no válida.";
        }
    }

    if (isset($_POST['actualizar'])) {
        // Obtén los datos del formulario de edición
        $claveActualizar = $_POST['clave'];
        $nombreActualizar = $_POST['name'];
        $direccionActualizar = $_POST['direccion'];
        $telefonoActualizar = $_POST['telefono'];
    
        // Ejecuta una consulta SQL UPDATE para actualizar el registro
        $query = "UPDATE ejemplo SET nombre = :nombre, direccion = :direccion, telefono = :telefono WHERE clave = :clave";
        $statement = $pdo->prepare($query);
        $parameters = [
            ':clave' => $claveActualizar,
            ':nombre' => $nombreActualizar,
            ':direccion' => $direccionActualizar,
            ':telefono' => $telefonoActualizar
        ];
    
        $result = $statement->execute($parameters);
    
        if ($result) {
            echo "Se actualizó el registro con clave: $claveActualizar";
            // Puedes limpiar los campos del formulario de edición aquí si lo deseas
        } else {
            echo "Error al actualizar el registro.";
        }
    }
    

    
    $consulta = "SELECT * FROM ejemplo";
    $stmt = $pdo->query($consulta);
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    $pdo = null;
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crud PHP </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<form class="container mt-5" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validarFormulario();">
        <div class="form-group">
            <label for="clave">Clave:</label>
            <input type="number" class="form-control" name="clave" id="clave" required value="<?php echo isset($_POST['clave']) ? htmlspecialchars($_POST['clave']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" name="name" id="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" name="direccion" id="direccion" required value="<?php echo isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" name="telefono" id="telefono" required value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
        </div>

        <input type="submit" class="btn btn-primary" name="submit" value="Enviar Formulario">
        <input type="submit" class="btn btn-primary" name="actualizar" value="Actualizar Registro">
    </form>
    <form class="container mt-5" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validarFormulario();">
    

    

</body>
</html>







    <?php
    if (!empty($registros)) {
        echo "Tabla:<br>";
        echo "<table border='1'>";
        echo "<tr><th>Clave</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Acciones</th></tr>";
        foreach ($registros as $index => $registro) {
            echo "<td>{$registro['clave']}</td>";
        echo "<td>{$registro['nombre']}</td>";
        echo "<td>{$registro['direccion']}</td>";
        echo "<td>{$registro['telefono']}</td>";
        echo "<td><a href=\"javascript:void(0);\" onclick=\"confirmarEliminar('{$registro['clave']}');\" class='btn btn-danger'>Eliminar</a></td>";
        echo "<td><a href=\"javascript:void(0);\" onclick=\"consultarRegistro('{$registro['clave']}');\" class='btn btn-primary'>Editar</a></td>";

        echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Sin datos a mostrar.";
    }
    ?>

    <script>
    function consultarRegistro(clave) {
    <?php
    if (!empty($registros)) {
        echo "var registros = " . json_encode($registros) . ";\n";
        echo "for (var i = 0; i < registros.length; i++) {\n";
        echo "if (registros[i].clave == clave) {\n";
        echo "document.getElementsByName('clave')[0].value = registros[i].clave;\n";
        echo "document.getElementsByName('name')[0].value = registros[i].nombre;\n";
        echo "document.getElementsByName('direccion')[0].value = registros[i].direccion;\n";
        echo "document.getElementsByName('telefono')[0].value = registros[i].telefono;\n";
        echo "}\n";
        echo "}\n";
    }
    ?>
}

    function confirmarEliminar(clave) {
        var confirmacion = confirm("¿Quieres eliminar el registro?");

        if (confirmacion) {
            window.location.href = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?eliminar=" + clave;
        } else {
            
        }
    }
    function validarFormulario() {
        var clave = document.getElementById("clave").value;
        var nombre = document.getElementById("name").value;
        var direccion = document.getElementById("direccion").value;
        var telefono = document.getElementById("telefono").value;

        if (clave === "" || nombre === "" || direccion === "" || telefono === "") {
            alert("Completa todos los campos.");
            return false; 
        }
        return true; 
    }
    </script>
</body>
</html>



