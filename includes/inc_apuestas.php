<?php

$apuesta = leer_ultimo_dia();
$fecha_apu = convierte_fecha($apuesta['fecha']);

$datos_apuestas = obtener_apuestas($apuesta);
$primitiva_fija = $datos_apuestas["primitivafija"];
$primitiva_sema = $datos_apuestas["primitivasema"];


//echo "<br>";
//echo print_r($datos_apuestas);
//echo "<br>";
//echo var_dump($datos_apuestas);
//echo "<br>";
//echo "<br>";
//echo "TOTAL REGISTROS:" . count($datos_apuestas);

//echo "REGISTRO:" . $primitiva_fija[0]["titulo"] . "<br>";
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

      <div class="col mb-4">
        <div class="card text-black bg-light shadow">
          <img src="./img/<?= $primitiva_fija[0]["imagen"] ?>" class="card-img-top" alt="<?= $primitiva_fija[0]["titulo"] ?>">
          <div class="card-body">
            <h3 class="card-title">
              <span class="<?= $primitiva_fija[0]["icono"] ?>"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
              <?= $primitiva_fija[0]["titulo"] ?>
            </h3>
            <h6 class="card-subtitle mb-2 text-muted mb-4">
              <?= $primitiva_fija[0]["subtitulo"] ?>
            </h6>
            <hr />

            <!-- Pruebas con UL INLINE -->

            <?php
            $numeros_sorteo = $primitiva_fija[0]["numeros"];
            foreach ($numeros_sorteo as $indice => $numeros) {
            ?>
              <div class="container">
                <ul class="list-inline text-monospace">

                  <?php
                  foreach ($numeros as $i => $num) {
                  ?>
                    <li class="list-inline-item p-2 bg-success rounded-circle shadow"><?= $num ?></li>
                  <?php
                  }
                  ?>
                  <li class="list-inline-item p-2 bg-warning rounded-circle shadow"><?= $primitiva_fija[0]["reintegros"] ?></li>
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



    </div>
  </div>
</section>