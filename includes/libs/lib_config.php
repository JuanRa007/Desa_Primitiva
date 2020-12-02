<?php

/* TEST O PRODUCTIVO */
$app_prod = false;

/* APP NOMBRE */
$app_name = "Nuestras Apuestas BETA";

/* DATABASE CONFIGURATION */
$app_host = 'localhost';
$app_user = 'primitiva';
if ($app_prod) {
  $app_pass = 'Primitiva1967&';                   //'primitiva';
  $app_dbname = 'nuestrasapuestas_es_primitiva';  //'primitiva';
} else {
  $app_pass = 'primitiva';
  $app_dbname = 'primitiva';
}

/* MENU CONFIGURATION */
$act_pagina = basename($_SERVER['PHP_SELF']);

/* SALDO MÍNIMO */
$app_saldominimo = 2.5;

/* RANGO DE AÑOS */
$app_rangoanoini = 2003;
$app_rangoanofin = date("Y", time()) + 1;
