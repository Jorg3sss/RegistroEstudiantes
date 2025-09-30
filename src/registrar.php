<?php
session_start(); 
include "../database/conexion.php";
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Registro de estudiante</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eceff1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 6px 12px rgba(0,0,0,0.15);
            text-align: center;
            width: 400px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .success {
            color: #00a85a;
        }

        .error {
            color: #e74c3c;
        }

        a {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 18px;
            background: #1f1f1f;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        a:hover {
            background: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
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
                    echo "<h2 class='error'>Error: el correo '{$correo}' ya ha sido registrado, prueba con otro.</h2>";
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
                        echo "<h2 class='success'>Estudiante registrado correctamente.</h2>";
                        echo "<a href='../index.html'>Volver al registro</a>";
                        echo "<a href='ver_estudiantes.php'>Ver lista de estudiantes</a>";
                    } else {
                        echo "<h2 class='error'>Error al registrar: " . $stmt->error . "</h2>";
                    }
                    $stmt->close();
                }

                
            } else {
                echo "<h2 class='error'>Todos los campos son obligatorios.</h2>";
                echo "<a href='../index.html'>Volver al registro</a>";
            }
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
