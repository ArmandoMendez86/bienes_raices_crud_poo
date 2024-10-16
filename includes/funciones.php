<?php

define('TEMPLATES_URL', __DIR__ . './templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '../../imagenes/');

function incluirTemplate($nombre, $inicio = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado()
{
    session_start();
    if (!$_SESSION['login']) {
        header('Location: /bienes_raices_poo');
    }

    return false;
}

function debuguear($variable)
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

function escaparHtml($html)
{
    $escapar = htmlspecialchars($html);
    return $escapar;
}
