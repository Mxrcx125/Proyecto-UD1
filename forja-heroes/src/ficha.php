<?php
declare(strict_types=1);

/**
 * =====================================================================
 *  ficha.php · Forja de Héroes · UD2 · Reto evaluable
 * =====================================================================
 *  Variante B · Hechicero (Aldric <el Arcano>)
 *
 *  Estructura OBLIGATORIA (como en el paso 09 del caso guiado):
 *   1) directiva strict_types
 *   2) carga de inc/heroe.php con require_once y __DIR__
 *   3) CÁLCULOS: bloque inicial sin HTML
 *   4) PRESENTACIÓN: HTML con los valores incrustados
 *
 *  Reglas: Sin if, else, switch, match, bucles, arrays propios ni funciones propias.
 *  Todo resuelto con operadores, ternario (? :) y operadores ?? y ?:.
 */

// R1 · Carga de inc/heroe.php
require_once __DIR__ . '/inc/heroe.php';

// ---------------------------------------------------------------------
// CÁLCULOS (R2 a R7)
// ---------------------------------------------------------------------

// R2 · Conversión de tipos con casting explícito
$fuerza       = (int) $fuerzaTxt;
$destreza     = (int) $destrezaTxt;
$inteligencia = (int) $inteligenciaTxt;
$constitucion = (int) $constitucionTxt;
$experiencia  = (int) $experienciaTxt;
$vidaActual   = (int) $vidaActualTxt;
$oro          = (float) $oroTxt;

// R3 · Progresión
$nivel       = intdiv($experiencia, XP_POR_NIVEL) + 1;
$xpEnNivel   = $experiencia % XP_POR_NIVEL;
$xpParaSubir = XP_POR_NIVEL - $xpEnNivel;
$pctNivel    = ($xpEnNivel / XP_POR_NIVEL) * 100;

// R4 · Vida y combate
$vidaMax = VIDA_BASE + ($constitucion * $nivel * MULT_VIDA);
$pctVida = ($vidaActual / $vidaMax) * 100;

// Daño y estadística especial (Variante B · Hechicero)
$danio = ($inteligencia * 3) + (($nivel ** 2) / 4);
$mana  = ($inteligencia * 10) + ($experiencia % 100);

// Poder total
$poder = (int) round($danio * $nivel);

// Comparación frente al rival con operador nave espacial <=>
$comparacion = $poder <=> PODER_RIVAL;
$veredicto = ($comparacion === 1)
    ? 'Ventaja: ¡a la carga!'
    : (($comparacion === 0)
        ? 'Empate: combate igualado'
        : 'Desventaja: mejor retirarse');

// R5 · Estado y decisiones
$estado = ($vidaActual > 0)
    ? (($pctVida < 35) ? 'En peligro' : 'En pie')
    : 'K.O.';

$puedeAscenderTxt  = ($nivel >= 5 && $pctVida >= 50) ? 'Sí' : 'No';
$necesitaPocionTxt = ($pctVida < 40 || !$esVeterano) ? 'Sí' : 'No';
$insignia          = $esVeterano ? 'VETERANO' : 'NOVATO';

// R6 · Barras de progreso (20 bloques con str_repeat)
$bloquesVidaLlenos = (int) round(($pctVida / 100) * BLOQUES_BARRA);
$bloquesVidaVacios = BLOQUES_BARRA - $bloquesVidaLlenos;
$barraVida         = str_repeat('█', $bloquesVidaLlenos) . str_repeat('░', $bloquesVidaVacios);

$bloquesXpLlenos = (int) round(($pctNivel / 100) * BLOQUES_BARRA);
$bloquesXpVacios = BLOQUES_BARRA - $bloquesXpLlenos;
$barraXp         = str_repeat('█', $bloquesXpLlenos) . str_repeat('░', $bloquesXpVacios);

// R7 · Textos y formatos
$apodoLimpio = $apodo ?? 'Sin apodo';
$lemaLimpio  = $lema ?: 'Sin lema (todavía)';

$oroFormateado     = number_format($oro, 2, ',', '.') . ' mo';
$danioFormateado   = number_format($danio, 1, ',', '.');
$pctVidaFormateado = number_format($pctVida, 1, ',', '.');

