<?php
$fecha_ult = obtener_saldos_fecha();
$saldos_part = obtener_saldos();

//var_dump($saldos_part);

?>

<!-- Nuestras apuestas -->
<section id="saldos" class="bg-light pb-5">
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
          <table class="table table-striped">
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
                $saldo = $usuario[1];
                $fecha = $usuario[2];

                echo $participante . "-" . $saldo . "-" . $fecha . "<br>";


              ?>
                <tr class="table-primary">
                  <td>BOTE</td>
                  <td class="aling-right">248,67</td>
                  <td class="aling-center">25/03/2020</td>
                </tr>

              <?php
              }
              ?>


              <tr class="table-primary">
                <td>Cestillo</td>
                <td class="aling-right">431,34</td>
                <td class="aling-center">23/12/2019</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>