<?php
include 'conexion.php'; 

try {
    $query = "SELECT * FROM ejemplo"; 
    $stmt = $pdo->query($query);

    

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['clave']}</td>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td>{$row['direccion']}</td>";
        echo "<td>{$row['telefono']}</td>";
        echo "<td><a href='update.php?clave={$row['clave']}' class='btn btn-primary'>Editar</a></td>";
        echo "<td><a href='javascript:eliminarRegistro({$row['clave']})' class='btn btn-danger'>Eliminar</a></td>";

        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} catch (PDOException $e) {
    echo "Error al obtener datos de la base de datos: " . $e->getMessage();
}

?>