// Registro de combate construido con .= en al menos tres pasos
$registroCombate  = '[' . date('H:i:s') . '] ';
$registroCombate .= htmlspecialchars($nombreHeroe) . ' (nivel ' . $nivel . ') ';
$registroCombate .= 'se enfrenta a ' . NOMBRE_RIVAL . ' (poder ' . PODER_RIVAL . '). ';
$registroCombate .= 'Resultado: ' . $comparacion . ' → ' . $veredicto;

// Crónica de tres líneas con heredoc interpolando variables
$claseHeroeVar = CLASE_HEROE;
$cronica = <<<CRONICA
{$nombreHeroe} avanza como {$claseHeroeVar} de nivel {$nivel} por los senderos arcanos.
Aún le restan {$xpParaSubir} puntos de experiencia para alcanzar el siguiente rango de maestría.
Tras las pruebas recientes en las cámaras místicas, su estado actual es: {$estado}.
CRONICA;

$fechaGeneracion = date('d/m/Y H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ficha de <?= htmlspecialchars($nombreHeroe) ?></title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<main>
    <!-- R1: Insignia VETERANO/NOVATO con etiqueta larga y echo -->
    <span class="insignia"><?php echo $insignia; ?></span>
    <!-- R1: A partir de aquí, etiquetas cortas de salida -->
    <h1><?= htmlspecialchars($nombreHeroe) ?></h1>
    <p class="subtitulo"><?= htmlspecialchars(CLASE_HEROE) ?> · «<?= htmlspecialchars($apodoLimpio) ?>» · <?= htmlspecialchars($lemaLimpio) ?></p>

    <h2>Estadísticas</h2>
    <div class="rejilla">
        <div class="stat"><div class="etq">Nivel</div><div class="val"><?= $nivel ?></div></div>
        <div class="stat"><div class="etq">Vida</div><div class="val"><?= $vidaActual ?> / <?= $vidaMax ?></div></div>
        <div class="stat"><div class="etq">Daño</div><div class="val"><?= $danioFormateado ?></div></div>
        <div class="stat"><div class="etq">Maná (pm)</div><div class="val"><?= $mana ?> pm</div></div>
        <div class="stat"><div class="etq">Poder</div><div class="val"><?= $poder ?></div></div>
        <div class="stat"><div class="etq">Oro</div><div class="val"><?= $oroFormateado ?></div></div>
    </div>
    <table>
        <tr><th>Fuerza</th><th>Destreza</th><th>Inteligencia</th><th>Constitución</th></tr>
        <tr><td><?= $fuerza ?></td><td><?= $destreza ?></td><td><?= $inteligencia ?></td><td><?= $constitucion ?></td></tr>
    </table>

    <h2>Progreso</h2>
    <p class="barra vida">VIDA <?= $barraVida ?> · <?= $pctVidaFormateado ?> %</p>
    <p class="barra xp">XP&nbsp;&nbsp; <?= $barraXp ?> · <?= $xpEnNivel ?>/<?= XP_POR_NIVEL ?> (faltan <?= $xpParaSubir ?>)</p>

    <h2>Estado y decisiones</h2>
    <table>
        <tr><td>Estado</td><td><?= htmlspecialchars($estado) ?></td></tr>
        <tr><td>¿Puede ascender de rango? (nivel ≥ 5 y vida ≥ 50 %)</td><td><?= $puedeAscenderTxt ?></td></tr>
        <tr><td>¿Necesita poción? (vida &lt; 40 % o no veterano)</td><td><?= $necesitaPocionTxt ?></td></tr>
        <tr><td>Rival: <?= htmlspecialchars(NOMBRE_RIVAL) ?> (poder <?= PODER_RIVAL ?>)</td><td><?= $comparacion ?> → <?= htmlspecialchars($veredicto) ?></td></tr>
    </table>

    <h2>Crónica</h2>
    <pre><?= htmlspecialchars($cronica) ?></pre>
    <p><em><?= $registroCombate ?></em></p>

    <h2>Modo depuración</h2>
    <pre><?php
echo 'experienciaTxt → ' . get_debug_type($experienciaTxt) . "\n";
echo 'experiencia    → ' . get_debug_type($experiencia) . "\n";
var_dump($oro);
var_dump($pctVida);
var_dump($esVeterano);
var_dump($apodo);
var_dump($experienciaTxt == $experiencia);
var_dump($experienciaTxt === $experiencia);
?></pre>

    <footer>Ficha generada el <?= $fechaGeneracion ?> con PHP <?= PHP_VERSION ?> ·
        <a href="diagnostico.php">Diagnóstico del servidor</a></footer>
</main>
</body>
</html>
