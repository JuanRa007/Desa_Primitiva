<?php
$fecha_ult = obtener_saldos_fecha();
$saldos_part = obtener_saldos();
?>

<!-- Nuestras apuestas -->
<section id="saldos" class="bg-light pt-5">
  <div class="container text-center pt-5">
    <div class="row">
      <div class="col">
        <div class="info-cabecera mb-5">
          <h1 class="text-dark pb-3">
            Saldos Actuales
          </h1>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <caption>
              Saldos actualizados a la fecha de <?= $fecha_ult ?>.
            </caption>
            <thead class="thead-dark">
              <tr class="aling-center">
                <th>Participante</th>
                <th>Saldo Actual</th>
                <th>Ùlt.Movim.</th>
              </tr>
            </thead>
            <tbody>

              <?php
              foreach ($saldos_part as $usuario) {

                $participante = $usuario[0];
                $saldo = number_format(sprintf("%01.2f", $usuario[1]), 2, ',', '.');
                $fecha = convierte_fecha($usuario[2]);

                $clase = "";
                if ($participante == "BOTE" || $participante == "Cestillo") {
                  $clase = 'class="table-primary"';
                }

                $clase_celda = "";
                if ($saldo <= $app_saldominimo) {
                  $clase_celda = "table-danger";
                }

              ?>
                <tr <?= ($clase) ? $clase : "" ?>>
                  <td><?= $participante ?></td>
                  <td class="aling-right <?= ($clase_celda) ? $clase_celda : "" ?> "><?= $saldo ?></td>
                  <td class="aling-center"><?= $fecha ?></td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>