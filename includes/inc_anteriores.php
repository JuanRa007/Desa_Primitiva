<?php
// Día último de actualización en aportaciones.
$apuesta = leer_apuesta_dia();
$fecha_apu = date("d/m/Y", strtotime($apuesta['fecha']));

// Obtenemos el mes pasado como parámetro o por defecto, el actual.
if ((!$_POST && !$_GET) || ($_POST && !isset($_POST['messel']) && !isset($_POST['anosel']) && !isset($_POST['fecsel'])) || ($_GET && !isset($_GET['messel']) && !isset($_GET['anosel']) && !isset($_GET['fecsel']))) {
  $fecha_dia = 0;
  $fecha_mes = date("n", time());
  $fecha_ano = date("Y", time());
} elseif ($_GET && isset($_GET['messel']) && isset($_GET['anosel'])) {
  $fecha_dia = 0;
  $fecha_mes = $_GET['messel'];
  $fecha_ano = $_GET['anosel'];
} elseif ($_POST && isset($_POST['messel']) && isset($_POST['anosel'])) {
  $fecha_dia = 0;
  $fecha_mes = $_POST['messel'];
  $fecha_ano = $_POST['anosel'];
} elseif ($_GET && isset($_GET['fecsel'])) {
  $fechacompleta = explode("/", $_GET['fecsel']);
  $fecha_dia = $fechacompleta[0];
  $fecha_mes = $fechacompleta[1];
  $fecha_ano = $fechacompleta[2];
} elseif ($_POST && isset($_POST['fecsel'])) {
  $fechacompleta = explode("/", $_POST['fecsel']);
  $fecha_dia = $fechacompleta[0];
  $fecha_mes = $fechacompleta[1];
  $fecha_ano = $fechacompleta[2];
}

// Convertimos a dos de longitud.
$fecha_dia = (strlen($fecha_dia) < 2)  ? "0" . $fecha_dia : $fecha_dia;
$fecha_mes = (strlen($fecha_mes) < 2)  ? "0" . $fecha_mes : $fecha_mes;

$calendario = obtener_calendario($fecha_mes, $fecha_ano);

// Si hay un día seleccionado, obtenmos sus apuestas.
$datos_apuestas = [];
if ($fecha_dia > 0) {
  $apuesta = leer_apuesta_dia($fecha_ano . "-" . $fecha_mes . "-" . $fecha_dia . " 00:00:00");
  $datos_apuestas = obtener_apuestas($apuesta);
}

// Punteros mes anterior y mes posterior.
$ano_ant = $fecha_ano;
$mes_ant = $fecha_mes;
$mes_ant--;
if ($mes_ant < 1) {
  $mes_ant = 12;
  $ano_ant--;
}
$ano_pos = $fecha_ano;
$mes_pos = $fecha_mes;
$mes_pos++;
if ($mes_pos > 12) {
  $mes_pos = 1;
  $ano_pos++;
}

$enlace_mes_ant = "anteriores.php?messel=" . $mes_ant . "&anosel=" . $ano_ant;
$enlace_mes_pos = "anteriores.php?messel=" . $mes_pos . "&anosel=" . $ano_pos;

//echo "<br><pre><code>";
//while ($myrow = fetch_array($datos)) {
//  echo $myrow['dfecha'] . "<br>";
//}
//echo "FDECHA: [" . $fecha_dia . "/" . $fecha_mes . "/" . $fecha_ano . "]<br><br>";
//echo print_r($datos_apuestas);
//echo "</code></pre><br>";
//exit();


?>

<!-- Nuestras apuestas -->

