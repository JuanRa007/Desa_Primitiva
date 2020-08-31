<!-- Slider Ultimos Avisos -->
<!--  
      Posibles Avisos:
      - Apuesta Fija (la primitiva)
      - Apuesta secundaria (Euromillones o Primitiva)
      - Premio obtenido en el último sorteo (si ha sido positivo)
      - Saldo del bote
      - Otros avisos (¿¿???)


      Se puede generar una base de datos con los avisos a presentar.
      - Fechas de Vigencias (inicio - fin)
      - Texto del aviso.
      - Imagen a presentar (avisos-img-primitiva, etc.)
      - 
    -->
<?php



?>


<section id="avisos">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <div class="carousel-inner">
      <!-- Aviso primero -->
      <div class="carousel-item avisos-img-primitiva active">
        <div class="container">
          <div class="carousel-caption text-right mb-5 text-white">
            <h1 class="display-4">Primer Aviso</h1>
            <p class="lead">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae,
              commodi.
            </p>
          </div>
        </div>
      </div>

      <!-- Aviso segundo -->
      <div class="carousel-item avisos-img-euromillones">
        <div class="container">
          <div class="carousel-caption text-left mb-5 text-white">
            <h1 class="display-4">Segundo Aviso</h1>
            <p class="lead">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae,
              commodi.
            </p>
          </div>
        </div>
      </div>

      <!-- Aviso segundo -->
      <div class="carousel-item avisos-img-loteria">
        <div class="container">
          <div class="carousel-caption text-center mb-5 text-white">
            <h1 class="display-4">Tercer Aviso</h1>
            <p class="lead">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae,
              commodi.
            </p>
          </div>
        </div>
      </div>
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