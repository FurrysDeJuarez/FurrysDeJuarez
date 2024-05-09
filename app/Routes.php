<?php

namespace App;

use Perritu\Router\Router;

/**
 * Clase para la configuración de las rutas de la aplicación.
 *
 * Esta clase contiene métodos estáticos para cargar las rutas de la aplicación utilizando el
 * enrutador proporcionado por la librería Perritu\Router.
 *
 * @package App
 */
class Routes
{
  /**
   * Carga las rutas de la aplicación.
   *
   * Este método define las rutas de la aplicación utilizando el enrutador Perritu\Router.
   * En este ejemplo, se define una ruta para la raíz (`/`) que imprime 'Test ABC123' al ser accedida.
   *
   * @return void
   */
  public static function load()
  {
    Router::ANY('/', function () {
      view('index');
    });
  }
}
