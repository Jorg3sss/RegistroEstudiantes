<?php
session_start();

include "../database/conexion.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $usuario = $_POST["usuario"];
    $contra = $_POST["Contraseña"];

    $_SESSION["usuario"] = $usuario;

    $stmt = $conn->prepare("SELECT * FROM administradores WHERE usuario = ? AND contraseña = ?");
    $stmt->bind_param("ss", $usuario, $contra);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->close();
        $conn->close();
        header("Location: ver_estudiantes.php");
    }
    else{
        echo "<h2>El usuario o contraseña son incorrectos, vuelve a intentar</h2>";
        echo "<a href='../admin.html'>Volver</a>";
        $stmt->close();
        $conn->close();

    }


}

?>