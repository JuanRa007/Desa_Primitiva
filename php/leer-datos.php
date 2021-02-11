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
  $nuevas_apuestas = [];
  foreach ($datos_apuestas  as $ant_apuesta => $ant_apuestas) {
    foreach ($ant_apuestas as $ant_indice => $ant_valor_apu) {
      $nuevas_apuestas[] = $ant_valor_apu;
    }
  }
} else {

  // No nos ha llegado nada, devolvemos un error.
  $nuevas_apuestas = ['error' => true];
}

// Devolvemos lo obtenido: o un error o las apuestas del día.
echo json_encode($nuevas_apuestas);
