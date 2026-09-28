<?php
header('Content-Type: text/html; charset=UTF-8');

// Configuración de la base de datos
$db_host = 'db';
$db_name = 'testdb';
$db_user = 'appuser';
$db_pass = 'apppassword';

$db_status = false;
$db_message = '';
$visitas = [];

try {
    $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT            => 5
    ]);
    
    $db_status = true;
    $db_message = 'Conexión PDO establecida con éxito a MySQL.';

    // Crear tabla de demostración si no existe
    $pdo->exec("CREATE TABLE IF NOT EXISTS registro_visitas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip VARCHAR(45) NOT NULL,
        user_agent VARCHAR(255) NOT NULL,
        fecha DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Registrar la visita actual
    $stmt = $pdo->prepare("INSERT INTO registro_visitas (ip, user_agent) VALUES (?, ?)");
    $stmt->execute([
        $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
        substr($_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido', 0, 250)
    ]);

    // Obtener las últimas visitas
    $stmt = $pdo->query("SELECT id, ip, user_agent, fecha FROM registro_visitas ORDER BY id DESC LIMIT 5");
    $visitas = $stmt->fetchAll();

} catch (PDOException $e) {
    $db_status = false;
    $db_message = 'Error de conexión PDO: ' . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entorno Docker LEMP - Nginx, PHP 8.3 & MySQL</title>
    <style>
        :root {
            --primary: #2563eb;
            --success: #16a34a;
            --danger: #dc2626;
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text: #f8fafc;
            --text-muted: #94a3b8;
            --border: #334155;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 2rem 1rem;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 860px;
        }

        header {
            text-align: center;
            margin-bottom: 2rem;
        }

        header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #60a5fa, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        header p {
            color: var(--text-muted);
            font-size: 1.05rem;
            margin: 0;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: rgba(22, 163, 74, 0.2);
            color: #4ade80;
            border: 1px solid #16a34a;
        }

        .badge-danger {
            background-color: rgba(220, 38, 38, 0.2);
            color: #f87171;
            border: 1px solid #dc2626;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .card h2 {
            font-size: 1.1rem;
            margin: 0;
            font-weight: 600;
        }

        .card p {
            margin: 0.25rem 0;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .card .detail {
            color: var(--text);
            font-family: monospace;
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }

        .table-section {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
        }

        .table-section h3 {
            margin-top: 0;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        th, td {
            text-align: left;
            padding: 0.75rem;
            border-bottom: 1px solid var(--border);
        }

        th {
            color: var(--text-muted);
            font-weight: 600;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background: rgba(22, 163, 74, 0.15);
            border: 1px solid #16a34a;
            color: #86efac;
        }

        .alert-danger {
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid #dc2626;
            color: #fca5a5;
        }

        footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Entorno Docker LEMP</h1>
            <p>Arquitectura de Contenedores Independientes (Nginx + PHP 8.3 + MySQL)</p>
        </header>

        <div class="grid">
            <!-- Contenedor Web -->
            <div class="card">
                <div class="card-header">
                    <h2>1. Web (Nginx)</h2>
                    <span class="badge badge-success">Activo</span>
                </div>
                <p>Servidor proxy inverso FastCGI</p>
                <div class="detail">Puerto: 8080 &rarr; 80</div>
            </div>

            <!-- Contenedor PHP -->
            <div class="card">
                <div class="card-header">
                    <h2>2. PHP (PHP-FPM)</h2>
                    <span class="badge badge-success">Activo</span>
                </div>
                <p>Intérprete de código</p>
                <div class="detail">Versión: PHP <?= htmlspecialchars(PHP_VERSION); ?></div>
            </div>

            <!-- Contenedor Base de Datos -->
            <div class="card">
                <div class="card-header">
                    <h2>3. DB (MySQL)</h2>
                    <span class="badge <?= $db_status ? 'badge-success' : 'badge-danger'; ?>">
                        <?= $db_status ? 'Conectado' : 'Desconectado'; ?>
                    </span>
                </div>
                <p>Gestor de Base de Datos</p>
                <div class="detail">Host: <?= htmlspecialchars($db_host); ?> (PDO)</div>
            </div>
        </div>

        <div class="alert <?= $db_status ? 'alert-success' : 'alert-danger'; ?>">
            <strong>Estado de la Base de Datos:</strong> <?= $db_message; ?>
        </div>

        <?php if ($db_status): ?>
        <div class="table-section">
            <h3>Registro de Visitas en Base de Datos (PDO Demo)</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>IP</th>
                        <th>User Agent</th>
                        <th>Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($visitas)): ?>
                        <tr><td colspan="4">No hay registros aún.</td></tr>
                    <?php else: ?>
                        <?php foreach ($visitas as $v): ?>
                            <tr>
                                <td><?= htmlspecialchars($v['id']); ?></td>
                                <td><?= htmlspecialchars($v['ip']); ?></td>
                                <td><?= htmlspecialchars(substr($v['user_agent'], 0, 50)); ?>...</td>
                                <td><?= htmlspecialchars($v['fecha']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <footer>
            Práctica PUD1 &bull; Despliegue con <code>docker compose up -d</code>
        </footer>
    </div>
</body>
</html>
