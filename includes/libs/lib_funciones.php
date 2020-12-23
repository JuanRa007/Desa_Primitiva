<?php

/////////////////////////////
//                         //
//  FUNCIONES   GENERALES  //
//                         //
/////////////////////////////


// Obtiene el úlitmo día con apuestas o el día pasado por parámetro.
// Se usa para los valores que se muestran en "inicio".
function leer_apuesta_dia($fecha_dia = "")
{

  // Si no nos llega un fecha o es incorrecta, buscamos el más nuevo,
  // Si nos llega un fecha válida, devolvemos ese día.
  if ($fecha_dia) {
    $misql = "SELECT * FROM numapuesta WHERE fecha = '$fecha_dia'";
  } else {
    $misql = "SELECT * FROM numapuesta order by fecha desc LIMIT 1";
  }
  $datos = consulta($misql);
  $row = fetch_array($datos);

  /* liberar el conjunto de resultados */
  mysqli_free_result($datos);

  return $row;
}

// Obtenemos el literal del mes.
function obtener_nombre_mes($mes)
{

  // Meses
  $lit_meses = ['[ERROR]', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

  return $lit_meses[$mes];
}

// Obtenemos el literal del día de hoy.
function obtener_nombre_dia($dia)
{

  // Días
  $lit_meses = array("Mon" => "lunes", "Tue" => "martes", "Wed" => "miércoles", "Thu" => "jueves", "Fri" => "viernes", "Sat" => "sábado", "Sun" => "domingo",);

  return $lit_meses[$dia];
}

// Devolvemos el literal del mes y año.
function obtener_nombre_mes_ano($mes, $ano)
{

  // Control
  $mes = intval($mes);
  if (!$mes || $mes === 0 || $mes > 12) {
    $mes = date("n", time());
  }
  // Mes
  $tex_mes = obtener_nombre_mes($mes);
  if (!$ano || $ano === 0 || strlen($ano) < 4) {
    $ano = date("Y", time());
  }
  // Año
  $tex_ano = $ano;

  return $tex_mes . " - " . $tex_ano;
}


// Convierte una fecha de BBDD a formato simple.
function convierte_fecha($fecha_recibida, $formato = "d/m/Y")
{

  if (!$fecha_recibida) {
    $fecha_recibida = date($formato);
  }

  return date($formato, strtotime($fecha_recibida));
}

// 
function fecha_diferencia($fecha_apuesta)
{

  // Incializamos.
  $diferencia = 0;

  // Convertimos la fecha pasada a formato para diff
  $fecha_apu = convierte_fecha($fecha_apuesta, "Y-m-d");
  $fecha_hoy = convierte_fecha(date("Y-m-d"), "Y-m-d");

  // Restamos ambas fechas
  $datetime_apu = date_create($fecha_apu);
  $datetime_hoy = date_create($fecha_hoy);
  $interval = date_diff($datetime_apu, $datetime_hoy);

  return $interval->format('%R%a días');
}

// Ultimo día para el mes y año dado.
function ultimo_dia_mes($fecmes, $fecano)
{
  $ultimo_dia = 28;
  while (checkdate($fecmes, $ultimo_dia + 1, $fecano)) {
    $ultimo_dia++;
  }
  return $ultimo_dia;
}


// Obtenemos qué tipo de día es para el calendario.
function obtener_tipo_dia($dia_actual, $mes_actual, $ano_actual, $dias_sorteo)
{

  // Inicializar.
  $mensa = "";

  // Día de hoy.
  $dia_hoy = date('d');
  $mes_hoy = date('m');
  $ano_hoy = date('Y');

  $fecha_mirar = mktime(12, 0, 0, $mes_actual, $dia_actual, $ano_actual);
  // Buscamos el tipo de día.
  if ($dia_actual == $dia_hoy && $mes_actual == $mes_hoy && $ano_actual == $ano_hoy) {
    $mensa = "hoy";
  } elseif (in_array($dia_actual, $dias_sorteo)) {
    $mensa = "sorteo";
  } elseif (date("N", $fecha_mirar) > 5) {
    $mensa = "festivo";
  } else {
    $mensa = "diario";
  }

  return $mensa;
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

    $misql1 = "SELECT SUM(importe) as totsaldo, MAX(fecha) as totfecha FROM aportaciones WHERE participante = '$persona_saldo'";
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

// Genera un literal con la tabla de fechas.
function genera_texto_fecha($array_fecha, $tipo_apuesta = "")
{

  // Inicializamos.
  $texto = "";
  $separador = " y ";

  // Si es una apuesta especial, la fecha es de un día a otro.
  if ($tipo_apuesta == 'bonoloto') {
    $separador = " al ";
  }

  if (is_array($array_fecha)) {
    foreach ($array_fecha as $indice => $valor) {
      if (!$texto) {
        $texto = $valor;
      } else {
        $texto = $texto . $separador . $valor;
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
function obtener_valor_marvie($marvie, &$subtitul)
{

  $tipo_fecha = "";

  if (!$marvie || $marvie == "") {
    $marvie = "V";
  }
  // Por defecto, martes y viernes.
  switch ($marvie) {
    case 'V':
      $tipo_fecha = "diavie";
      $subtitul   = "Viernes";
      break;
    case 'M':
      $tipo_fecha = "diamar";
      $subtitul   = "Martes";
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
      $fechas_proceso[] = $fecha_new;

      // Ahora el sábado siguiente.
      $diasumres += 2;
      $opesumres = "+";
      $fecha_new = date("d/m/Y", strtotime($fecha . $opesumres . $diasumres . " days"));
      $fechas_proceso[] = $fecha_new;
      break;

    case 'diamar':
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
      $fechas_proceso[] = $fecha_new;
      break;

    case 'diavie':
      if ($diasemana < 5) {
        // Incrementamos el día hasta ser viernes.
        $diasumres = (5 - $diasemana);
        $opesumres = "+";
      } elseif ($diasemana > 5) {
        // Decrementamos el día hasta ser viernes.
        $diasumres = ($diasemana - 5);
        $opesumres = "-";
      }
      if ($diasumres) {
        $fecha_new = date("d/m/Y", strtotime($fecha . $opesumres . $diasumres . " days"));
      } else {
        $fecha_new = convierte_fecha($fecha);
      }
      $fechas_proceso[] = $fecha_new;
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
      $fechas_proceso[] = $fecha_new;

      // Ahora el viernes siguiente.
      $diasumres += 3;
      $opesumres = "+";
      $fecha_new = date("d/m/Y", strtotime($fecha . $opesumres . $diasumres . " days"));
      $fechas_proceso[] = $fecha_new;
      break;

    default:
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

  foreach ($series_num as $serie) {
    //echo "Serie:" . trim($serie) . "<br>";

    $num_serie[] = explode("-", trim($serie));
  }

  return $num_serie;
}

// Obtenemos el nombre y ubicación del fichero de decimo.
function obtener_nombre_fichero_decimo($fecha, $fontral)
{

  // Traemos variables globales.
  global $app_direct;

  // Definimos la ubicación.
  $ubicacion = "decimos/";
  $nombre_fich_404 = "404.png";

  // Tratamos la fecha: 22/12/2020
  $nombre_fich = substr($fecha, 6, 4) . "-" . substr($fecha, 3, 2) . "-" . substr($fecha, 0, 2);

  // Añadimos lo último
  $nombre_fich = $ubicacion . $nombre_fich . "_decimo";
  if ($fontral) {
    $nombre_fich = $nombre_fich . "f.jpg";
  } else {
    $nombre_fich = $nombre_fich . "t.jpg";
  }

  // Determinamos si existe el fichero.
  if (!file_exists($nombre_fich)) {
    $nombre_fich = $ubicacion . $nombre_fich_404;
  }

  return $nombre_fich;
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
  global $app_prod;

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
    if (!$app_prod) {
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
    }
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

    // Prepara $reg_otros
    $mi_apuesta = prepara_bloque_otros($reg_fecha, $reg_otros);
    if ($mi_apuesta) {
      foreach ($mi_apuesta as $otro_tipo => $otro_apuesta) {
        $mis_apuestas[$otro_tipo] = $otro_apuesta;
      }
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
  $imp_premio = 0;

  // numeros => 03-13-23-32-33-43 / 09-17-19-29-39-49
  // if ($fecha && isset($fecha) && $numeros && isset($numeros) && $reintegro && isset($reintegro)) {
  if ($fecha && isset($fecha) && $numeros && isset($numeros) && isset($reintegro)) {

    // Premio.
    if ($premio && isset($premio)) {
      $imp_premio = number_format(sprintf("%01.2f", $premio), 2, ',', '.');
    }

    // Buscar el jueves y sábado de la fecha indicada.
    $fecha_juesab = obtener_fecha_sorteo("juesab", $fecha);

    // Obtener apuestas.
    $num_sorteo = obtener_numeros_sorteo($numeros);
    $reintegros = [$reintegro, $reintegro];

    $apuesta_fija[] = [
      'titulo'     => "Primitiva Fija Semanal",
      'subtitulo'  => "Jueves y Sábado",
      'color'      => "success",
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
      'subtitulo'  => "Jueves y Sábado",
      'color'      => "success",
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
function prepara_euromillones_vari($fecha, $euromillon, $euroruno, $eurordos, $euromillon1, $euroruno1, $eurordos1, $marvie, $especial = false)
{

  // Incializar variable a devolver.
  $apuesta_fija = [];
  $fecha_pro = "";
  $strtitulo = "Euromillones";
  $strsubtitulo = "Martes y Viernes";

  // Controlar el título.
  if ($especial) {
    $strtitulo = "Euromillones Especial";
  }

  // Controlar "marvie"
  $tipo_fecha = obtener_valor_marvie($marvie, $strsubtitulo);

  if ($fecha && isset($fecha) && $euromillon && isset($euromillon) && $euroruno && isset($euroruno) && $eurordos && isset($eurordos)) {

    // Buscar el martes y viernes de la fecha indicada.
    // En "$fecha" nos puede llegar una tabla.
    if (is_array($fecha)) {
      $fecha_pro = $fecha[0];
    } else {
      $fecha_pro = $fecha;
    }
    $fecha_marvie = obtener_fecha_sorteo($tipo_fecha, $fecha_pro);

    // Formateamos los reintegros a dos números.
    // En "$euromillon"/"$euroruno"/"$eurordos" nos pueden llegar una tabla.
    if (is_array($euroruno)) {
      $euromillon_pro = "";
      for ($i = 0; $i < count($euroruno); $i++) {
        $reintegros[] = $euroruno[$i] . " - " . $eurordos[$i];
      }
      for ($i = 0; $i < count($euromillon); $i++) {
        if ($i < 1) {
          $euromillon_pro = $euromillon[$i];
        } else {
          $euromillon_pro = $euromillon_pro . " / " . $euromillon[$i];
        }
      }
    } else {
      $euromillon_pro =  $euromillon;
      $euroruno = number_format($euroruno, 0, ',', '.');
      if (strlen($euroruno) == 1) {
        $euroruno = '0' . $euroruno;
      }
      $eurordos = number_format($eurordos, 0, ',', '.');
      if (strlen($eurordos) == 1) {
        $eurordos = '0' . $eurordos;
      }
      $reintegros[] = $euroruno . " - " . $eurordos;
    }

    // Obtener apuestas.
    if ($euromillon1 && isset($euromillon1) && $euroruno1 && isset($euroruno1) && $eurordos1 && isset($eurordos1)) {
      $euromillon_pro =  $euromillon_pro . " / " . $euromillon1;
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
    $num_sorteo = obtener_numeros_sorteo($euromillon_pro);
    $apuesta_fija[] = [
      'titulo'     => $strtitulo,
      'subtitulo'  => $strsubtitulo,
      'color'      => "primary",
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

/////////////////////////////////////
// Prepara para el valor "Décimo"  //
/////////////////////////////////////
function prepara_decimo_fijo($cadena, $fecha_reg)
{

  // Incializar variable a devolver.
  $apuesta_fija = [];
  $afechas_decimo = [];

  // Comprobamos que nos llega algo.
  if ($cadena && isset($cadena)) {

    // Obtenemos la fecha del sorteo.
    $afechas_decimo = f_otros_fechas($cadena);
    $fecha_sorteo = convierte_fecha($afechas_decimo[0]);
    $fecha_fichero = convierte_fecha($fecha_reg);
    $num_sorteo = f_otros_decimo($cadena);
    $reintegros = f_otros_serie_fraccion($cadena); // Serie - Fracción

    $apuesta_fija[] = [
      'titulo'     => "Lotería Nacional",
      'subtitulo'  => "Sorteo de Navidad",
      'color'      => "info",
      'fechas'     => $fecha_sorteo,
      'imagen'     => "b_loteria.png",
      'icono'      => "icon-LoteriaNacionalAJ",
      'numeros'    => $num_sorteo,
      'reintegros' => $reintegros,
      'premio'     => "",
      'nom_fich'   => $fecha_fichero
    ];
  }

  return $apuesta_fija;
}


/////////////////////////////////////
// Prepara el campo bloque "otros" //
/////////////////////////////////////
function prepara_bloque_otros($fecha_reg, $otros)
{
  global $app_prod;

  // Incializar variable a devolver.
  $apuesta_otros = [];
  // Separador.
  $text_separador = "--------";

  if ($fecha_reg && isset($fecha_reg) && $otros && isset($otros)) {

    if (!$app_prod) {
      echo "----> Otros: " . $otros . "<br><br>";
    }

    // Trabajamos con una copia.
    $otros_bak = $otros;
    while (strlen($otros_bak)) {

      // Nos quedamos con la parte hasta $text_separador.
      $pos_final = stripos($otros_bak, $text_separador);
      if ($pos_final !== false) {
        $strmirar = trim(substr($otros_bak, 0, $pos_final));
        $otros_bak = trim(substr($otros_bak, $pos_final + strlen($text_separador)));
      } else {
        $strmirar = trim($otros_bak);
        $otros_bak = "";
      }

      // Buscamos Euromillones.
      //=======================
      $pos1 = stripos($strmirar, "Euromillón");
      if ($pos1 !== false) {

        // Preparamos Euromillones.
        if (!$app_prod) {
          echo "---------------------> [ EUROMILLONES ]<br>";
        }

        // Inicializamos.
        $mi_apuesta = [];

        // Ahora tenemos un string con apuestas de euromillones.
        // Puede haber varias fechas, puede haber varias apuestas.
        $otro_fecha = f_otros_fechas($strmirar);
        $otro_euromillon = f_otros_numeuro($strmirar, $otro_euroruno, $otro_eurordos);
        $otro_euromillon1 = "";
        $otro_euroruno1 = "";
        $otro_eurordos1 = "";
        $otro_marvie = f_otros_marvie($otro_fecha);
        $otro_especial = true;
        $mi_apuesta = prepara_euromillones_vari($otro_fecha, $otro_euromillon, $otro_euroruno, $otro_eurordos, $otro_euromillon1, $otro_euroruno1, $otro_eurordos1, $otro_marvie, $otro_especial);
        if ($mi_apuesta) {
          $apuesta_otros['otroeuromvari'] = $mi_apuesta;
        }

        // Limpiamos la cadena de trabajo.
        $strmirar = "";
      }   // Euromillones - Fin


      // Buscamos Décimo.
      //=======================
      $pos1 = stripos($strmirar, "Décimo");
      if ($pos1 !== false) {

        // Preparamos Décimo.
        if (!$app_prod) {
          echo "---------------------> [ DÉCIMO ]<br>";
        }

        // Inicializamos.
        $mi_apuesta = [];

        // Obtenemos los datos del décimo.
        $mi_apuesta = prepara_decimo_fijo($strmirar, $fecha_reg);
        if ($mi_apuesta) {
          $apuesta_otros['lotnavidad'] = $mi_apuesta;
        }

        // Limpiamos la cadena de trabajo.
        $strmirar = "";
      }   // Décimo - Fin


      // Buscamos Bonoloto.
      //=======================
      $pos1 = stripos($strmirar, "Bonoloto");
      if ($pos1 !== false) {

        // Preparamos Bonoloto.
        if (!$app_prod) {
          echo "---------------------> [ BONOLOTO ]<br>";
        }

        // Obtenemos los datos de la bonoloto.
        $mi_apuesta = prepara_otros_bonoloto($strmirar);
        if ($mi_apuesta) {
          $apuesta_otros['bonoloto'] = $mi_apuesta;
        }

        // Limpiamos la cadena de trabajo.
        $strmirar = "";
      }   // Bonoloto - Fin


      // Buscamos El Gordo.
      //=======================
      $pos1 = stripos($strmirar, "El Gordo");
      if ($pos1 !== false) {

        // Preparamos El Gordo.
        if (!$app_prod) {
          echo "---------------------> [ EL GORDO ]<br>";
        }

        // Obtenemos los datos del Gordo.
        $mi_apuesta = prepara_otros_elgordo($strmirar);
        if ($mi_apuesta) {
          $apuesta_otros['elgordo'] = $mi_apuesta;
        }

        // Limpiamos la cadena de trabajo.
        $strmirar = "";
      }   // El Gordo - Fin










      // Buscamos Once.
      $pos1 = stripos($strmirar, "Once");
      if ($pos1 !== false) {

        // Preparamos Once.
        if (!$app_prod) {
          echo "---------------------> [ ONCE ]<br>";
        }

        // Limpiamos la cadena de trabajo.
        $strmirar = "";
      }   // Once



      // Buscamos PrimitivaE.
      $pos1 = stripos($strmirar, "PrimitivaE");
      if ($pos1 !== false) {

        // Preparamos PrimitivaE.
        if (!$app_prod) {
          echo "---------------------> [ PRIMITIVAE ]<br>";
        }

        // Limpiamos la cadena de trabajo.
        $strmirar = "";
      }   // PrimitivaE



      // Buscamos Aviso.
      $pos1 = stripos($strmirar, "Aviso");
      if ($pos1 !== false) {

        // Preparamos Aviso.
        if (!$app_prod) {
          echo "---------------------> [ AVISO ]<br>";
        }

        // Limpiamos la cadena de trabajo.
        $strmirar = "";
      }   // Aviso



      // Buscamos Desconocido
      if ($strmirar) {
        // Preparamos Desconocido.
        if (!$app_prod) {
          echo "---------------------> [ DESCONOCIDO ]<br>";
        }

        // Limpiamos la cadena de trabajo.
        $strmirar = "";
      }   // Desconocido


    }   // end while
  }

  return $apuesta_otros;
}

/*
/   OTROS: Preparación de las apuestas de Euromillones
/   ==================================================
/
/   Formato:
/   Euromillón (24/11/2020): 05-09-28-29-50 R.06-08 / 03-13-17-36-44 R.05-06 / 01-15-19-45-38 R.01-03 / 20-22-23-28-29 R.03-11 / 04-17-19-44-50 R.04-07 / 01-05-24-40-50 R.06-08
/   Euromillón (30/06/2020 - 03/07/2020):
/
/   1.- Fechas
*/
function f_otros_fechas($strapuesta)
{

  // Inicializamos la variable a devolver.
  $afechas = [];

  // Buscamos el primer paréntesis
  $posa = stripos($strapuesta, "(");
  $posc = stripos($strapuesta, ")");
  $poslen = $posc - $posa - 1;
  $strfecha = trim(substr($strapuesta, $posa + 1, $poslen));
  $aprefechas = explode('-', $strfecha);

  // Tratamos cada fecha a formato de la aplicación.
  foreach ($aprefechas as $key => $value) {
    $value = trim($value);
    $afechas[] = substr($value, 6, 4) . "-" . substr($value, 3, 2) . "-" . substr($value, 0, 2) . " 00:00:00";
  }
  return $afechas;
}

/*
/
/   2.- Apuestas múltiples
*/
function f_otros_numeuro($strapuesta, &$strapureiuno, &$strapureidos)
{

  // Inicializamos la variable a devolver.
  $anumbers = [];
  $reintegros = [];
  $strapureiuno = [];
  $strapureidos = [];

  // Buscamos el separador ":"
  $posa = stripos($strapuesta, ":");
  $strnumber = trim(substr($strapuesta, $posa + 1));
  $aprenumbers = explode('/', $strnumber);

  // Tratamos cada fecha a formato de la aplicación.
  foreach ($aprenumbers as $key => $value) {
    $preint = stripos($value, "R.");
    $anumbers[] = trim(substr($value, 0, $preint - 1));
    $reintegros = explode("-", trim(substr($value, $preint + 2)));
    $strapureiuno[] =  $reintegros[0];
    if (count($reintegros) > 1) {
      $strapureidos[] =  $reintegros[1];
    }
  }

  return $anumbers;
}

/*
/
/   3.- Martes o Viernes o ambos en euromillon.
*/
function f_otros_marvie($afechas)
{

  // Inicializamos la variable a devolver.
  $strtipo = "";

  // Si nos vienen varias fechas es para los dos días.
  if (count($afechas) > 1) {
    $strtipo = "T";
  } else {
    $strtipo = "M";         // TODO: OJO... una fecha puede ser la del martes o del viernes.
  }
  return $strtipo;
}

/*
/   OTROS: Preparación de las apuestas de Décimo
/   ==================================================
/
/   Formato:
/   Décimo (22/12/2019):
/   77689  Série: 140ª  Fracción: 10ª
/
/   1.- Décimo
*/
function f_otros_decimo($strdecimo)
{

  // Inicializamos la variable a devolver.
  $strnumber = "";

  // Buscamos el separador ":"
  $posa = stripos($strdecimo, ":");
  $posb = stripos($strdecimo, "S");
  $poslen = $posb - $posa - 1;
  // Número del décimo.
  $strnumber = trim(substr($strdecimo, $posa + 1, $poslen));

  return $strnumber;
}

/*
/
/   2.- Serie - Fracción.
*/
function f_otros_serie_fraccion($strdecimo)
{
  // Inicializamos la variable a devolver.
  $strnumber = "";
  $strserie = "";
  $strfraccion = "";

  // Textos a buscar.
  $str_serie = "rie:";
  $str_fraccion = "Fracción:";

  // Buscamos la serie
  $posa = stripos($strdecimo, $str_serie);
  // Serie del décimo.
  $strserie = trim(substr($strdecimo, $posa + strlen($str_serie), 6));

  // Buscamos la fracción
  $posa = stripos($strdecimo, $str_fraccion);
  // Serie del décimo.
  $strfraccion = trim(substr($strdecimo, $posa + strlen($str_fraccion)));

  // Una vez obtenidos, los devolvemos como reintegros.
  $strnumber = $strserie . " - " . $strfraccion;

  return $strnumber;
}


/*
/   OTROS: Preparación de las apuestas de Bonoloto
/   ==================================================
/
/   Formato:
/   Bonoloto (08/12/2014 - 12/12/2014):
/   09-11-12-17-31-37   R.2
/   /
/   02-06-08-19-20-40   R.2
/
*/
function prepara_otros_bonoloto($strapuesta)
{

  // Incializar variable a devolver.
  $apuesta_fija = [];
  $bono_runo = "";
  $bono_rdos = "";
  $strtitulo = "Bonoloto";
  $strsubtitulo = "Semanal";

  $bono_fecha = f_otros_fechas($strapuesta);
  // Convertimos cada fecha a forma textual
  foreach ($bono_fecha as $key => $fecha_valor) {
    $bono_fecha[$key] = convierte_fecha($fecha_valor);
  }

  // Obtenemos los números del sorteo así como sus reintegros.
  $bono_numeros = f_otros_numeuro($strapuesta, $bono_runo, $bono_rdos);
  $bono_reintegros = $bono_runo;

  // Formateamos los reintegros a dos números.
  // En "$bono_numeros"/"$bono_runo"/"$bono_rdos" nos pueden llegar una tabla.
  if (is_array($bono_runo)) {
    $bonoloto_pro = "";
    for ($i = 0; $i < count($bono_runo); $i++) {
      $reintegros[] = $bono_runo[$i];
    }
    for ($i = 0; $i < count($bono_numeros); $i++) {
      if ($i < 1) {
        $bonoloto_pro = $bono_numeros[$i];
      } else {
        $bonoloto_pro = $bonoloto_pro . " / " . $bono_numeros[$i];
      }
    }
  } else {
    $bonoloto_pro =  $bono_numeros;
    $bono_runo = number_format($bono_runo, 0, ',', '.');
    $reintegros[] = $bono_runo;
  }
  $bono_numeros = obtener_numeros_sorteo($bonoloto_pro);

  /*   echo "<pre>";
  echo "APUESTA BONOLOTO: " . var_dump($bono_numeros) . "<br><br>";
  echo "REI UNO:" . var_dump($bono_runo) . "<br><br>";
  echo "REI DOS:" . var_dump($bono_rdos) . "<br><br>"; */

  $apuesta_fija[] = [
    'titulo'     => $strtitulo,
    'subtitulo'  => $strsubtitulo,
    'color'      => "primary",
    'fechas'     => $bono_fecha,
    'imagen'     => "b_bonoloto.png",
    'icono'      => "icon-BonolotoAJ",
    'numeros'    => $bono_numeros,
    'reintegros' => $bono_reintegros,
    'premio'     => ""
  ];

  return $apuesta_fija;
}


/*
/   OTROS: Preparación de las apuestas de El Gordo
/   ==================================================
/
/   Formato:
/   El Gordo (14/08/2005):
/   01-12-39-42-47  R.6
/   /
/   25-26-42-43-50  R.6
/
*/
function prepara_otros_elgordo($strapuesta)
{

  // Incializar variable a devolver.
  $apuesta_fija = [];
  $gordo_runo = "";
  $gordo_rdos = "";
  $strtitulo = "El Gordo";
  $strsubtitulo = "Semanal";

  $gordo_fecha = f_otros_fechas($strapuesta);
  // Convertimos cada fecha a forma textual
  foreach ($gordo_fecha as $key => $fecha_valor) {
    $gordo_fecha[$key] = convierte_fecha($fecha_valor);
  }

  // Obtenemos los números del sorteo así como sus reintegros.
  $gordo_numeros = f_otros_numeuro($strapuesta, $gordo_runo, $gordo_rdos);
  $gordo_reintegros = $gordo_runo;

  // Formateamos los reintegros a dos números.
  // En "$gordo_numeros"/"$gordo_runo"/"$gordo_rdos" nos pueden llegar una tabla.
  if (is_array($gordo_runo)) {
    $gordo_pro = "";
    for ($i = 0; $i < count($gordo_runo); $i++) {
      $reintegros[] = $gordo_runo[$i];
    }
    for ($i = 0; $i < count($gordo_numeros); $i++) {
      if ($i < 1) {
        $gordo_pro = $gordo_numeros[$i];
      } else {
        $gordo_pro = $gordo_pro . " / " . $gordo_numeros[$i];
      }
    }
  } else {
    $gordo_pro =  $gordo_numeros;
    $gordo_runo = number_format($gordo_runo, 0, ',', '.');
    $reintegros[] = $gordo_runo;
  }
  $bono_numeros = obtener_numeros_sorteo($gordo_pro);

  $apuesta_fija[] = [
    'titulo'     => $strtitulo,
    'subtitulo'  => $strsubtitulo,
    'color'      => "primary",
    'fechas'     => $gordo_fecha,
    'imagen'     => "b_elgordo.png",
    'icono'      => "icon-ElGordoAJ",
    'numeros'    => $gordo_numeros,
    'reintegros' => $gordo_reintegros,
    'premio'     => ""
  ];

  return $apuesta_fija;
}







/////////////////////////////////////////////////
//                                             //
// Obtenemos los avisos para mostrar la inicio //
//  de la pantalla inicial.                    //
//                                             //
/////////////////////////////////////////////////
function obtener_avisos_entrada()
{

  // Accedemos a la tabla con las frases.
  global $frases_sliders, $frases_sliders_tam;

  // Inicializamos.
  $aavisos = [];

  // 1.- Obtenemos la frase del día
  $frase_dia = $frases_sliders[random_int(0, $frases_sliders_tam)];
  if (!$frase_dia) {
    $frase_dia = $frases_sliders[0];
  }
  $aavisos[] = [
    'titulo'     => "Para pensar",
    'subtitulo'  => $frase_dia,
    'imagen'     => "avisos-img-mensa",
    'autor'      => "Desconocido"
  ];

  // 2.- Día del último sorteo premiado y el valor obtenido.
  $misql = "SELECT fecha, premio FROM numapuesta WHERE premio > 0 ORDER BY fecha DESC LIMIT 1";
  $datos = consulta($misql);
  $row = fetch_array($datos);
  mysqli_free_result($datos);
  $frase_dia = "El pasado día " . convierte_fecha($row['fecha']) . " obtuvimos un premio de <strong>" . number_format(sprintf("%01.2f", $row['premio']), 2, ',', '.') . " &euro;</strong>";
  $aavisos[] = [
    'titulo'     => "Último premio",
    'subtitulo'  => $frase_dia,
    'imagen'     => "avisos-img-primitiva",
    'autor'      => ""
  ];

  // 3.- Saldo del bote.
  $misql = "SELECT SUM(importe) as totsaldo, MAX(fecha) as totfecha FROM aportaciones WHERE participante = 'BOTE'";
  $datos = consulta($misql);
  $row = fetch_array($datos);
  mysqli_free_result($datos);
  $frase_dia = "Nuestro bote a día " . convierte_fecha($row['totfecha']) . " asciende a <strong>" . number_format(sprintf("%01.2f", $row['totsaldo']), 2, ',', '.') . " &euro;</strong>";
  $aavisos[] = [
    'titulo'     => "Nuestro Bote",
    'subtitulo'  => $frase_dia,
    'imagen'     => "avisos-img-euromillones",
    'autor'      => ""
  ];

  // 4.- Total de premios anules.
  $ano_hoy = date('Y');
  $fecha_ini = "01-01-" . $ano_hoy . " 00:00:00";
  $fecha_ini = convierte_fecha($fecha_ini, "d-m-Y") . " 00:00:00";
  $fecha_fin = "31-12-" . $ano_hoy . " 00:00:00";
  $fecha_fin = convierte_fecha($fecha_fin, "d-m-Y") . " 00:00:00";
  $misql = "SELECT SUM(premio) as totsaldo FROM numapuesta WHERE fecha >= STR_TO_DATE('" . $fecha_ini . "' , '%d-%m-%Y %H:%i:%s') and  fecha <= STR_TO_DATE('" . $fecha_fin . "' , '%d-%m-%Y %H:%i:%s')";
  $datos = consulta($misql);
  $row = fetch_array($datos);
  mysqli_free_result($datos);
  $frase_dia = "Durante este año hemos obtenido <strong>" . number_format(sprintf("%01.2f", $row['totsaldo']), 2, ',', '.') . " &euro;</strong>";
  $aavisos[] = [
    'titulo'     => "Total Anual",
    'subtitulo'  => $frase_dia,
    'imagen'     => "avisos-img-loteria",
    'autor'      => ""
  ];

  // Desordenamos la tabla de avisos.
  $aavisos_bak = $aavisos;
  if (!shuffle($aavisos)) {
    $aavisos = $aavisos_bak;
  };

  // Devolvemos los valores obtenidos.
  return $aavisos;
}
