<?php
include "conexio.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $carrera = $_POST["carrera"];
    $semestre = $_POST["semestre"];
    $correo = $_POST["correo"];

    if (!empty($nombre) && !empty($carrera) && !empty($semestre) && !empty($correo)) {
        $sql = "INSERT INTO estudiantes (nombre, carrera, semestre, correo) 
                VALUES ('$nombre', '$carrera', '$semestre', '$correo')";

        if ($conn->query($sql) === TRUE) {
            echo "<h2>Estudiante registrado correctamente.</h2>";
            echo "<a href='index.html'>Volver al registro</a><br>";
            echo "<a href='ver_estudiantes.php'>Ver lista de estudiantes</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>
