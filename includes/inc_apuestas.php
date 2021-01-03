<?php

$apuesta = leer_apuesta_dia();
// Fecha apunte
$fecha_apu = convierte_fecha($apuesta['fecha']);
// Fecha diferencias0
$fecha_diff = fecha_diferencia($apuesta['fecha']);
// Obtenemos los datos preparados para mostrar de las apuestas.
$datos_apuestas = obtener_apuestas($apuesta);
// Buscamos si se han incluido mensajes para mostrar.
$aviso_titul = "";
$aviso_mensa = "";
$hay_aviso = buscar_aviso_apuesta($datos_apuestas, $aviso_titul, $aviso_mensa);

/* if (!$app_prod) {
  echo "<pre>";
  // echo print_r($datos_apuestas);
  echo "<br>";
  echo var_dump($datos_apuestas);
  echo "<br>";
  echo "<br>";
  echo "TOTAL REGISTROS:" . count($datos_apuestas);

  //echo "REGISTRO:" . print_r($datos_apuestas['primifija']) . "<br>";
  exit();
} */
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

    <?php
    //
    // Hay AVISO
    //
    if ($hay_aviso) {
    ?>
      <div class="jumbotron">
        <h1 class="display-4">AVISO:</h1>
        <hr class="my-4">
        <p class="h1 text-center"><strong><?= $aviso_titul ?></strong>
        <p class="h2 text-center"><strong><?= $aviso_mensa ?></strong>
        </p>
      </div>
    <?php
    }
    //
    // Hay PREMIO
    //
    if ($apuesta["premio"] > 0) {
    ?>
      <div class="jumbotron">
        <h1 class="display-4">PREMIO</h1>
        <hr class="my-4">
        <p class="h2 text-center">Hemos obtenido un premio por importe de <strong><?= genera_texto_importe($apuesta["premio"]) ?></strong>
        </p>
      </div>
    <?php
    }
    ?>

    <div class="row row-cols-1 row-cols-md-2 pt-5">

      <!-- ======= INICIO ======= -->
      <?php
      foreach ($datos_apuestas as $tipo_apuesta => $mi_apuesta) {
        $apuesta = $mi_apuesta[0];
        // Los avisos no se procesan.
        if ($tipo_apuesta == 'aviso') {
          continue;
        }
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
              <div class="alert <?= "alert-" . $apuesta["color"] ?> text-center" role="alert">
                Sorteo: <span class="badge"><?= genera_texto_fecha($apuesta["fechas"], $tipo_apuesta) ?></span>
              </div>
              <?php
              //
              // Presentación Para DÉCIMOS: Navidad, Once.
              //
              if ($tipo_apuesta == 'lotnavidad' || $tipo_apuesta == 'laonce') {
                // Obtenemos la serie y la fracción.
                $serie_fracc = explode('-', $apuesta["reintegros"]);
                $decimo_frontal = obtener_nombre_fichero_decimo($apuesta["nom_fich"], $tipo_apuesta, true);
                $decimo_trasera = obtener_nombre_fichero_decimo($apuesta["nom_fich"], $tipo_apuesta, false);
              ?>
                <div class="alert text-center">
                  <h1><?= $apuesta["numeros"] ?></h1>
                  <h5>Serie: <span class="badge"><?= $serie_fracc[0] ?></span></h5>
                  <?php if ($tipo_apuesta !== 'laonce') {
                  ?>
                    <h5>Fracción: <span class="badge"><?= $serie_fracc[1] ?></span></h5>
                  <?php } ?>
                </div>
                <div class="d-flex justify-content-center">
                  <a href="<?= $decimo_frontal ?>" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                    <img src="<?= $decimo_frontal ?>" class="img-fluid" alt="">
                  </a>
                  <a href="<?= $decimo_trasera ?>" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                    <img src="<?= $decimo_trasera ?>" class="img-fluid" alt="">
                  </a>
                </div>
                <?php
              } else {
                /* Inicio Contenido de la tarjeta: números */
                $ind_rei = 0;
                $numeros_sorteo = $apuesta["numeros"];
                $reintegros_sorteo = $apuesta["reintegros"];
                foreach ($numeros_sorteo as $indice => $numeros) {
                ?>
                  <div class="d-flex justify-content-center">
                    <ul class="list-inline text-monospace">

                      <?php
                      foreach ($numeros as $i => $num) {
                      ?>
                        <li class="list-inline-item p-1 mb-1 <?= "bg-" . $apuesta["color"] ?> rounded-circle shadow"><?= $num ?></li>
                      <?php
                      }
                      if (strpos($reintegros_sorteo[$ind_rei], "-") > 0) {
                        $rei_parcial = explode("-", $reintegros_sorteo[$ind_rei]);
                      ?>
                        <li class="list-inline-item p-1 mb-1 bg-warning rounded-circle shadow"><?= $rei_parcial[0]; ?></li>
                        <li class="list-inline-item p-1 mb-1 bg-warning rounded-circle shadow"><?= $rei_parcial[1]; ?></li>
                      <?php
                      } else {
                      ?>
                        <li class="list-inline-item p-1 mb-1 bg-warning rounded-circle shadow"><?= $reintegros_sorteo[$ind_rei] ?></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </div>
              <?php
                  $ind_rei += 1;
                }
                /* Fin Contenido de la tarjeta: números */
              }   // if ($tipo_apuesta) 
              ?>
              <!-- Submensaje -->
              <p class="card-text">
                <small class="text-muted">Actualizado hace <?= $fecha_diff ?>.</small>
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