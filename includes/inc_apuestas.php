<?php

$apuesta = leer_ultimo_dia();
$fecha_apu = convierte_fecha($apuesta['fecha']);

$datos_apuestas = obtener_apuestas($apuesta);

//echo "<br>";
//echo print_r($datos_apuestas);
//echo "<br>";
//echo var_dump($datos_apuestas);
//echo "<br>";

echo "FECHAS: " . print_r($datos_apuestas['primitivafija']) . "<br>";

exit();
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
      <!-- CARD PRIMERA -->
      <div class="col mb-4">
        <div class="card text-black bg-light shadow">
          <img src="./img/b_primitiva.png" class="card-img-top" alt="Primitiva">
          <div class="card-body">
            <h3 class="card-title">
              <span class="icon-PrimitivaAJ"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
              Primtiva Fija Semanal
            </h3>
            <h6 class="card-subtitle mb-2 text-muted mb-4">
              Martes y Jueves
            </h6>
            <hr />

            <div class="container">
              <div class="alert alert-success text-center" role="alert">
                Sorteo: <span class="badge">14/08/2020 - 20/08/2020</span>
              </div>
              <p class="btn btn-success btn-sm rounded-circle">
                <span class="badge badge-pill badge-light">03</span>
              </p>
              <p class="btn btn-success btn-sm rounded-circle">
                <span class="badge badge-pill badge-light">13</span>
              </p>
              <p class="btn btn-success btn-sm rounded-circle">
                <span class="badge badge-pill badge-light">23</span>
              </p>
              <p class="btn btn-success btn-sm rounded-circle">
                <span class="badge badge-pill badge-light">32</span>
              </p>
              <p class="btn btn-success btn-sm rounded-circle">
                <span class="badge badge-pill badge-light">33</span>
              </p>
              <p class="btn btn-success btn-sm rounded-circle">
                <span class="badge badge-pill badge-light">43</span>
              </p>
              <p class="btn btn-warning btn-sm rounded-circle">
                <span class="badge badge-pill badge-danger">02</span>
              </p>
            </div>


            <div class="container">
              <p class="btn btn-success rounded-circle">
                <span class="badge badge-pill badge-light">09</span>
              </p>
              <p class="btn btn-success rounded-circle">
                <span class="badge badge-pill badge-light">17</span>
              </p>
              <p class="btn btn-success rounded-circle">
                <span class="badge badge-pill badge-light">19</span>
              </p>
              <p class="btn btn-success rounded-circle">
                <span class="badge badge-pill badge-light">29</span>
              </p>
              <p class="btn btn-success rounded-circle">
                <span class="badge badge-pill badge-light">39</span>
              </p>
              <p class="btn btn-success rounded-circle">
                <span class="badge badge-pill badge-light">49</span>
              </p>
              <p class="btn btn-warning rounded-circle">
                <span class="badge badge-pill badge-danger">02</span>
              </p>
            </div>


            <!-- Pruebas con UL INLINE -->
            <div class="container">
              <ul class="list-inline text-monospace">
                <li class="list-inline-item p-2 bg-success rounded-circle shadow">03</li>
                <li class="list-inline-item p-2 bg-success rounded-circle shadow">05</li>
                <li class="list-inline-item p-2 bg-success rounded-circle shadow">07</li>
                <li class="list-inline-item p-2 bg-success rounded-circle shadow">12</li>
                <li class="list-inline-item p-2 bg-success rounded-circle shadow">17</li>
                <li class="list-inline-item p-2 bg-success rounded-circle shadow">23</li>
                <li class="list-inline-item p-2 bg-warning rounded-circle shadow">7</li>
              </ul>
            </div>

            <!-- Submensaje -->
            <p class="card-text">
              <small class="text-muted">Last updated 3 mins ago</small>
            </p>
          </div>
        </div>
      </div>

      <!-- CARD SEGUNDA -->
      <div class="col mb-4">
        <div class="card text-black bg-light shadow">
          <img src="./img/b_bonoloto.png" class="card-img-top" alt="Bonoloto">
          <div class="card-body">
            <h3 class="card-title">
              <span class="icon-BonolotoAJ"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
              Bonoloto
            </h3>
            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
            <p class="card-text">
              This is a wider card with supporting text below as a natural
              lead-in to additional content. This content is a little bit
              longer.
            </p>
            <p class="card-text">
              <small class="text-muted">Last updated 3 mins ago</small>
            </p>
          </div>
        </div>
      </div>

      <!-- CARD TERCERA -->
      <div class="col mb-4">
        <div class="card text-success bg-light shadow">
          <img src="./img/b_euromillones.png" class="card-img-top" alt="Euromillones">
          <div class="card-body">
            <h3 class="card-title">
              <span class="icon-EuromillonesAJ"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
              Euromillones
            </h3>
            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
            <p class="card-text">
              This is a wider card with supporting text below as a natural
              lead-in to additional content. This content is a little bit
              longer.
            </p>
            <p class="card-text">
              <small class="text-muted">Last updated 3 mins ago</small>
            </p>
          </div>
        </div>
      </div>

      <!-- CARD CUARTA -->
      <div class="col mb-4">
        <div class="card text-success bg-light shadow">
          <div class="card-body">
            <h3 class="card-title">
              <span class="icon-ElGordoAJ"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
              El Gordo
            </h3>
            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
            <p class="card-text">
              This is a wider card with supporting text below as a natural
              lead-in to additional content. This content is a little bit
              longer.
            </p>
            <p class="card-text">
              <small class="text-muted">Last updated 3 mins ago</small>
            </p>
          </div>
        </div>
      </div>

      <!-- CARD QUINTA -->
      <div class="col mb-4">
        <div class="card text-success bg-light shadow">
          <div class="card-body">
            <h3 class="card-title">
              <span class="icon-LoteriaNacionalAJ"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
              Lotería Nacional
            </h3>
            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
            <p class="card-text">
              This is a wider card with supporting text below as a natural
              lead-in to additional content. This content is a little bit
              longer.
            </p>
            <p class="card-text">
              <small class="text-muted">Last updated 3 mins ago</small>
            </p>
          </div>
        </div>
      </div>

      <!-- FIN ROW -->
    </div>
  </div>
</section>