<?php
include 'conexion.php';

if (isset($_GET['clave'])) {
    $clave = $_GET['clave'];

    try {
        $query = "DELETE FROM ejemplo WHERE clave = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$clave]);

        
        echo "<script>alert('Registro eliminado correctamente.'); window.location.href='index.html';</script>";
    } catch (PDOException $e) {
        echo "Error al eliminar el registro: " . $e->getMessage();
    }
} else {
    echo "ID de registro no proporcionado.";
}
?>