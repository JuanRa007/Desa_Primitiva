<?php

$apuesta = leer_ultimo_dia();
$fecha_apu = convierte_fecha($apuesta['fecha']);

$datos_apuestas = obtener_apuestas($apuesta);
//$primitiva_fija = $datos_apuestas["primifija"];
//$primitiva_sema = $datos_apuestas["primisema"];


//echo "<br>";
//echo print_r($datos_apuestas);
//echo "<br>";
//echo var_dump($datos_apuestas);
//echo "<br>";
//echo "<br>";
//echo "TOTAL REGISTROS:" . count($datos_apuestas);

//echo "REGISTRO:" . print_r($datos_apuestas['primifija']) . "<br>";
//exit();
?>

<!-- Nuestras apuestas -->

<section id="apuestas" class="bg-light pb-5">
  <div class="container text-center pt-5">
    <div class="row">
      <div class="col">
        <div class="info-cabecera mb-5">
          <h1 class="text-dark pb-3">
            Apuestas Semanal
          </h1>
          <p>Datos actualizados a fecha: <?= $fecha_apu ?></p>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row row-cols-1 row-cols-md-2 pt-5">



      <!-- ======= INICIO ======= -->
      <?php
      foreach ($datos_apuestas as $indice => $mi_apuesta) {

        //echo "INDICE :" . $indice;
        $apuesta = $mi_apuesta[0];

      ?>

        <!-- ======= INICIO ======= -->

        <div class="col mb-4">
          <div class="card text-black bg-light shadow">
            <img src="./img/<?= $apuesta["imagen"] ?>" class="card-img-top" alt="<?= $apuesta["titulo"] ?>">
            <div class="card-body">
              <h3 class="card-title">
                <span class="<?= $apuesta["icono"] ?>"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
                <?= $apuesta["titulo"] ?>
              </h3>
              <h6 class="card-subtitle mb-2 text-muted mb-4">
                <?= $apuesta["subtitulo"] ?>
              </h6>
              <hr />
              <div class="alert alert-success text-center" role="alert">
                Sorteo: <span class="badge"><?= genera_texto_fecha($apuesta["fechas"]) ?></span>
              </div>

              <!-- Pruebas con UL INLINE -->

              <?php
              $numeros_sorteo = $apuesta["numeros"];
              foreach ($numeros_sorteo as $indice => $numeros) {

              ?>
                <div class="container">
                  <ul class="list-inline text-monospace text-center">

                    <?php
                    foreach ($numeros as $i => $num) {
                    ?>
                      <li class="list-inline-item p-2 bg-success rounded-circle shadow"><?= $num ?></li>
                    <?php
                    }
                    ?>
                    <li class="list-inline-item p-2 bg-warning rounded-circle shadow"><?= $apuesta["reintegros"] ?></li>
                  </ul>
                </div>
              <?php
              }
              ?>
              <!-- Submensaje -->
              <p class="card-text">
                <small class="text-muted">Last updated 3 mins ago</small>
              </p>
            </div>
          </div>
        </div>


        <!-- ======= FINAL ======= -->
      <?php
      }
      ?>
      <!-- ======= FINAL ======= -->



    </div>
  </div>
</section>