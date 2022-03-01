<!-- Slider Ultimos Avisos -->
<?php
/* Posibles Avisos:
  - Último premio obtenido.
  - Saldo del bote
  - Otros avisos (¿¿???)

  Se puede generar una base de datos con los avisos a presentar.
  - Fechas de Vigencias (inicio - fin)
  - Texto del aviso.
  - Imagen a presentar (avisos-img-primitiva, etc.)
  -  
*/

// Obtenemos los avisos a presentar.
$av_avisos = [];
$av_avisos = obtener_avisos_entrada();

?>

<section id="avisos">
  <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
      <?php
      $active = true;
      $mensa = "";
      for ($i = 0; $i < count($av_avisos); $i++) {
        $mensa = $mensa . '<li data-target="#myCarousel" data-slide-to="' . $i . '"';
        if ($active) {
          $active = false;
          $mensa = $mensa . ' class="active"></li>';
        } else {
          $mensa = $mensa . '</li>';
        }
      }
      echo $mensa;
      ?>
    </ol>

    <div class="carousel-inner">

      <?php
      $active = true;
      foreach ($av_avisos as $av_key => $av_valor) {
      ?>
        <!-- Avisos -->
        <div class="carousel-item <?= $av_valor['imagen'] ?><?= ($active) ? " active" : "" ?>">
          <div class="container">
            <div class="carousel-caption text-right mb-5 text-white">
              <h1 class="display-4"><?= $av_valor['titulo'] ?></h1>
              <p class="lead">
                <?= $av_valor['subtitulo'] ?>
              </p>
            </div>
          </div>
        </div>
      <?php
        $active = false;
      }
      ?>
    </div>

    <!-- Selectores laterales -->
    <a href="#myCarousel" data-slide="prev" class="carousel-control-prev">
      <span class="carousel-control-prev-icon"></span>
    </a>
    <a href="#myCarousel" data-slide="next" class="carousel-control-next">
      <span class="carousel-control-next-icon"></span>
    </a>
  </div>
</section>