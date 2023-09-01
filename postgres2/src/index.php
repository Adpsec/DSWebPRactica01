<html>
<body> 
<?php
phpinfo();
class CConexion {

    public static function ConexionBD(){
        $host = "172.17.0.2";
        $dbname = "test";
        $username = "postgres";
        $pasword = "postgres";

        try{
            $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $pasword);

            echo "Se conecto correctamente a la Base de Datos TEST";
        }
        catch(PDOException $exp){
            echo("No se pudo conectar a la bd, $exp");
        }
        return $conn;
    }

}

?>
</body>

</html>
