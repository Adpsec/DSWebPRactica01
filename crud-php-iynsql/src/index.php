<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])) {
    // Destruye la sesión actual
    session_destroy();

    // Redirige al usuario a login.php
    header("location: login.php");
    exit;
}

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


        echo $_POST['clave'];
        echo $_POST['name'];
        echo $_POST['direccion'];
        echo $_POST['telefono'];
        echo "------ </br>";

        $clave = purificar($_POST['clave']);
        $nombre = purificar($_POST['name']);
        $direccion = purificar($_POST['direccion']);
        $telefono = purificar($_POST['telefono']);



        echo $clave . "-" . $nombre . "-" . $direccion . "-" . $telefono;

        $parameters = [
            ':clave' => $clave,
            ':nombre' => $nombre,
            ':direccion' => $direccion,
            ':telefono' => $telefono
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
        $claveActualizar = purificar($_POST['clave']);
        $nombreActualizar = purificar($_POST['name']);
        $direccionActualizar = purificar($_POST['direccion']);
        $telefonoActualizar = purificar($_POST['telefono']);

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

<?php


function purificar($source)
{
    $sane = "";

    $forbidden_chars = array(
        "?",
        "[",
        "]",
        "/",
        "\\",
        "=",
        "<",
        ">",
        ":",
        ";",
        ",",
        "'",
        "\"",
        "&",
        "$",
        "#",
        "*",
        "(",
        ")",
        "|",
        "~",
        "`",
        "!",
        "{",
        "}",
        "%",
        "+",
        chr(0)
    );
    $replace_chars = array(
        'áéíóúäëïöüàèìòùñ ',
        'aeiouaeiouaeioun_'
    );

    for ($i = 0; $i < strlen($source); $i++) {
        $sane_char = $source_char = $source[$i];
        if (in_array($source_char, $forbidden_chars)) {
            $sane_char = " ";
            $sane .= $sane_char;
            continue;
        }
        $pos = strpos($replace_chars[0], $source_char);
        if ($pos !== false) {
            $sane_char = $replace_chars[1][$pos];
            $sane .= $sane_char;
            continue;
        }
        if (ord($source_char) < 32 || ord($source_char) > 128) {
            // Todos los caracteres codificados por debajo de 32 o encima de 128 son especiales
// Ver http://www.asciitable.com/
            $sane_char = " ";
            $sane .= $sane_char;
            continue;
        }
        // Si ha pasado todos los controles, aceptamos el carácter
        $sane .= $sane_char;
    }


    return $sane;
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
    <div class="container mt-5">
        <h2>Bienvenido a la página de inicio</h2>
        <p>Hola,
            <?php echo $_SESSION["usuario"]; ?>.
        </p>
        <form method="post">
            <button type="submit" name="logout" class="btn btn-danger">Cerrar sesión</button>
        </form>
    </div>
    <form class="container mt-5" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
        onsubmit="return validarFormulario();">
        <div class="form-group">
            <label for="clave">Clave:</label>
            <input type="number" class="form-control" name="clave" id="clave" pattern="[0-9]+" required
                value="<?php echo isset($_POST['clave']) ? htmlspecialchars($_POST['clave']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" name="name" id="name" pattern="[A-Za-z]{1,25}"
                title="no puedes inyectar sql perro" required
                value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" name="direccion" id="direccion" pattern="[A-Za-z0-9\s]{1,25}"
                required value="<?php echo isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" name="telefono" id="telefono" pattern="[0-9]{10}"
                title="no intentes inyecciones sql amigo" required
                value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
        </div>

        <input type="submit" class="btn btn-primary" name="submit" value="Enviar Formulario">
        <input type="submit" class="btn btn-primary" name="actualizar" value="Actualizar Registro">
    </form>
    <form class="container mt-5" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
        onsubmit="return validarFormulario();">




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