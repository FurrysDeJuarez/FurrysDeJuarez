<?php

namespace App;

use Perritu\Router\Router;

class App
{
  public static function Dispatch()
  {
    // Index
    Router::ANY('/', function () {
      View('index');
    });
  }
}