<section id="anteriores" class="bg-light pb-5">
  <div class="container text-center pt-5">
    <div class="row">
      <div class="col">
        <div class="info-cabecera mb-5">
          <h1 class="text-dark pb-3">
            Historial de Apuestas
          </h1>
          <p>Datos actualizados a fecha: <?= $fecha_apu ?></p>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <!-- DIV.ROW.COL -->
    <table class="table-sm table-bordered table-striped tabla-centra text-center">
      <thead>
        <tr>
          <th colspan="7">
            <span class="btn-group">
              <a class="btn btn-outline-info" href=<?= $enlace_mes_ant; ?>><i class="fas fa-angle-left"></i></a>
              <button type="button" class="btn btn-secondary"><?= obtener_nombre_mes_ano($fecha_mes, $fecha_ano); ?></button>
              <a class="btn btn-outline-info" href=<?= $enlace_mes_pos; ?>><i class="fas fa-angle-right"></i></a>
            </span>
          </th>
        </tr>
        <tr>
          <th>L</th>
          <th>M</th>
          <th>X</th>
          <th>J</th>
          <th>V</th>
          <th class="text-danger">S</th>
          <th class="text-danger">D</th>
        </tr>
      </thead>
      <tbody>

        <?php

        $total_celdas = count($calendario);
        $semana = 1;
        foreach ($calendario as $indice => $valor) {

          if ($semana == 1) {
        ?>
            <tr>
            <?php
          }

          // El texto de la celda, será el día.
          $cel_texto = $valor['dia'];

          // Estilo de la celda.
          $clase_celda = "";
          if ($valor['hoy']) {
            $clase_celda = "bg-primary text-white";
          } elseif ($valor['festivo']) {
            $clase_celda = "text-danger";
          } elseif ($valor['enlace']) {
            $clase_celda = "text-white bg-info";
            // Para los enlaces, el texto contendrá el enlace al día.
            $cel_texto = '<a class="' . $clase_celda . '" href=anteriores.php?fecsel=' . $valor["dia"] . '/' . $fecha_mes . '/' . $fecha_ano . '>' . $cel_texto . '</a>';
          }
            ?>
            <td class="<?= $clase_celda ?>"> <?= $cel_texto ?> </td>
            <?php
            $semana++;
            if ($semana > 7) {
              $semana = 1;
            ?>
            </tr>
        <?php
            }
          }
        ?>
      </tbody>
    </table>
    <table class="table-sm table-bordered table-striped tabla-centra text-center mt-5">
      <tbody>
        <form action="anteriores.php" method="post">
          <tr>
            <td>
              <select name="messel" class="custom-select custom-select-sm">
                <?= obtener_select_meses($fecha_mes) ?>
              </select>
            </td>
            <td>
              <select name="anosel" class="custom-select custom-select-sm">
                <?= obtener_select_anos($fecha_ano) ?>
              </select>
            </td>
            <td>
              <button type="submit" class="btn btn-secondary btn-sm">IR AL MES</button>
            </td>
          </tr>
        </form>
      </tbody>
    </table>

    <?php
    if ($fecha_dia > 0) {
    ?>
      <!--     RESTO -->
      <div class=" row">
        <div class="col-sm-6">
          <div class="info-cabecera mt-5">
            <h5 class="text-dark pb-3">
              Fecha sorteo: <?= $fecha_ano . "-" . $fecha_mes . "-" . $fecha_dia ?>
            </h5>
            <div class="alert alert-success text-center" role="alert">
              Sorteo: <span class="badge"><?= $fecha_ano . "-" . $fecha_mes . "-" . $fecha_dia ?></span>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="info-cabecera mt-5">
            <h5 class="text-dark pb-3">
              Premio: <?= $fecha_ano . "-" . $fecha_mes . "-" . $fecha_dia ?>
            </h5>
            <div class="alert alert-success text-center" role="alert">
              Sorteo: <span class="badge"><?= $fecha_ano . "-" . $fecha_mes . "-" . $fecha_dia ?></span>
            </div>
          </div>
        </div>
      </div>

      <?php
      // Recorremos todos las apuestas obtenidas.
      foreach ($datos_apuestas as $apuesta => $apuestas) {
        echo "APUESTA: " . $apuesta . "<br>";
        foreach ($apuestas as $indice => $valores) {
          echo "--> Indice: [" . $indice . "] --- >> [<br>";
          foreach ($valores as $j => $valor) {
            # code...
            echo "----> J: {" . $j . "} -> {";
            if (is_array($valor)) {
              echo implode(" = ", $valor);
            } else {
              echo $valor;
            }
            echo "}<br>";
          }
          echo "] << --- (Fin Indice)<br><br>";
        }
        echo "<hr>";
      }
      ?>

      <!--     RESTO -->
    <?php
    }
    ?>



  </div>
</section>