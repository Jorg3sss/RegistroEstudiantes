<?php
session_start();
include "../database/conexion.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $carrera = $_POST["carrera"];
    $semestre = $_POST["semestre"]; 
    $correo = $_POST["correo"];

    if (!isset($_GET["id"])) {
        die("Error: ID del estudiante no especificado para la modificación.");
    }
    $id = $_GET["id"]; 

    $stmt = $conn->prepare("SELECT id FROM estudiantes WHERE correo = ? AND id != ?");
    $stmt->bind_param("si",$correo, $id);  
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if($resultado->num_rows>0){
         echo "Error: El correo electrónico **" . $correo . "** ya está registrado por otro estudiante.";
         echo "<a href='ver_estudiantes.php'>Ver lista de estudiantes</a>";
         echo "<a href='../index.html'>Volver al registro</a><br>";
         $stmt->close();
         $resultado->close();
         exit();

        }
        

  
    $stmt = $conn->prepare("UPDATE estudiantes SET nombre = ?, carrera = ?, semestre = ?, correo = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $nombre, $carrera, $semestre, $correo, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
             echo "<h2>Estudiante con ID {$id} modificado correctamente.</h2>";
        } else {
             echo "<h2>Advertencia: Estudiante con ID {$id} no modificado. Posiblemente los datos son idénticos o el ID no existe.</h2>";
        }
        
        echo "<a href='ver_estudiantes.php'>Ver lista de estudiantes</a>";
        echo "<a href='../index.html'>Volver al registro</a><br>";
    } else {
        echo "Error al modificar el estudiante: " . $stmt->error;
    }
    
    $stmt->close();

} else {
    echo "Acceso no válido. Utiliza el formulario de modificación.";
    echo "<a href='../index.html'>Volver al registro</a><br>";
}
?>