<?php

/////////////////////////////
//                         //
//  FUNCIONES   GENERALES  //
//                         //
/////////////////////////////


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

// Genera un literal con la tabla de fechas.
function genera_texto_fecha($array_fecha)
{

  $texto = "";

  if (is_array($array_fecha)) {
    $j = count($array_fecha);
    foreach ($array_fecha as $indice => $valor) {
      if (!$texto) {
        $texto = $valor;
      } else {
        $texto = $texto . " - " . $valor;
      }
    }
  } else {
    $texto = $array_fecha;
  }
  return $texto;
}


// Genera texto con el importe del premio.
function genera_texto_importe($premio)
{

  $str_importe = "";

  if ($premio) {
    $str_importe = number_format(sprintf("%01.2f", $premio), 2, ',', '.');
  }

  return $str_importe;
}


// Obtenie los valores para las fechas del euromillon.
function obtener_valor_marvie($marvie)
{

  $tipo_fecha = "";

  if (!$marvie || $marvie == "") {
    $marvie = "V";
  }
  // Por defecto, martes y viernes.
  switch ($marvie) {
    case 'V':
      $tipo_fecha = "diavie";
      break;
    case 'M':
      $tipo_fecha = "diamar";
      break;
    default:
      $tipo_fecha = "marvie";
      break;
  }

  return $tipo_fecha;
}


// Obtener la fecha del sorteo en base a la fecha dada.
function obtener_fecha_sorteo($tipo, $fecha)
{

  // Inicializar variables.
  $fechas_proceso = [];
  $diasumres = 0;
  $opesumres = "";

  // Obtenemos el día de la semana.
  $diasemana = date("N", strtotime($fecha));

  // En función del tipo enviado.
  switch ($tipo) {
    case 'juesab':
      if ($diasemana < 4) {
        // Incrementamos el día hasta ser jueves.
        $diasumres = (4 - $diasemana);
        $opesumres = "+";
      } elseif ($diasemana > 4) {
        // Decrementamos el día hasta ser jueves.
        $diasumres = ($diasemana - 4);
        $opesumres = "-";
      }

      if ($diasumres) {
        $fecha_new = date("d/m/Y", strtotime($fecha . $opesumres . $diasumres . " days"));
      } else {
        $fecha_new = convierte_fecha($fecha);
      }
      //echo "Dia Semana ["  . $fecha . "---" . $fecha_ant . "] => " . $diasemana . ".<br>";
      //exit();
      $fechas_proceso[] = $fecha_new;

      // Ahora el sábado siguiente.
      $diasumres += 2;
      $opesumres = "+";
      $fecha_new = date("d/m/Y", strtotime($fecha . $opesumres . $diasumres . " days"));
      $fechas_proceso[] = $fecha_new;
      break;

    case 'diamar':
      # code...
      break;

    case 'diavie':
      # code...
      break;

    case 'marvie':
      if ($diasemana < 2) {
        // Incrementamos el día hasta ser martes.
        $diasumres = (2 - $diasemana);
        $opesumres = "+";
      } elseif ($diasemana > 2) {
        // Decrementamos el día hasta ser martes.
        $diasumres = ($diasemana - 2);
        $opesumres = "-";
      }
      if ($diasumres) {
        $fecha_new = date("d/m/Y", strtotime($fecha . $opesumres . $diasumres . " days"));
      } else {
        $fecha_new = convierte_fecha($fecha);
      }
      //echo "Dia Semana ["  . $fecha . "---" . $fecha . "] => " . $diasemana . ".<br>";
      //exit();
      $fechas_proceso[] = $fecha_new;

      // Ahora el viernes siguiente.
      $diasumres += 3;
      $opesumres = "+";
      $fecha_new = date("d/m/Y", strtotime($fecha . $opesumres . $diasumres . " days"));
      $fechas_proceso[] = $fecha_new;
      break;

    default:
      # code...
      break;
  }

  return $fechas_proceso;
}

// Prepara los números de las apuesta y su reintegro.
function obtener_numeros_sorteo($numeros)
{

  // Inicializamos los valores.
  $num_serie = [];

  // Como separador de las apuestas está el carécter "/"
  $series_num = explode("/", $numeros);
  //echo "Serie_NUM:" . print_r($series_num) . "<br>";

  foreach ($series_num as $serie) {
    //echo "Serie:" . trim($serie) . "<br>";

    $num_serie[] = explode("-", trim($serie));
  }

  return $num_serie;
}


/////////////////////////////
//                         //
//  FUNCIONES PRINCIPALES  //
//                         //
/////////////////////////////


// Obtenemos todas las apuestas incluidas
// en el registro pasado.
function obtener_apuestas($registro)
{

  // Inicializamos los valores.
  $mis_apuestas = [];

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
    /*
    echo $reg_fecha . "<br>";
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
    echo $reg_marvie . "<br>";
    */
    //===================================================

    // Prepara $reg_numfijo
    $mi_apuesta = prepara_primtiva_fija($reg_fecha, $reg_numfijo, $reg_numfijor, $reg_premio);

    if ($mi_apuesta) {
      $mis_apuestas['primifija'] = $mi_apuesta;
    }

    // Prepara $reg_numvari
    $mi_apuesta = prepara_primtiva_vari($reg_fecha, $reg_numvari, $reg_numvarir, $reg_numvari1, $reg_numvari1r);
    if ($mi_apuesta) {
      $mis_apuestas['primisema'] = $mi_apuesta;
    }

    // Prepara $reg_euromillon
    $mi_apuesta = prepara_euromillones_vari($reg_fecha, $reg_euromillon, $reg_euroruno, $reg_eurordos, $reg_euromillon1, $reg_euroruno1, $reg_eurordos1, $reg_marvie);
    if ($mi_apuesta) {
      $mis_apuestas['euromvari'] = $mi_apuesta;
    }
  }

  return $mis_apuestas;
}


