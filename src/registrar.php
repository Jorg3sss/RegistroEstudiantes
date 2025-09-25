<?php
session_start(); 
include "../database/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $carrera = $_POST["carrera"];
    $semestre = $_POST["semestre"];
    $correo = $_POST["correo"];

    if (!empty($nombre) && !empty($carrera) && !empty($semestre) && !empty($correo)) {
        
        $stmt = $conn->prepare("SELECT * FROM estudiantes WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            echo "<h2>Error: el correo '{$correo}' ya ha sido registrado, prueba con otro.</h2>";
            echo "<a href='../index.html'>Volver al registro</a><br>";
            $stmt->close();
            $conn->close();
            exit(); 
        }

        else{
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO estudiantes (nombre, carrera, semestre, correo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $nombre, $carrera, $semestre, $correo);
            

            if ($stmt->execute()) {
                echo "<h2>Estudiante registrado correctamente.</h2>";
                echo "<a href='../index.html'>Volver al registro</a><br>";
                echo "<a href='ver_estudiantes.php'>Ver lista de estudiantes</a>";
            } else {
                echo "Error al registrar: " . $stmt->error;
            }
            $stmt->close();
        }

        
    } else {
        echo "Todos los campos son obligatorios.";
    }
    $conn->close();
}
?>
