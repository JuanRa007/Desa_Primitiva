<?php

function leer_ultimo_dia()
{

  $misql = "SELECT * FROM numapuesta order by fecha desc LIMIT 1";
  $misql = escape($misql);
  $datos = consulta($misql);
  $row = fetch_array($datos);

  return $row;
}

$apuesta = leer_ultimo_dia();

/* var_dump($apuesta);
exit(); */
