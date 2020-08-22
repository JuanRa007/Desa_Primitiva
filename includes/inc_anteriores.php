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
        <table class="table-sm table-bordered table-striped tabla-centra">
          <thead>
            <tr>
              <th colspan="7">
                <span class="btn-group">
                  <a class="btn"><i class="icon-chevron-left"></i></a>
                  <a class="btn active">February 2012</a>
                  <a class="btn"><i class="icon-chevron-right"></i></a>
                </span>
              </th>
            </tr>
            <tr>
              <th>Su</th>
              <th>Mo</th>
              <th>Tu</th>
              <th>We</th>
              <th>Th</th>
              <th>Fr</th>
              <th>Sa</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="muted">29</td>
              <td class="muted">30</td>
              <td class="muted">31</td>
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
            </tr>
            <tr>
              <td>5</td>
              <td>6</td>
              <td>7</td>
              <td>8</td>
              <td>9</td>
              <td>10</td>
              <td>11</td>
            </tr>
            <tr>
              <td>12</td>
              <td>13</td>
              <td>14</td>
              <td>15</td>
              <td>16</td>
              <td>17</td>
              <td>18</td>
            </tr>
            <tr>
              <td>19</td>
              <td class="btn-primary"><strong>20</strong></td>
              <td>21</td>
              <td>22</td>
              <td>23</td>
              <td>24</td>
              <td>25</td>
            </tr>
            <tr>
              <td>26</td>
              <td>27</td>
              <td>28</td>
              <td>29</td>
              <td class="muted">1</td>
              <td class="muted">2</td>
              <td class="muted">3</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>