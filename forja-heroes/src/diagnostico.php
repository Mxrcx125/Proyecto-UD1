<?php
declare(strict_types=1);

/**
 * =====================================================================
 *  diagnostico.php · Panel de directivas del servidor          [CE 2.f]
 * =====================================================================
 *  Variante B · Hechicero
 */

// 1. Directivas leídas con ini_get
$valDisplayErrors     = (string) ini_get('display_errors');
$valErrorReporting    = (string) ini_get('error_reporting');
$valDateTimezone      = (string) ini_get('date.timezone');
$valShortOpenTag      = (string) ini_get('short_open_tag');
$valExposePhp         = (string) ini_get('expose_php');
$valMaxExecutionTime  = (string) ini_get('max_execution_time');

// Comprobación estricta de error_reporting() === E_ALL
$esEAll = (error_reporting() === E_ALL);

// Ficheros .ini adicionales cargados
$iniAdicionales = (string) php_ini_scanned_files();

// 2. Experimento con date.timezone e ini_set / ini_restore
$horaAntes = date('H:i:s T');
$retSetTimezone = ini_set('date.timezone', 'UTC');
$horaDespues = date('H:i:s T');
ini_restore('date.timezone');
$horaRestaurada = date('H:i:s T');

// 3. Experimento con short_open_tag e ini_set
$retSetShortOpenTag = ini_set('short_open_tag', '0');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Diagnóstico del servidor · Forja de Héroes</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<main>
    <h1>Diagnóstico del servidor</h1>
    <p class="subtitulo">PHP <?= PHP_VERSION ?> · <?= PHP_OS_FAMILY ?> (<?= PHP_OS ?>)</p>

    <h2>Ficheros .ini adicionales</h2>
    <p><code><?= htmlspecialchars($iniAdicionales !== '' ? $iniAdicionales : 'Ninguno') ?></code></p>

    <h2>Directivas configuradas en php/forja.ini</h2>
    <table>
        <tr>
            <th>Directiva</th>
            <th>Valor (ini_get)</th>
            <th>Comprobación / Por qué</th>
        </tr>
        <tr>
            <td><code>display_errors</code></td>
            <td><?= htmlspecialchars($valDisplayErrors) ?></td>
            <td>Muestra errores en pantalla durante el desarrollo para agilizar la depuración</td>
        </tr>
        <tr>
            <td><code>error_reporting</code></td>
            <td><?= htmlspecialchars($valErrorReporting) ?></td>
            <td>
                <?= $esEAll ? '✔ Coincide exactamente con E_ALL (' . E_ALL . ')' : '✘ No coincide con E_ALL' ?>
            </td>
        </tr>
        <tr>
            <td><code>date.timezone</code></td>
            <td><?= htmlspecialchars($valDateTimezone) ?></td>
            <td>Zona horaria del servidor para funciones de fecha y hora local</td>
        </tr>
        <tr>
            <td><code>short_open_tag</code></td>
            <td><?= htmlspecialchars($valShortOpenTag) ?></td>
            <td>Permite usar etiquetas cortas de salida &lt;?= ... ?&gt; en el código HTML</td>
        </tr>
        <tr>
            <td><code>expose_php</code></td>
            <td><?= htmlspecialchars($valExposePhp !== '' ? $valExposePhp : '0 (Off)') ?></td>
            <td>Oculta la cabecera X-Powered-By para evitar exponer la versión por seguridad</td>
        </tr>
        <tr>
            <td><code>max_execution_time</code></td>
            <td><?= htmlspecialchars($valMaxExecutionTime) ?> s</td>
            <td>Límite de 10 s para evitar consumo indebido por procesos colgados</td>
        </tr>
    </table>

    <h2>Cambio en tiempo de ejecución (ini_set)</h2>
    <table>
        <tr>
            <th>Prueba</th>
            <th>Resultado</th>
            <th>Detalle</th>
        </tr>
        <tr>
            <td><code>ini_set('date.timezone', 'UTC')</code></td>
            <td>Devuelve: <code><?= htmlspecialchars(var_export($retSetTimezone, true)) ?></code></td>
            <td>
                Hora antes (Europe/Madrid): <strong><?= htmlspecialchars($horaAntes) ?></strong><br>
                Hora después (UTC): <strong><?= htmlspecialchars($horaDespues) ?></strong><br>
                Hora tras <code>ini_restore</code>: <strong><?= htmlspecialchars($horaRestaurada) ?></strong>
            </td>
        </tr>
        <tr>
            <td><code>ini_set('short_open_tag', '0')</code></td>
            <td>Devuelve: <code><?= htmlspecialchars(var_export($retSetShortOpenTag, true)) ?></code></td>
            <td>
                Falla (devuelve <code>false</code>) porque es una directiva de ámbito <code>PHP_INI_SYSTEM</code> / <code>PHP_INI_PERDIR</code>; solo puede fijarse al arrancar PHP o en el fichero .ini, no en tiempo de ejecución.
            </td>
        </tr>
    </table>

    <footer><a href="ficha.php">&larr; Volver a la ficha</a></footer>
</main>
</body>
</html>
