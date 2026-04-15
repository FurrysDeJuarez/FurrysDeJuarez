<?php

namespace App;

use Perritu\Router\Router;

class App
{
  public static function Dispatch()
  {
    // Index
    Router::get('/', [Routes::class, 'Index']);

    // Apps
    Router::$CriteriaPrefix = '/Apps';
    Router::ANY('/Puntos', function () { ## Placeholder, temporal.
      header('Content-Type: text/plain; charset=utf-8');
      echo 'Sistema de Puntos';
    });

    // Api
    Router::USE('App\\ApiV1', '/api/v1/');

    ## 404
    http_response_code(404);
  }
}
