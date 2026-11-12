<?php
// Ajusta estos datos si tu XAMPP usa una contraseña para MySQL.
$host = 'localhost';
$baseDatos = 'JuanDB_Ducuara';
$usuario = 'root';
$clave = '';

try {
    $conexion = new PDO(
        "mysql:host={$host};dbname={$baseDatos};charset=utf8mb4",
        $usuario,
        $clave,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
} catch (PDOException $e) {
    http_response_code(500);
    die('No se pudo conectar con la base de datos. Revisa conexion.php y database.sql.');
}
