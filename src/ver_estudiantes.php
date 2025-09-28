<?php 
session_start(); 
include "../database/conexion.php";
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Ver estudiantes</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eceff1;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        h1 {
            color: #1f1f1f;
            margin-bottom: 20px;
        }

        .table-container {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 6px 12px rgba(0,0,0,0.15);
            width: 90%;
            max-width: 900px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        thead {
            background: #1f1f1f;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        tr:hover {
            background: #f2f2f2;
        }

        .acciones-col a {
            padding: 6px 12px;
            margin-right: 5px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            transition: 0.3s;
        }

        .acciones-col a:first-child {
            background: #00c46b;
            color: white;
        }

        .acciones-col a:first-child:hover {
            background: #00a85a;
        }

        .btn-eliminar {
            background: #e74c3c;
            color: white;
        }

        .btn-eliminar:hover {
            background: #c0392b;
        }

        .btn-volver {
            display: inline-block;
            padding: 10px 18px;
            background: #1f1f1f;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-volver:hover {
            background: #333;
        }

        p {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

    <h1>¡Bienvenido <?php echo $_SESSION["usuario"]; ?>!</h1>

    <div class="table-container">
        <?php
        $sql = "SELECT id, nombre, carrera, semestre, correo FROM estudiantes ORDER BY nombre ASC";
        $resultado = $conn->query($sql);

        if ($resultado) {
            if ($resultado->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr><th>ID</th><th>Nombre</th><th>Carrera</th><th>Semestre</th><th>Correo</th><th>Acciones</th></tr></thead>";
                echo "<tbody>";

                while ($fila = $resultado->fetch_assoc()) {
                    $id_estudiante = $fila["id"];
                    
                    echo "<tr>";
                    echo "<td>" . $id_estudiante . "</td>";
                    echo "<td>" . $fila["nombre"] . "</td>";
                    echo "<td>" . $fila["carrera"] . "</td>";
                    echo "<td>" . $fila["semestre"] . "</td>";
                    echo "<td>" . $fila["correo"] . "</td>";

                    echo "<td class='acciones-col'>";
                    
                    // Botón modificar
                    echo "<a href='modificar.php?id=" . $id_estudiante . "'>Modificar</a> ";
                    
                    // Botón eliminar
                    echo "<a href='eliminar.php?id=" . $id_estudiante . "' 
                               class='btn-eliminar' 
                               onclick='return confirm(\"¿Estás seguro de que quieres eliminar al estudiante con ID " . $id_estudiante . "?\")'>Eliminar</a>";

                    echo "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No hay estudiantes registrados.</p>";
            }

            $resultado->free();
        } else {
            echo "Error al ejecutar la consulta: " . $conn->error;
        }

        $conn->close();
        ?>
    </div>

    <br>
    <a href="../index.html" class="btn-volver">Volver al registro</a>

</body>
</html>
