<?php

// Funcionalidad básica para instalar el proyecto.

use App\ApiV1\Telegram;
use App\DB\Connection;
use App\DB\Models\TelegramMessage;
use Perritu\LeanDB\LeanDB;

is_file(__DIR__ . '/vendor/autoload.php') || die('vendor/autoload.php not found');

function PutLog(string $cMessage)
{
  static $rLog = fopen(STORAGE_PATH . '/Logs/install.log', 'a+');
  fwrite($rLog, date('Y-m-d H:i:s') . " - $cMessage" . PHP_EOL);
}

$cStorage = __DIR__ . '/storage';
$rShell = proc_open("rm -rf '$cStorage/Cache';mkdir -p '$cStorage/Cache/Telegram' '$cStorage/Logs'", [
  ['pipe', 'r'],
  ['pipe', 'w'],
  ['pipe', 'w']
], $aPipes);
proc_close($rShell);

require_once __DIR__ . '/vendor/autoload.php';

PutLog("Instalación iniciada");

PutLog("Registrando Telegram");
Telegram::Api('deleteWebhook', ['drop_pending_updates' => true]);
Telegram::Api('setWebhook', [
  'url' => Env('APP_URL', 'https://canary.furrysdejuarez.com') . '/api/v1/Telegram'
]);

PutLog("Generando base de datos");

$cSQL = LeanDB::BuildSchema(TelegramMessage::class);
PutLog("DB: TelegramMessage\n$cSQL\n-----");
Connection::Query($cSQL);

PutLog("Instalación finalizada");