////////////////////////////////
// Prepara el campo "numfijo" //
////////////////////////////////
function prepara_primtiva_fija($fecha, $numeros, $reintegro, $premio)
{

  // Incializar variable a devolver.
  $apuesta_fija = [];

  // numeros => 03-13-23-32-33-43 / 09-17-19-29-39-49
  if ($fecha && isset($fecha) && $numeros && isset($numeros) && $reintegro && isset($reintegro)) {

    // Premio.
    if ($premio && isset($premio)) {
      $imp_premio = number_format(sprintf("%01.2f", $premio), 2, ',', '.');
    }

    // Buscar el jueves y sábado de la fecha indicada.
    $fecha_juesab = obtener_fecha_sorteo("juesab", $fecha);

    //echo "<br>";
    //echo print_r($fecha_juesab);
    //echo "<br>";

    // Obtener apuestas.
    $num_sorteo = obtener_numeros_sorteo($numeros);
    $reintegros = [$reintegro, $reintegro];

    //echo "<br>";
    //echo print_r($num_sorteo);
    //echo "<br>";

    $apuesta_fija[] = [
      'titulo'     => "Primitiva Fija Semanal",
      'subtitulo'  => "Martes y Jueves",
      'color'      => "bg-success",
      'fechas'     => $fecha_juesab,
      'imagen'     => "b_primitiva.png",
      'icono'      => "icon-PrimitivaAJ",
      'numeros'    => $num_sorteo,
      'reintegros' => $reintegros,
      'premio'     => $imp_premio
    ];
  }

  return $apuesta_fija;
}

//////////////////////////////////
// Prepara los campos "numvari" //
//////////////////////////////////
function prepara_primtiva_vari($fecha, $numvari, $numvarir, $numvari1, $numvari1r)
{

  // Incializar variable a devolver.
  $apuesta_fija = [];

  if ($fecha && isset($fecha) && $numvari && isset($numvari) && $numvarir && isset($numvarir)) {

    // Buscar el jueves y sábado de la fecha indicada.
    $fecha_juesab = obtener_fecha_sorteo("juesab", $fecha);
    $reintegros[] = $numvarir;

    // Obtener apuestas.
    if ($numvari1 && isset($numvari1) && $numvari1r && isset($numvari1r)) {
      $numvari = $numvari . " / " . $numvari1;
      $reintegros[] = $numvari1r;
    }
    $num_sorteo = obtener_numeros_sorteo($numvari);

    $apuesta_fija[] = [
      'titulo'     => "Primitiva Semanal",
      'subtitulo'  => "Martes y Jueves",
      'color'      => "bg-success",
      'fechas'     => $fecha_juesab,
      'imagen'     => "b_primitiva.png",
      'icono'      => "icon-PrimitivaAJ",
      'numeros'    => $num_sorteo,
      'reintegros' => $reintegros,
      'premio'     => ""
    ];
  }

  return $apuesta_fija;
};

/////////////////////////////////////
// Prepara los campos "euromillon" //
/////////////////////////////////////
function prepara_euromillones_vari($fecha, $euromillon, $euroruno, $eurordos, $euromillon1, $euroruno1, $eurordos1, $marvie)
{

  // Incializar variable a devolver.
  $apuesta_fija = [];
  // Controlar "marvie"
  $tipo_fecha = obtener_valor_marvie($marvie);

  if ($fecha && isset($fecha) && $euromillon && isset($euromillon) && $euroruno && isset($euroruno) && $eurordos && isset($eurordos)) {

    // Buscar el jueves y sábado de la fecha indicada.
    $fecha_marvie = obtener_fecha_sorteo($tipo_fecha, $fecha);

    // Formateamos los reintegros a dos números.
    $euroruno = number_format($euroruno, 0, ',', '.');
    if (strlen($euroruno) == 1) {
      $euroruno = '0' . $euroruno;
    }
    $eurordos = number_format($eurordos, 0, ',', '.');
    if (strlen($eurordos) == 1) {
      $eurordos = '0' . $eurordos;
    }
    $reintegros[] = $euroruno . " - " . $eurordos;

    // Obtener apuestas.
    if ($euromillon1 && isset($euromillon1) && $euroruno1 && isset($euroruno1) && $eurordos1 && isset($eurordos1)) {
      $euromillon = $euromillon . " / " . $euromillon1;
      // Formateamos los reintegros a dos números.
      $euroruno1 = number_format($euroruno1, 0, ',', '.');
      if (strlen($euroruno1) == 1) {
        $euroruno1 = '0' . $euroruno1;
      }
      $eurordos1 = number_format($eurordos1, 0, ',', '.');
      if (strlen($eurordos1) == 1) {
        $eurordos1 = '0' . $eurordos1;
      }

      $reintegros[] = $euroruno1 . " - " . $eurordos1;
    }
    $num_sorteo = obtener_numeros_sorteo($euromillon);

    $apuesta_fija[] = [
      'titulo'     => "Euromillones",
      'subtitulo'  => "Martes y Viernes",
      'color'      => "bg-primary",
      'fechas'     => $fecha_marvie,
      'imagen'     => "b_euromillones.png",
      'icono'      => "icon-EuromillonesAJ",
      'numeros'    => $num_sorteo,
      'reintegros' => $reintegros,
      'premio'     => ""
    ];
  }

  return $apuesta_fija;
}
