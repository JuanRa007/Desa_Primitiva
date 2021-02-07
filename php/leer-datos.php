<?php
error_reporting(0);
header('Content-type: application/json; charset=utf-8');

// Includes necesarias.
/* CONFIGURACIÓN */
require_once("../includes/libs/lib_config.php");
/* BBDD */
require_once("../includes/libs/lib_db.php");
/* FUNCIONES */
require_once("../includes/libs/lib_funciones.php");

// Leemos los datos recibidos.
if ($_GET) {

  $fecha_ano = (int) $_GET["ano"];
  $fecha_mes = (int) $_GET["mes"];
  $fecha_dia = (int) $_GET["dia"];
  $fecha_apuesta = $fecha_ano . "-" . $fecha_mes . "-" . $fecha_dia . " 00:00:00";

  // Lectura de la apuesta.
  $apuesta = leer_apuesta_dia($fecha_apuesta);
  $datos_apuestas = obtener_apuestas($apuesta);
  //$saldo_premio_dia = obtener_premio_dia($apuesta);
} else {

  // No nos ha llegado nada, devolvemos un error.
  $datos_apuestas = ['error' => true];
}

echo json_encode($datos_apuestas);
// echo "<pre>";
// echo print_r($datos_apuestas);
// echo "</pre>";
