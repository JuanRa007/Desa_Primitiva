<?php

$apuesta = leer_ultimo_dia();
$fecha_apu = convierte_fecha($apuesta['fecha']);

$datos_apuestas = obtener_apuestas($apuesta);
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
        <div class="card text-black bg-light border-dark shadow">
          <div class="card-body">
            <h3 class="card-title">
              <span class="icon-PrimitivaAJ"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
              Primtiva
            </h3>
            <h6 class="card-subtitle mb-2 text-muted mb-4">
              Primtiva Fija Semanal
            </h6>
            <hr />

            <p class="btn btn-success rounded-circle rounded-sm">
              <span class="badge badge-pill badge-light">04</span>
            </p>
            <p class="btn btn-success rounded-circle rounded-lg">
              <span class="badge badge-pill badge-light">34</span>
            </p>
            <p class="btn btn-success">
              <span class="badge badge-pill badge-light">33</span>
            </p>
            <p class="btn btn-success">
              <span class="badge badge-pill badge-light">23</span>
            </p>
            <p class="btn btn-success">
              <span class="badge badge-pill badge-light">65</span>
            </p>
            <p class="btn btn-success">
              <span class="badge badge-pill badge-light">23</span>
            </p>

            <p class="btn btn-warning">
              <span class="badge badge-pill badge-danger">04</span>
            </p>

            <p class="card-text">
              <small class="text-muted">Last updated 3 mins ago</small>
            </p>
          </div>
        </div>
      </div>

      <!-- CARD SEGUNDA -->
      <div class="col mb-4">
        <div class="card text-black bg-light shadow">
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