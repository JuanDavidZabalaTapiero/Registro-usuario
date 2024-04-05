<!-- Código php -->
<?php
require 'conexion.php';

// Verifico si se envío el formulario (click en el submit)
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $_POST["form-name"];
    $contraseña = $_POST["form-password"];

    // Sanear la entrada del usuario para prevenir ataques XSS
    $nombre = trim($nombre); // Eliminar espacios en blanco
    $nombre = stripslashes($nombre); // Eliminar barras invertidas
    $nombre = htmlspecialchars($nombre); // Convertir caracteres especiales a entidades

    // Hasheo
    $contraseña_hasheada = password_hash($contraseña, PASSWORD_DEFAULT);

    // Consulta preparada (tiene "?")
    $sql = "INSERT INTO usuarios(nombre, contraseña) VALUES (?,?)";
    // En nueva vrb utilizo el "prepare" para utiliza el "bind_param"
    $stmt = $conn->prepare($sql);
    // Utilizo el método "bind_param" de la vrb para reemplazar los ?
    $stmt->bind_param("ss", $nombre, $contraseña_hasheada);

    if($stmt->execute()){
        echo "Cuenta creada exitosamente";
    } else{
        error_log("Error al ejecutar setencia preparada: " . $stmt->error);
        header('location: error.php');
    }

    // Cerrar la sentencia preparada
    $stmt->close();
    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
<!-- Código html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div>
        <h2>Registro</h2>
        <form action="" method="post">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="form-name" required>
            <label for="contraseña">Contraseña</label>
            <input type="password" id="contraseña" name="form-password" required>
            <input type="submit" value="Crear cuenta">
        </form>
    </div>
</body>
</html>
