<?php

function conectarDB()
{
    $db = new mysqli('localhost', 'root', '', 'bienes_raices_crud');

    if (!$db) {

        echo 'No se pudo conectar';
        exit();
    }
    return $db;
}
