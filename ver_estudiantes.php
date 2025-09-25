<?php
include "conexio.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $nombre   = $_POST["nombre"];
    $carrera  = $_POST["carrera"];
    $semestre = $_POST["semestre"];
    $correo   = $_POST["correo"];

    
    if (!empty($nombre) && !empty($carrera) && !empty($semestre) && !empty($correo)) {

        
        $stmt = $conn->prepare("INSERT INTO estudiantes (nombre, carrera, semestre, correo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nombre, $carrera, $semestre, $correo); 

        if ($stmt->execute()) {
            echo "<h2>Estudiante registrado correctamente.</h2>";
            echo "<a href='index.html'>Volver al registro</a><br>";
            echo "<a href='ver_estudiantes.php'>Ver lista de estudiantes</a>";
        } else {
            echo "Error al registrar: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();

    } else {
        echo "Todos los campos son obligatorios.";
    }

} else {
    echo "No se enviaron datos desde el formulario.";
}
?>
