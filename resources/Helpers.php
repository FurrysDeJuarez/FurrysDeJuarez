<?php

defined('ROOT_PATH')    || define('ROOT_PATH', dirname(__DIR__));
defined('APP_PATH')     || define('APP_PATH', ROOT_PATH . '/app');
defined('PUBLIC_PATH')  || define('PUBLIC_PATH', ROOT_PATH . '/public');
defined('STORAGE_PATH') || define('STORAGE_PATH', ROOT_PATH . '/storage');
defined('VIEWS_PATH')   || define('VIEWS_PATH', ROOT_PATH . '/views');

/**
 * Regresa una variable de entorno
 *
 * @param string $cName
 * @param mixed $mDefault
 * @return mixed
 */
function Env(string $cName, mixed $mDefault = null): mixed
{
  static $aEnv = null;
  if (is_null($aEnv)) {
    $bLoaded = false;
    if (is_file(STORAGE_PATH . '/environment.php')) {
      $aEnv = require STORAGE_PATH . '/environment.php';
      $bLoaded = true;
    } elseif (is_file(ROOT_PATH . '/.env')) {
      $aEnv = parse_ini_file(ROOT_PATH . '/.env');
    } else {
      $aEnv = [];
    }

    if (!is_array($aEnv)) {
      $aEnv = [];
      $bLoaded = false;
    }

    if (!$bLoaded) {
      foreach ($aEnv as $cKey => $mValue) {
        $mValue = trim($mValue);
        $mValue = str_replace('"', '', $mValue);
        $mValue = match ($mValue) {
          'true', 'TRUE' => true,
          'false', 'FALSE' => false,
          'null', 'NULL', '' => null,
          default => $mValue,
        };

        if (is_string($mValue) && is_numeric($mValue))
          $mValue = (float) $mValue;

        $aEnv[$cKey] = $mValue;
      }

      file_put_contents(
        STORAGE_PATH . '/environment.php',
        implode(PHP_EOL, [
          '<?php',
          'return ' . var_export($aEnv, true) . ';',
        ])
      );
    }
  }

  return $aEnv[$cName] ?? $_ENV[$cName] ?? $mDefault;
}

if (Env('APP_ENV') === 'dev') {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}
