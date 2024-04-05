<?php
// Para utilizar elementos de ese archivo
require 'vendor/autoload.php';

// Busca el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// Carga las variables en $_ENV (ahora puedo utilizar los datos del vrbs)
$dotenv->load();

// Conexión en vrb
$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

// Verificar la conexión
if ($conn->connect_error){
    // Registrar error en archivo log predeterminado del servidor
    error_log("Error de conexión: " . $conn->connect_error);
    // Redirecciono al usuario
    header('location: error.php');
    // Hacer que nada de lo que está posterior al exit se ejecute
    exit();
}