<?php
declare(strict_types=1);

// ============================================================
// inc/heroe.php — Constantes y datos del héroe (Variante B · Hechicero)
// Autor/a: Marco García Ruiz · Módulo 0613 DWES · UD2 · Forja de Héroes
// Solo PHP puro, sin etiqueta de cierre.
// ============================================================

// --- Constantes comunes a todas las variantes ---
const XP_POR_NIVEL   = 400;   // Experiencia necesaria para subir un nivel
const VIDA_BASE      = 50;    // Vida base de todo personaje
const BLOQUES_BARRA  = 20;    // Número de bloques de las barras de progreso

// --- Constantes de la variante B · Hechicero ---
const CLASE_HEROE  = 'Hechicero';
const MULT_VIDA    = 1;                    // Multiplicador de vida por clase
const NOMBRE_RIVAL = 'Dragón de Obsidiana';

// PODER_RIVAL se define con define() porque el enunciado lo exige así
define('PODER_RIVAL', 650);

// --- Datos del héroe (llegan como texto, simulando un formulario) ---
$nombreHeroe     = 'Aldric <el Arcano>';
$apodo           = null;     // Sin apodo asignado
$lema            = '';       // Sin lema todavía

$fuerzaTxt       = '8';
$destrezaTxt     = '11';
$inteligenciaTxt = '19';
$constitucionTxt = '10';
$experienciaTxt  = '3120';
$vidaActualTxt   = '41';
$oroTxt          = '987.4';
$esVeterano      = false;
