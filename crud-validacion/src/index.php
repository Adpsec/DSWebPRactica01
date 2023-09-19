
<!DOCTYPE html>
<html>
<head>
    <title>CRUD PHP - Insertar Datos</title>
    <meta charset="UTF-8">
    <!-- Agrega los enlaces a los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<h1>



</h1>

    <div class="container mt-5">
        <h1>Insertar Datos</h1>

        <form id="formularioxd" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <fieldset style="background-color: antiquewhite;"> <legend>personas</legend> 
            <div class="form-group">
                <label for="clave">Clave:</label>
                <input type="number" class="form-control" id="clave" name="clave">
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion">
            </div>

            <div class="form-group">
                <label for="telefono">Telefono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
            </div>
           
            <div class="form-group">
                <label for="crud">Dato de referencia:</label>
                <input type="text" class="form-control" id="crud" name="crud">
            </div>

        <p>   <input name="enviar" type="submit" class="btn btn-primary" id="enviar" value="Enviar"></input>  <input  name="elimina" type="submit" class="btn btn-primary" id="elimina" value="elimina"></input> 
            <input name="mostrar" type="submit" class="btn btn-primary" id="mostrar" value="mostrar"></input> <input name="actualiza" type="submit" class="btn btn-primary" id="actualiza" value="actualiza" ></input>  </p> 
           <script>
         document.addEventListener("DOMContentLoaded",function(){
    document.getElementById("formularioxd").addEventListener('submit',validarFormulario);
});

function validarFormulario(evento){
    evento.preventDefault();
    var usuario = document.getElementById('nombre').value;
    if(usuario.length ==0){
        alert('no has escrito nada en el usuario');
        return;
    }

    var clave = document.getElementById('clave').value;

    if(clave.length == 0){ 
        alert('la clave no es valida');
        return;
    }

    if(clave == 0){ 
        alert('no se puede insertar 0 como clave, vuelva a intentar');
        return;
    }    
    
    var telefono = document.getElementById('telefono').value;

    
    if(isNaN(telefono)){
        alert('no has ingresado un valor numerico ');
        return;
    }

    var direccion = document.getElementById('direccion').value;
    if(direccion.length ==0){
        alert('no has escrito nada en la direccion');
        return;
    }

    this.submit();
}
         
        </script>
        </fieldset>
        <?php

//Definición de parametros de BD
$host = "localhost"; 
$port = "5432"; 
$dbname = "mydb"; 
$user = "myuser"; 
$password = "gitachi131";

$envio = $_POST['enviar'];
$eliminar = $_POST['elimina'];
$modificar = $_POST['actualiza'];
$mostrar = $_POST['mostrar'];

$eliminar2= $_POST['eliminar2'];


if($mostrar != null ){
    echo $mostrar."-lo quieres es".$mostrar; ver($host,$port,$dbname,$user,$password); unset($mostrar); echo "ya se borro";
    
}
elseif($eliminar !=null){
    echo $eliminar."lo que quieres es eliminar"; eliminar($host,$port,$dbname,$user,$password);  unset($eliminar); 
}
elseif($modificar != null){
    echo $modificar."lo que quieres es modificar"; modificar($host,$port,$dbname,$user,$password);  unset($modificar);

}
elseif($envio != null){
   echo  $enviar."lo que quieres es enviar"; guardar($host,$port,$dbname,$user,$password);  unset($enviar);
}

if($eliminar2 !=null)
   
echo $eliminar2."lo que quieres es eliminar en tabla flojo"; eliminar2($host,$port,$dbname,$user,$password);  unset($eliminar2); 

{}
 

function guardar($host,$port,$dbname,$user,$password){
    try {
    
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $clave = $_POST['clave'];
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $query = "INSERT INTO ejemplo (clave, nombre, direccion ,telefono) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$clave, $nombre, $direccion, $telefono]);
            echo "<script>alert('Registro actualizado correctamente.'); window.location.href='index.php';</script>";
            echo "Datos insertados exitosamente.";
        }
    } catch (PDOException $e) {
        echo "Error al conectar a la base de datos: " . $e->getMessage();
    }
    }


