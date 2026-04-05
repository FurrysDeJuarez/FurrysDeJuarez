<?php

define('PUBLIC_PATH', __DIR__);
define('ROOT_PATH', dirname(__DIR__));

is_file(ROOT_PATH . '/vendor/autoload.php') || die('vendor/autoload.php not found');
require_once ROOT_PATH . '/vendor/autoload.php';

\App\App::Dispatch();
