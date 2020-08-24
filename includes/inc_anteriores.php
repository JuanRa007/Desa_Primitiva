<?php
// Día último de actualización en aportaciones.
$apuesta = leer_ultimo_dia();
$fecha_apu = date("d/m/Y", strtotime($apuesta['fecha']));

// Obtenemos el mes pasado como parámetro o por defecto, el actual.
if (!$_POST || !isset($_POST['mes_sel']) || !isset($_POST['ano_sel']) || !isset($_POST['fecha_sel'])) {
  $fecha_dia = 0;
  $fecha_mes = date("n", time());
  $fecha_ano = date("Y", time());
} elseif (!$_POST['fecha_sel']) {
  $fecha_dia = 0;
  $fecha_mes = $_POST['mes_sel'];
  $fecha_ano = $_POST['ano_sel'];
} else {
  $fechacompleta = explode("/", $_POST['fecha_sel']);
  $fecha_dia = $fechacompleta[0];
  $fecha_mes = $fechacompleta[1];
  $fecha_ano = $fechacompleta[2];
}

$calendario = obtener_calendario($fecha_mes, $fecha_ano);

//echo "<br><pre><code>";
//while ($myrow = fetch_array($datos)) {
//  echo $myrow['dfecha'] . "<br>";
//}
//echo print_r($calendario);
//echo "</code></pre><br>";



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
    <div class="row">
      <div class="col">
        <table class="table-sm table-bordered table-striped tabla-centra text-center">
          <thead>
            <tr>
              <th colspan="7">
                <span class="btn-group">
                  <a class="btn btn-outline-info"><i class="fas fa-angle-left"></i></a>
                  <button type="button" class="btn btn-secondary"><?= obtener_nombre_mes_ano($fecha_mes, $fecha_ano); ?></button>
                  <a class="btn btn-outline-info"><i class="fas fa-angle-right"></i></a>
                </span>
              </th>
            </tr>
            <tr>
              <th>L</th>
              <th>M</th>
              <th>X</th>
              <th>J</th>
              <th>V</th>
              <th>S</th>
              <th>D</th>
            </tr>
          </thead>
          <tbody>


            <?php   ?>



            <tr>
              <td class="text-muted">29</td>
              <td class="text-muted">30</td>
              <td class="text-muted">31</td>
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
            </tr>



            <?php   ?>


          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>