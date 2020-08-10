<?php

/* CONNECTION INSTANCE */
$connection = new mysqli($host, $user, $pass, $dbname);

if ($connection->connect_errno) {
  echo "Fallo al conectar a MySQL: (" . $connection->connect_errno . ") " . $connection->connect_error;
}

/* printf("Conjunto de caracteres inicial: %s\n", mysqli_character_set_name($connection)); */

/* cambiar el conjunto de caracteres a utf8 */
if (!mysqli_set_charset($connection, "utf8")) {
  printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($connection));
  exit();
}

/* FUNCIONES DB */
function escape($string)
{
  global $connection;

  return mysqli_real_escape_string($connection, $string);
}

function confirm($result)
{
  global $connection;

  if (!$result) {

    die("QUERY FAILED" . mysqli_error($connection));
  }
}

function consulta($query)
{
  global $connection;

  $result =  mysqli_query($connection, $query);

  confirm($result);

  return $result;
}

function fetch_array($result)
{
  global $con;

  return mysqli_fetch_array($result);
}
