<?php

/**
 * Archivo de punto de entrada principal para la aplicación.
 *
 * Este archivo carga las dependencias, define constantes y carga las rutas de
 * la aplicación. Si ocurre algún error durante el proceso, se informa sobre la
 * falta de configuración o se maneja un fallo del servidor.
 */

if (!file_exists('../vendor/autoload.php')) {
  die('Server not ready. Composer setup required.');
}

require_once '../vendor/autoload.php';

if (defined('PUBLIC_DIR') || defined('ROOT_DIR')) {
  die('Server not ready. Definition conflicted.');
}

define('PUBLIC_DIR', __DIR__);
define('ROOT_DIR', dirname(__DIR__));

try {
  \App\Routes::load();
} catch (Exception $e) {
  // TODO: Informar el fallo al administrador del sistema, no al usuario final.
  die('Server failure.');
}
