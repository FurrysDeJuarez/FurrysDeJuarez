<?php

defined('ROOT_PATH')    || define('ROOT_PATH', dirname(__DIR__));
defined('APP_PATH')     || define('APP_PATH', ROOT_PATH . '/app');
defined('PUBLIC_PATH')  || define('PUBLIC_PATH', ROOT_PATH . '/public');
defined('STORAGE_PATH') || define('STORAGE_PATH', ROOT_PATH . '/storage');
defined('CACHE_PATH')   || define('CACHE_PATH', STORAGE_PATH . '/Cache');
defined('VIEWS_PATH')   || define('VIEWS_PATH', ROOT_PATH . '/views');

/**
 * Regresa una ruta con hash a un recurso en la carpeta pública para saltar el cache
 *
 * @param string $cResource
 * @return string
 */
function Asset(string $cResource): string
{
  $cPath = PUBLIC_PATH . "/$cResource";
  $cHash = hash_file('crc32', $cPath);
  return "$cResource?crc32=$cHash";
}

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
    if (is_file(CACHE_PATH . '/environment.php')) {
      $aEnv = require CACHE_PATH . '/environment.php';
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
        $cKey = trim($cKey);
        if ($cKey === '' || $cKey[0] === '#') continue;

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

      is_dir(CACHE_PATH) || mkdir(CACHE_PATH, 0777, true);
      file_put_contents(
        CACHE_PATH . '/environment.php',
        implode(PHP_EOL, [
          '<?php',
          'return ' . var_export($aEnv, true) . ';',
        ])
      );
    }
  }

  return $aEnv[$cName] ?? $_ENV[$cName] ?? $mDefault;
}

/**
 * Ejecuta un comando y regresa un array con la salida, o un array con el recurso
 * y los pipes del comando si se pide de manera asíncrona.
 *
 * @param string $cCommand
 * @param bool $bAsync
 * @return array
 */
function ShellExec(string $cCommand, bool $bAsync = false): array
{
  $rCommand = proc_open($cCommand, [
    ['pipe', 'r'],
    ['pipe', 'w'],
    ['pipe', 'w'],
  ], $aPipes);

  if ($bAsync) {
    return [
      'resource' => $rCommand,
      'pipes' => $aPipes,
    ];
  }

  $aOutput = [];
  while ($sLine = fgets($aPipes[1])) {
    $aOutput[] = trim($sLine, "\r\n");
  }
  proc_close($rCommand);

  return $aOutput;
}

/**
 * Regresa un array con `offset` y `length` de la posición de un texto en otro
 * texto, o `null` si no se encuentra
 *
 * @param string $cNeedle
 * @param string $cHaystack
 * @return array|null
 */
function TextOffset(string $cNeedle, string $cHaystack): ?array
{
  $uOffset = strpos($cHaystack, $cNeedle);
  if ($uOffset === false) return null;
  return [
    'offset' => $uOffset,
    'length' => strlen($cNeedle),
  ];
}

/**
 * Renderiza una vista
 *
 * @param string $cView
 * @param array $aData
 * @return void
 */
function View(string $cView, array $aData = []): void
{
  static $aViews = null;
  if (is_null($aViews)) {
    $bLoaded = false;
    if (is_file(CACHE_PATH . '/views.php')) {
      $aViews = require CACHE_PATH . '/views.php';
      $bLoaded = true;
    } else try {
      $aViews = [];
      $cViewsDir = VIEWS_PATH;
      $uViewsDir = strlen($cViewsDir);
      $rWalker = proc_open(
        "find $cViewsDir -type f -name '*.php'",
        [
          ['pipe', 'r'],
          ['pipe', 'w'],
          ['pipe', 'w'],
        ],
        $aPipes
      );

      if (!$rWalker)
        throw new Exception(''); ## Ir al fallback.

      while ($sLine = fgets($aPipes[1])) {
        $cPath = substr(trim($sLine), $uViewsDir + 1, -4);
        $cKey  = preg_replace('/(?i)[^\da-z]/', '.', $cPath);
        $aViews[$cKey] = "$cViewsDir/$cPath.php";
      }

      proc_close($rWalker);
    } catch (Exception $errDummy) { ## Fallback native.
      $aViews = [];
      $cViewsDir = VIEWS_PATH;
      $uViewsDir = strlen($cViewsDir);

      $fnWalker = function (string $cPath) use (&$aViews, $cViewsDir, $uViewsDir, &$fnWalker) {
        $aGlob = glob("$cPath/*");
        foreach ($aGlob as $cPath) {
          if (is_dir($cPath)) {
            $fnWalker($cPath);
            continue;
          }

          if (substr($cPath, -4) !== '.php')
            continue;

          $cPath = substr($cPath, $uViewsDir + 1, -4);
          $cKey  = preg_replace('/(?i)[^\da-z]/', '.', $cPath);
          $aViews[$cKey] = "$cViewsDir/$cPath.php";
        }
      };
      $fnWalker($cViewsDir);
    }

    if (!$bLoaded) {
      is_dir(CACHE_PATH) || mkdir(CACHE_PATH, 0777, true);
      file_put_contents(
        CACHE_PATH . '/views.php',
        implode(PHP_EOL, [
          '<?php',
          'return ' . var_export($aViews, true) . ';',
        ])
      );
    }
  }

  $cKey = preg_replace('/(?i)[^\da-z]/', '.', trim($cView));
  if (isset($aViews[$cKey])) {
    extract($aData);
    require $aViews[$cKey];
  }
}

if (Env('APP_ENV') === 'dev') {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}
