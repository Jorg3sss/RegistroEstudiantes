<?php
session_start();
include "../database/conexion.php";

if(isset($_GET["id"])){
    $id = $_GET["id"];
    $stmt = $conn->prepare("SELECT * FROM estudiantes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();
    
    if($resultado->num_rows === 1){
        $estudiante = $resultado->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Modificar Estudiante</title>
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
                    max-width: 400px;
                }
                h2 {
                    text-align: center;
                    color: #333;
                    margin-bottom: 20px;
                }
                input {
                    width: 100%;
                    padding: 10px;
                    margin: 8px 0;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    font-size: 14px;
                }
                input:focus {
                    outline: none;
                    border-color: #007BFF;
                    box-shadow: 0 0 5px rgba(0,123,255,0.3);
                }
                .btn {
                    display: block;
                    width: 100%;
                    padding: 12px;
                    background: #007BFF;
                    color: #fff;
                    border: none;
                    border-radius: 6px;
                    cursor: pointer;
                    font-size: 16px;
                    margin-top: 10px;
                    text-align: center;
                }
                .btn:hover {
                    background: #0056b3;
                }
                .link {
                    display: block;
                    text-align: center;
                    margin-top: 15px;
                    text-decoration: none;
                    color: #007BFF;
                }
                .link:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2>Modificar Estudiante</h2>
                <form action="mod.php?id=<?php echo $id; ?>" method="POST">
                    <input type="text" id="nombre" name="nombre" value="<?php echo $estudiante['nombre']; ?>" placeholder="Nombre" required>
                    <input type="text" id="carrera" name="carrera" value="<?php echo $estudiante['carrera']; ?>" placeholder="Carrera" required>
                    <input type="text" id="semestre" name="semestre" value="<?php echo $estudiante['semestre']; ?>" placeholder="Semestre" required>
                    <input type="email" id="correo" name="correo" value="<?php echo $estudiante['correo']; ?>" placeholder="Correo" required>
                    <button type="submit" class="btn">Guardar Cambios</button>
                </form>
                <a href="ver_estudiantes.php" class="link">Volver a la lista</a>
            </div>
        </body>
        </html>
        <?php
        $stmt->close();
    }
    else{
        echo "Estudiante no encontrado";
        echo "<a href='../index.html'>Volver al registro</a><br>";
        $stmt->close();
    }
}
?>
