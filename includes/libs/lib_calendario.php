<?php

/////////////////////////////
//                         //
//  FUNCIONES  CALENDARIO  //
//                         //
/////////////////////////////

function obtener_calendario($fecmes, $fecano)
{

  $dias_sorteo = [];

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
  $misql = "SELECT DATE_FORMAT(fecha,'%d') as dfecha FROM numapuesta WHERE fecha >= STR_TO_DATE('" . $diaini . "' , '%d-%m-%Y %H:%i:%s') and  fecha <= STR_TO_DATE('" . $diafin . "' , '%d-%m-%Y %H:%i:%s') ORDER by fecha";
  $datos = consulta($misql);

  while ($myrow = fetch_array($datos)) {
    $dias_sorteo[] = $myrow['dfecha'];
  }

  //echo "<br><pre><code>";
  //while ($myrow = fetch_array($datos)) {
  //  echo $myrow['dfecha'] . "<br>";
  //}
  //echo print_r($dias_sorteo);
  //echo "</code></pre><br>";

  /* liberar el conjunto de resultados */
  mysqli_free_result($datos);

  return $dias_sorteo;
}
