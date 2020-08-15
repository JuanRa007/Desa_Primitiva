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


// Convierte una fecha de BBDD a formato simple.
function convierte_fecha($fecha_recibida)
{

  if (!$fecha_recibida) {
    $fecha_recibida = date("d/m/Y");
  }

  return date("d/m/Y", strtotime($fecha_recibida));
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
    //$fecha_base = date("d/m/Y", strtotime($row['totfecha']));
    $fecha_base = convierte_fecha($row['totfecha']);
  }

  /* liberar el conjunto de resultados */
  mysqli_free_result($datos);

  return $fecha_base;
}


// Obtener los saldos actuales de los participantes.
// Se usa para montar la pantalla de "saldos".
function obtener_saldos()
{

  $cestillo_saldo = 0;
  $fecha_saldo = date("d/m/Y");

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

    // $e=array[];
    // $e['totparti']=$persona_saldo;
    // $e['totsaldo']=$importe_saldo;
    // $e['totfecha']=$fecha_saldo;
    // $array_saldos[] = $e;

    $array_saldos[] = [$persona_saldo, $importe_saldo, $fecha_saldo];

    $cestillo_saldo += $importe_saldo;
  }

  $array_saldos[] = ['Cestillo', $cestillo_saldo, $fecha_saldo];

  /* liberar el conjunto de resultados */
  mysqli_free_result($datos);
  mysqli_free_result($datos1);

  return $array_saldos;
}


// Obtenemos todas las apuestas incluidas
// en el registro pasado.
function obtener_apuestas($registro)
{

  // Si no llega nada.
  if ($registro && isset($registro)) {

    // Fecha apuesta
    $reg_fecha = $registro['fecha'];

    // Primitiva Fija Semanal
    $reg_numfijo = $registro['numfijo'];
    $reg_numfijor = $registro['numfijor'];

    // Primitiva Expecial
    $reg_numvari = $registro['numvari'];
    $reg_numvarir = $registro['numvarir'];

    // Euromillón
    $reg_euromillon = $registro['euromillon'];
    $reg_euroruno = $registro['euroruno'];
    $reg_eurordos = $registro['eurordos'];

    // Otras apuestas.
    $reg_otros = $registro['otros'];

    // Euromillón segundo
    $reg_euromillon1 = $registro['euromillon1'];
    $reg_euroruno1 = $registro['euroruno1'];
    $reg_eurordos1 = $registro['eurordos1'];

    // Primitiva Expecial segunda
    $reg_numvari1 = $registro['numvari1'];
    $reg_numvari1r = $registro['numvari1r'];

    // Premio.
    $reg_premio = $registro['premio'];

    // Euromillón: sólo viernes, sólo martes, semanal.
    $reg_marvie = $registro['marvie'];

    //===================================================
    /*     echo $reg_fecha . "<br>";
    echo $reg_numfijo . "<br>";
    echo $reg_numfijor . "<br>";
    echo $reg_numvari . "<br>";
    echo $reg_numvarir . "<br>";
    echo $reg_euromillon . "<br>";
    echo $reg_euroruno . "<br>";
    echo $reg_eurordos . "<br>";
    echo $reg_otros . "<br>";
    echo $reg_euromillon1 . "<br>";
    echo $reg_euroruno1 . "<br>";
    echo $reg_eurordos1 . "<br>";
    echo $reg_numvari1 . "<br>";
    echo $reg_numvari1r . "<br>";
    echo $reg_premio . "<br>";
    echo $reg_marvie . "<br>"; */
    //===================================================

    // Prepara $reg_numfijo



  }
}
