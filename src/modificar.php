<?php
session_start();
include "../database/conexion.php";

if(isset($_GET["id"])){
    $id = $_GET["id"];
    $stmt = $conn->prepare("SELECT * FROM estudiantes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();
    
    if($resultado->num_rows === 1){
        $estudiante = $resultado->fetch_assoc();

        
        echo "<form action='mod.php?id=" . $id . "' method='POST'>";
        echo "<input type='text' id='nombre' name='nombre' value='" . $estudiante['nombre'] . "' placeholder='Nombre' required><br>";
        echo "<input type='text' id='carrera' name='carrera' value='" . $estudiante['carrera'] . "' placeholder='carrera' required><br>";
        echo "<input type='text' id='semestre' name='semestre' value='" . $estudiante['semestre'] . "' placeholder='semestre' required><br>";
        echo "<input type='text' id='correo' name='correo' value='" . $estudiante['correo'] . "' placeholder='correo' required><br>";
        echo "<button type='submit' class='btn btn-registrar'>Registrar</button>";
        echo "</form>";
        
        $stmt->close();

    }

    else{
        echo "Estudiante no encontrado";
        echo "<a href='../index.html'>Volver al registro</a><br>";
        $stmt->close();
    }



}
?>