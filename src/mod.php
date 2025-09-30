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
    
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Resultado de Modificación</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f4f6f9;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .container {
                background: #fff;
                padding: 25px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                width: 100%;
                max-width: 500px;
                text-align: center;
            }
            h2 {
                color: #333;
                margin-bottom: 20px;
            }
            .error {
                color: #d9534f;
            }
            .success {
                color: #28a745;
            }
            a {
                display: inline-block;
                margin: 10px 5px;
                text-decoration: none;
                color: #fff;
                background: #007BFF;
                padding: 10px 15px;
                border-radius: 6px;
                transition: background 0.3s;
            }
            a:hover {
                background: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="container">
    <?php

    if($resultado->num_rows > 0){
        echo "<h2 class='error'>Error: El correo <b>" . $correo . "</b> ya está registrado por otro estudiante.</h2>";
        echo "<a href='ver_estudiantes.php'>Ver lista de estudiantes</a>";
        echo "<a href='../index.html'>Volver al registro</a>";
        $stmt->close();
        $resultado->close();
        exit();
    }
        
    $stmt = $conn->prepare("UPDATE estudiantes SET nombre = ?, carrera = ?, semestre = ?, correo = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $nombre, $carrera, $semestre, $correo, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
             echo "<h2 class='success'>Estudiante con ID {$id} modificado correctamente.</h2>";
        } else {
             echo "<h2 class='error'>Advertencia: Estudiante con ID {$id} no modificado. Posiblemente los datos son idénticos o el ID no existe.</h2>";
        }
        
        echo "<a href='ver_estudiantes.php'>Ver lista de estudiantes</a>";
        echo "<a href='../index.html'>Volver al registro</a>";
    } else {
        echo "<h2 class='error'>Error al modificar el estudiante: " . $stmt->error . "</h2>";
    }
    
    $stmt->close();
    ?>
        </div>
    </body>
    </html>
    <?php

} else {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Error de acceso</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f4f6f9;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .container {
                background: #fff;
                padding: 25px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                text-align: center;
            }
            h2 {
                color: #d9534f;
            }
            a {
                display: inline-block;
                margin-top: 15px;
                text-decoration: none;
                color: #fff;
                background: #007BFF;
                padding: 10px 15px;
                border-radius: 6px;
            }
            a:hover {
                background: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Acceso no válido. Utiliza el formulario de modificación.</h2>
            <a href="../index.html">Volver al registro</a>
        </div>
    </body>
    </html>
    <?php
}
?>
