<?php
session_start();
include "../database/conexion.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Estudiante</title>
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
            text-align: center;
            width: 100%;
            max-width: 500px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #d9534f;
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
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id_estudiante = $_GET['id'];

            $stmt = $conn->prepare("DELETE FROM estudiantes WHERE id = ?");
            $stmt->bind_param("i", $id_estudiante);

            if ($stmt->execute()) {
                echo "<h2 class='success'>✅ Estudiante con ID {$id_estudiante} eliminado correctamente.</h2>";
                echo "<a href='ver_estudiantes.php'>Ver lista de estudiantes</a>";
                echo "<a href='../index.html'>Volver al registro</a>";
            } else {
                echo "<h2 class='error'>❌ Error al eliminar el estudiante: " . $conn->error . "</h2>";
                echo "<a href='ver_estudiantes.php'>Volver a la lista</a>";
            }

            $stmt->close();
        } else {
            echo "<h2 class='error'>⚠️ ID de estudiante no válido.</h2>";
            echo "<a href='ver_estudiantes.php'>Volver a la lista</a>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
