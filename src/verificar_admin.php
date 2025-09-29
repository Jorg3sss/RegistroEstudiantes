<?php
session_start();
include "../database/conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $contra = $_POST["Contraseña"];

    $_SESSION["usuario"] = $usuario;

    $stmt = $conn->prepare("SELECT * FROM administradores WHERE usuario = ? AND contraseña = ?");
    $stmt->bind_param("ss", $usuario, $contra);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $conn->close();
        header("Location: ver_estudiantes.php");
        exit();
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Error de inicio de sesión</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f5f5f5;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .error-box {
                    background: #fff;
                    border: 1px solid #ddd;
                    border-radius: 10px;
                    padding: 20px;
                    text-align: center;
                    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                    width: 350px;
                }
                .error-box h2 {
                    color: #e74c3c;
                    margin-bottom: 15px;
                }
                .error-box a {
                    display: inline-block;
                    margin-top: 10px;
                    padding: 10px 15px;
                    background: #3498db;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    transition: background 0.3s;
                }
                .error-box a:hover {
                    background: #2980b9;
                }
            </style>
        </head>
        <body>
            <div class="error-box">
                <h2>❌ Usuario o contraseña incorrectos</h2>
                <p>Por favor, vuelve a intentarlo.</p>
                <a href="../admin.html">🔙 Volver al login</a>
            </div>
        </body>
        </html>
        <?php

        $stmt->close();
        $conn->close();
    }
}
?>
