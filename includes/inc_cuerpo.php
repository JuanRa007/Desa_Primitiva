<!-- Cuerpo de página -->
<?php

/* Sliders */
require_once("./includes/inc_sliders.php");

switch ($act_pagina) {
  case 'index.php':
    /* Apuestas */
    require_once("./includes/inc_apuestas.php");
    break;

  case 'saldos.php':
    /* Saldos */
    require_once("./includes/inc_saldos.php");
    break;

  case 'anteriores.php':
    /* Historial */
    require_once("./includes/inc_anteriores.php");
    break;

  case 'mensajes.php':
    /* Mensajes */
    require_once("./includes/inc_enconstruccion.php");
    break;

  case 'acercade.php':
    /* Acerca de */
    require_once("./includes/inc_acercade.php");
    break;

  default:
    /* Desconocido */
    require_once("./includes/inc_noteconozco.php");
    break;
}
