<?php

/* APP NOMBRE */
$app_name = "Nuestras Apuestas BETA";

/* DATABASE CONFIGURATION */
$host = 'localhost';
$user = 'primitiva';
$pass = 'primitiva';
$dbname = 'primitiva';

/* MENU CONFIGURATION */
$act_pagina = basename($_SERVER['PHP_SELF']);

/* SALDO MÍNIMO */
$saldominimo = 2.5;

/* RANGO DE AÑOS */
$rangoanoini = 2003;
$rangoanofin = date("Y", time()) + 1;
