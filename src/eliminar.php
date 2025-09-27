<?php
session_start();
include "../database/conexion.php";


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_estudiante = $_GET['id'];

    
    $stmt = $conn->prepare("DELETE FROM estudiantes WHERE id = ?");
    $stmt->bind_param("i", $id_estudiante);

    if ($stmt->execute()) {
        
        header("Location: ver_estudiantes.php");
        exit();
    } else {
        echo "Error al eliminar el estudiante: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID de estudiante no válido.";
}

$conn->close();
?>
