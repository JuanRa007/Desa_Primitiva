<?php

// Obtiene el úlitmo día con apuestas.
// Se usa para los valores que se muestran en "inicio".
function leer_ultimo_dia()
{

  $misql = "SELECT * FROM numapuesta order by fecha desc LIMIT 1";
  $misql = escape($misql);
  $datos = consulta($misql);
  $row = fetch_array($datos);

  /* liberar el conjunto de resultados */
  mysqli_free_result($datos);

  return $row;
}


// Obtiene la fecha de la última aportación realizada.
// Se usa para mostrar la fecha de actualización en "saldos".
function obtener_saldos_fecha()
{
  $fecha_base = date("d/m/Y");

  $misql = "SELECT MAX(fecha) as totfecha FROM aportaciones LIMIT 1";
  $misql = escape($misql);
  $datos = consulta($misql);
  $row = fetch_array($datos);

  if ($row) {
    $fecha_base = date("d/m/Y", strtotime($row['totfecha']));
  }

  /* liberar el conjunto de resultados */
  mysqli_free_result($datos);

  return $fecha_base;
}


// Obtener los saldos actuales de los participantes.
// Se usa para montar la pantalla de "saldos".
function obtener_saldos()
{

  $array_saldos[] = "";
  $cestillo_saldo = 0;

  // Obtenemos los nombres de los participantes.
  $misql = "SELECT participante FROM participantes order by participante";
  $misql = escape($misql);
  $datos = consulta($misql);

  foreach ($datos as $participante) {

    $persona_saldo = $participante['participante'];
    //echo $persona_saldo . "<br>";

    $misql1 = 'SELECT SUM(importe) as totsaldo, MAX(fecha) as totfecha FROM aportaciones WHERE participante = "' . $persona_saldo . '"';
    $datos1 = consulta($misql1);
    $row1 = fetch_array($datos1);

    $importe_saldo = $row1['totsaldo'];
    $fecha_saldo = $row1['totfecha'];

    $array_saldos[] = [$persona_saldo, $importe_saldo, $fecha_saldo];

    $cestillo_saldo += $importe_saldo;
  }

  $array_saldos[] = ['Cestillo', $cestillo_saldo, $fecha_saldo];

  /* liberar el conjunto de resultados */
  mysqli_free_result($datos);
  mysqli_free_result($datos1);

  return $array_saldos;
}
