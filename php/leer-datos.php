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
      //$nuevas_apuestas[] = $ant_valor_apu;
      if ($ant_apuesta == 'lotnavidad' || $ant_apuesta == 'laonce') {
        $ant_decimo_frontal = obtener_nombre_fichero_decimo($ant_valor_apu["nom_fich"], $ant_apuesta, true);
        $ant_decimo_trasera = obtener_nombre_fichero_decimo($ant_valor_apu["nom_fich"], $ant_apuesta, false);
      } else {
        $ant_decimo_frontal = "";
        $ant_decimo_trasera = "";
      }
      $nuevas_apuestas[] = [
        'tipoapu'    => $ant_apuesta,
        'titulo'     => $ant_valor_apu['titulo'],
        'subtitulo'  => $ant_valor_apu['subtitulo'],
        'color'      => $ant_valor_apu['color'],
        'fechas'     => $ant_valor_apu['fechas'],
        'imagen'     => $ant_valor_apu['imagen'],
        'icono'      => $ant_valor_apu['icono'],
        'numeros'    => $ant_valor_apu['numeros'],
        'reintegros' => $ant_valor_apu['reintegros'],
        'premio'     => $ant_valor_apu['premio'],
        'decfrontal' => $ant_decimo_frontal,
        'dectrasera' => $ant_decimo_trasera
      ];
    }
  }
} else {

  // No nos ha llegado nada, devolvemos un error.
  $nuevas_apuestas = ['error' => true];
}

// Devolvemos lo obtenido: o un error o las apuestas del día.
echo json_encode($nuevas_apuestas);
// echo "<pre>";
// echo print_r($nuevas_apuestas);
// echo "</pre>";