function eliminar($host,$port,$dbname,$user,$password){

if (isset($_POST['clave'])) {
    $clave = $_POST['clave'];

        
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $query = "DELETE FROM ejemplo WHERE clave = ?";
        $stmt = $pdo->prepare($query);
   
        $stmt->execute([$clave]);
        echo "<script>alert('Registro eliminado correctamente.'); window.location.href='index.php';</script>";
    
    } catch (PDOException $e) {
        echo "Error al eliminar el registro: " . $e->getMessage();
    }
} else {
    echo "ID de registro no proporcionado.";
}

}

function eliminar2($host,$port,$dbname,$user,$password){

    if (isset($_POST['clave2'])) {
        $clave2 = $_POST['clave2'];
    
            
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        try {
            $query = "DELETE FROM ejemplo WHERE clave = ?";
            $stmt = $pdo->prepare($query);
       
            $stmt->execute([$clave2]);
            echo "<script>alert('Registro eliminado correctamente.'); window.location.href='index.php';</script>";
        
        } catch (PDOException $e) {
            echo "Error al eliminar el registro: " . $e->getMessage();
        }
    } else {
        echo "ID de registro no proporcionado.";
    }
    
    }
    





function modificar($host,$port,$dbname,$user,$password){

    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

        echo "<script>alert('Registro actualizado correctamente.'); window.location.href='index.php';</script>";
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
}

function ver($host,$port,$dbname,$user,$password){
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    try {
        $query = "SELECT * FROM ejemplo"; 
        $stmt = $pdo->query($query);
    
        
       
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo" <table class='table t able-striped' >
                <thead>
                    <tr>
                        <th> Clave</th>
                        <th> Nombre</th>
                        <th> Direccion</th>
                        <th>telefono</th>
                    </tr>
                </thead>
";
            echo "<tr>";

            echo "<td>{$row['clave']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['direccion']}</td>";
            echo "<td>{$row['telefono']}</td>";

 
            echo "<td><input  type text id='clave2' name='clave2' value='";echo $row['clave'];

            echo $_POST['clave'];
            echo"'> </input>
            
            <input  name='elimina2' type='submit' class='btn btn-primary' id='elimina2' value='elimina2'>
            </input> 
            

                   </td>";
       
            
            echo "</tr>";
          
            
        }
    
        echo "</tbody>";
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error al obtener datos de la base de datos: " . $e->getMessage();
    }
    
}

?>


        </br>
           

        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<?php 

$host = "localhost"; 
$port = "5432"; 
$dbname = "mydb"; 
$user = "myuser"; 
$password = "gitachi131";

$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



try {
    $query = "SELECT * FROM ejemplo"; 
    $stmt = $pdo->query($query);

    
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo" <table class='table t able-striped' >
            <thead>
                <tr>
                    <th> Clave</th>
                    <th> Nombre</th>
                    <th> Direccion</th>
                    <th>telefono</th>
                </tr>
            </thead>
";
        echo "<tr>";

        echo "<td>{$row['clave']}</td>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td>{$row['direccion']}</td>";
        echo "<td>{$row['telefono']}</td>
        ";
       
    
        echo "<td><input  type text id='clave2' name='clave2' value='";echo $row['clave'];

        echo $_POST['clave'];
        echo"'> 
        
        <form me
        </input>
        
        <input  name='elimina2' type='submit' class='btn btn-primary' id='elimina2' value='elimina2'>
        </input> 
        

               </td>";
   
        
        echo "</tr>";
      
        
    }

    echo "</tbody>";
    echo "</table>";
} catch (PDOException $e) {
    echo "Error al obtener datos de la base de datos: " . $e->getMessage();
}

?>
</form>
</html>
