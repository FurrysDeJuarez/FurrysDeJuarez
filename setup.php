<?php

// Funcionalidad básica para instalar el proyecto.
is_file(__DIR__ . '/vendor/autoload.php') || die('vendor/autoload.php not found');

function ShellExec(string $cCommand)
{
  try {
    $rProcess = proc_open($cCommand, [
      ['pipe', 'r'],
      ['pipe', 'w'],
      ['pipe', 'w']
    ], $aPipes);

    if ($rProcess) {
      return [
        $rProcess,
        $aPipes,
      ];
    }
  } catch (\Throwable $errDummy) {
  }
  return null;
}

$cStorage = __DIR__ . '/storage';
if (file_exists($cStorage . '/Cache')) {
  [$rShell, $aPipes] = ShellExec("rm -rf '$cStorage/Cache'");
  proc_close($rShell);
}
[$rShell, $aPipes] = ShellExec("mkdir -p '$cStorage/Cache' '$cStorage/TG' '$cStorage/Logs'");
proc_close($rShell);

// Carga las dependencias.
require_once __DIR__ . '/vendor/autoload.php';

// Log del archivo de instalación.
$rLog = fopen(STORAGE_PATH . '/Logs/install.log', 'a+');
fwrite($rLog, date('Y-m-d H:i:s') . " - Instalación iniciada" . PHP_EOL);

// Telegram
$cTgApikey = Env('TG_APIKEY');
$cBaseUrl  = "https://api.telegram.org/bot$cTgApikey";
$cAppUrl   = Env('APP_URL', 'https://canary.furrysdejuarez.com');

$cCmd  = "curl '$cBaseUrl/deleteWebhook';";
$cCmd .= "curl '$cBaseUrl/setWebhook' -F url='$cAppUrl/api/v1/Tg';";

fwrite($rLog, date('Y-m-d H:i:s') . " - Ajustes de telegram:" . PHP_EOL);
fwrite($rLog, "> $cCmd" . PHP_EOL);
[$rRes, $aPipes] = ShellExec($cCmd);
while ($cLine = fgets($aPipes[1])) {
  fwrite($rLog, "> $cLine" . PHP_EOL);
}
proc_close($rRes);
