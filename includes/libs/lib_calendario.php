<?php

/////////////////////////////
//                         //
//  FUNCIONES  CALENDARIO  //
//                         //
/////////////////////////////

function obtener_calendario(&$fecmes, &$fecano)
{

  // Días con sorteos en el mes buscado.
  $dias_sorteo = [];

  // Calendario completo con explicación de cada día.
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

  $dia_fin_mes = ultimo_dia_mes($fecmes, $fecano);
  $diafin = $dia_fin_mes . "-" . $fecmes . "-" . $fecano . " 00:00:00";
  $diafin = convierte_fecha($diafin, "d-m-Y") . " 00:00:00";

  // Leer los días con sorteo del mes.
  // $misql = "SELECT DATE_FORMAT(fecha,'%d') as dfecha FROM numapuesta WHERE fecha >= STR_TO_DATE('" . $diaini . "' , '%d-%m-%Y %H:%i:%s') and  fecha <= STR_TO_DATE('" . $diafin . "' , '%d-%m-%Y %H:%i:%s') ORDER by fecha";
  $misql = "SELECT DATE_FORMAT(fecha,'%d') as dfecha FROM numapuesta WHERE fecha >= STR_TO_DATE('" . $diaini . "' , '%d-%m-%Y %H:%i:%s') and  fecha <= STR_TO_DATE('" . $diafin . "' , '%d-%m-%Y %H:%i:%s') ORDER by fecha";
  $datos = consulta($misql);

  while ($myrow = fetch_array($datos)) {

    //$dia_base = date('d', strtotime($myrow['fecha']));
    //$datos_apuestas = obtener_apuestas($myrow);

    $dias_sorteo[] =  $myrow['dfecha'];
  }


  //echo "<br><pre><code>";
  //while ($myrow = fetch_array($datos)) {
  //  echo $myrow['dfecha'] . "<br>";
  //}
  //echo print_r($dias_sorteo);
  //echo "</code></pre><br>";


  // Generamos el calendario.
  // Primer día del mes.
  $diasemana = date('N', strtotime($diaini));

  // Día de proceso.
  $dia_actual = 1;

  // Primera semana.
  for ($i = 1; $i <= 7; $i++) {
    if ($i < $diasemana) {
      $dias_calendario[] = [
        'dia'    => "",
        'hoy'    => "",
        'enlace' => "",
        'festivo' => ""
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

  $dia_semana = 1;
  // Resto de semanas.
  while ($dia_actual <= $dia_fin_mes) {

    $tipo_dia = obtener_tipo_dia($dia_actual, $fecmes, $fecano, $dias_sorteo);
    $dias_calendario[] = [
      'dia'    => $dia_actual,
      'hoy'    => ($tipo_dia == "hoy") ? $tipo_dia : "",
      'enlace' => ($tipo_dia == "sorteo") ? $tipo_dia : "",
      'festivo' => ($tipo_dia == "festivo") ? $tipo_dia : ""
    ];
    $dia_actual++;
    $dia_semana++;
    if ($dia_semana > 7) {
      $dia_semana = 1;
    }
  }

  // Terminamos los días.
  for ($i = $dia_semana; $i <= 7; $i++) {
    $dias_calendario[] = [
      'dia'    => "",
      'hoy'    => "",
      'enlace' => "",
      'festivo' => ""
    ];
  }

  /* liberar el conjunto de resultados */
  mysqli_free_result($datos);

  return $dias_calendario;
}


// Devuelve los select para los meses del año.
// Los valores sin la etiqueta "select".
function obtener_select_meses($mes = 0)
{

  $valores = "";
  if ($mes === 0) {
    $mes = date("n", time());
  }

  for ($i = 1; $i < 13; $i++) {

    $valores .= '<option value="' . $i . '"';
    if ($mes == $i) {
      $valores .= ' selected';
    }
    $valores .= '>' . obtener_nombre_mes($i) . '</option>';
  }

  return $valores;
}

// Devuelve los select para los años.
// Los valores sin la etiqueta "select".
function obtener_select_anos($ano)
{

  global $rangoanoini, $rangoanofin;

  $valores = "";
  if ($ano === 0) {
    $ano = date("Y", time());
  }

  for ($i = $rangoanoini; $i <= $rangoanofin; $i++) {

    $valores .= '<option value="' . $i . '"';
    if ($ano == $i) {
      $valores .= ' selected';
    }
    $valores .= '>' . $i . '</option>';
  }

  return $valores;
}
