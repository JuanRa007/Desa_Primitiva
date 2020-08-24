<?php

/////////////////////////////
//                         //
//  FUNCIONES  CALENDARIO  //
//                         //
/////////////////////////////

function obtener_calendario(&$fecmes, &$fecano)
{

  $dias_sorteo = [];
  $dias_calendario = [];

  // Controlos principales.
  if (!$fecmes || $fecmes > 12 || $fecmes < 1) {
    $fecmes = date("n", time());
  }
  if (!$fecano || $fecano < 2000 || $fecano > 2100) {
    $fecano = date("Y", time());
  }

  $diaini = "01-" . $fecmes . "-" . $fecano . " 00:00:00";
  $diaini = convierte_fecha($diaini, "d-m-Y") . " 00:00:00";

  $diafin = ultimo_dia_mes($fecmes, $fecano) . "-" . $fecmes . "-" . $fecano . " 00:00:00";
  $diafin = convierte_fecha($diafin, "d-m-Y") . " 00:00:00";

  // Leer los días con sorteo del mes.
  //$misql = "SELECT DATE_FORMAT(fecha,'%d') as dfecha FROM numapuesta WHERE fecha >= STR_TO_DATE('" . $diaini . "' , '%d-%m-%Y %H:%i:%s') and  fecha <= STR_TO_DATE('" . $diafin . "' , '%d-%m-%Y %H:%i:%s') ORDER by fecha";
  $misql = "SELECT * FROM numapuesta WHERE fecha >= STR_TO_DATE('" . $diaini . "' , '%d-%m-%Y %H:%i:%s') and  fecha <= STR_TO_DATE('" . $diafin . "' , '%d-%m-%Y %H:%i:%s') ORDER by fecha";
  $datos = consulta($misql);

  while ($myrow = fetch_array($datos)) {

    $dia_base = date('d', strtotime($myrow['fecha']));

    $datos_apuestas = obtener_apuestas($myrow);

    $dias_sorteo[] =  [
      'dia' => $dia_base,
      'datos' => $datos_apuestas
    ];
  }

  // Generamos el calendario.
  // Primer día del mes.
  $diasemana = date('N', strtotime($diaini));

  // Día de proceso.
  $dia_actual = 1;

  // Primera semana.
  for ($i = 0; $i < 7; $i++) {
    if ($i < $diasemana) {
      $dias_calendario[] = [
        'dia'    => "",
        'hoy'    => "",
        'enlace' => ""
      ];
    } else {
      $tipo_dia = obtener_tipo_dia($dia_actual, $fecmes, $fecano, $dias_sorteo);
      $dias_calendario[] = [
        'dia'    => $dia_actual,
        'hoy'    => ($tipo_dia == "hoy") ? $tipo_dia : "",
        'enlace' => ($tipo_dia == "sorteo") ? $tipo_dia : "",
        'festivo' => ($tipo_dia == "festivo") ? $tipo_dia : ""
      ];
      $dia_actual++;
    }
  }

  // Resto de semanas.
















  /* liberar el conjunto de resultados */
  mysqli_free_result($datos);

  return $dias_sorteo;
}
