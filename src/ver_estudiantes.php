<?php 
session_start(); 
include "../database/conexion.php";
?>

<html>
    <head>
        <title>Ver estudiantes</title>
    </head>
    <body>
        <h1>¡Bienvenido <?php $_SESSION["usuario"] ?>!</h1>
    </body>
</html>

<?php


$sql = "SELECT id, nombre, carrera, semestre, correo FROM estudiantes ORDER BY nombre ASC";
$resultado = $conn->query($sql);

if ($resultado) {
    if ($resultado->num_rows > 0) {

        echo "<table>";
        echo "<thead><tr><th>ID</th><th>Nombre</th><th>Carrera</th><th>Semestre</th><th>Correo</th><th></th></tr></thead>";
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
            
            //Modificar
            echo "<a href='modificar.php?id=" . $id_estudiante . "'>Modificar</a> ";
            
            //boton para eliminar
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

echo "<a href='../index.html'>Volver al registro</a>"


?>
