<?php $titulo = 'Crear persona';
$accion = 'crear'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear persona - Prueba Ducuara</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/estilos.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary">
        <div class="container"><a class="navbar-brand" href="index.php">Prueba Ducuara</a></div>
    </nav>
    <main class="container py-4">
        <h1 class="h3 mb-3">Nueva persona</h1><?php require 'formulario.php'; ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/formulario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>