<?php
$host = 'db';
$dbname = 'testdb';
$user = 'appuser';
$password = 'apppassword';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_mensaje = "Conexión realizada con éxito mediante PDO.";
    
    $stmt = $pdo->query("SELECT VERSION() AS version");
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    $mysql_version = $fila['version'];
} catch (PDOException $e) {
    $db_mensaje = "Error al conectar: " . $e->getMessage();
    $mysql_version = "No disponible";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica UD1 - Docker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            color: #222;
        }
        ul {
            line-height: 1.8;
        }
        .estado-ok {
            color: green;
            font-weight: bold;
        }
        .estado-error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Práctica UD1: Servidor con Docker</h1>
    <p>Comprobación del entorno:</p>

    <ul>
        <li><strong>Servidor web (Nginx):</strong> Funcionando correctamente en el puerto 8080.</li>
        <li><strong>Intérprete PHP:</strong> Versión <?= phpversion(); ?></li>
        <li><strong>Base de datos MySQL:</strong> <span class="<?= isset($pdo) ? 'estado-ok' : 'estado-error'; ?>"><?= $db_mensaje; ?></span> (MySQL <?= htmlspecialchars($mysql_version); ?>)</li>
    </ul>

</body>
</html>
