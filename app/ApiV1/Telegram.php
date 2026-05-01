<?php

namespace App\ApiV1;

use App\ApiSessions\ApiSessions;
use App\DB\Models\TelegramMessage;
use PDO;
use stdClass;

defined('TELEGRAM_CACHE_PATH') || define('TELEGRAM_CACHE_PATH', CACHE_PATH . '/Telegram');

class Telegram
{
  /**
   * Llama al API de Telegram y lo guarda en el log, y regresa el resultado como
   * `stdClass` o `null` si se llama de manera asincrona.
   *
   * @param string $cMethod
   * @param array $aData
   * @param bool $bAsync
   * @return stdClass|null
   */
  public static function Api(string $cMethod, array $aData, bool $bAsync = false): ?stdClass
  {
    static $cApikey = Env('TG_APIKEY');
    if (!$cApikey) throw new \RuntimeException('TG_APIKEY is not set');

    $cPayload = json_encode($aData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    static::Log("$cMethod > $cPayload");
    if (strlen($cPayload) > 150) {
      // is_dir(TELEGRAM_CACHE_PATH) || mkdir(TELEGRAM_CACHE_PATH, 0775, true);
      static $dummy = ShellExec("mkdir -p '" . TELEGRAM_CACHE_PATH . "';" .
        "find '" . TELEGRAM_CACHE_PATH . "' -type f -mmin +5 -delete", true);
      $uHash = hexdec(hash('crc32', $cPayload));
      $cPath = sprintf(
        "%s/%x.json",
        TELEGRAM_CACHE_PATH,
        (time() << 8) | $uHash
      );
      file_put_contents($cPath, $cPayload);
      $cPayload = "@$cPath";
    }

    $cCommand = "curl -d '$cPayload' -H 'Content-Type: application/json' "
      . "'https://api.telegram.org/bot$cApikey/$cMethod'";

    if ($bAsync) {
      ShellExec($cCommand, true);
      static::Log("< (i) Async call, ignore result");
      return null;
    }

    $aResult = ShellExec($cCommand);
    $oResult = json_decode(implode(PHP_EOL, $aResult));
    $cResult = json_encode($oResult, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); // Normalizar a una linea
    static::Log("< $cResult");
    return $oResult;
  }

  /**
   * Procesa los webhooks de Telegram
   *
   * @return void
   */
  public static function POST()
  {
    $cInput = file_get_contents('php://input');
    $aInput = json_decode($cInput, true);
    if (!$aInput) {
      static::Log('(!) No se pudo decodificar el mensaje');
      static::Log("< $cInput");
      http_response_code(400);
      return;
    }

    $aInput = array_keys($aInput);
    $oInput = json_decode($cInput);
    $cInput = json_encode($oInput, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    static::Log("(webhook) < $cInput");
    foreach ($aInput as $cKey) switch ($cKey) {
      case 'message':
        static::HandleMessage($oInput->message);
        continue 2;
      default:
        continue 2;
    }
  }

  // Funciones internas
  /**
   * Maneja los mensajes entrantes
   *
   * @param object $oMessage
   * @return void
   */
  protected static function HandleMessage(object $oMessage): void
  {
    $iChatId    = $oMessage->chat->id;
    $uMessageId = $oMessage->message_id;
    $uUser      = $oMessage->from->id;
    $cUser      = $oMessage->from->username;

    // Registra el mensaje en log y DB.
    static::Log(sprintf(
      '(i) UserID: %d, ChatID: %d, Username: %s',
      $uUser,
      $iChatId,
      $cUser
    ));

    TelegramMessage::Create([
      'ChatId'    => $iChatId,
      'MessageId' => $uMessageId,
      'UserId'    => $uUser,
      'Username'  => $cUser,
    ]);

    // Para grupos
    if ($iChatId < 0) {
      // No se responden a los mensajes de grupos.
      return;
    }

    // Comandos de Telegram
    switch (strtolower(trim($oMessage->text))) {
      case '/start':
      case '/comenzar':
        // Evento de actividad.
        static::Api('sendChatAction', [
          'chat_id' => $iChatId,
          'action' => 'typing',
        ], true);

        // Mensaje de bienvenida.
        $aTextMessage = ['Bienvenido a Furrys de Juarez'];
        $cAppEnv = Env('APP_ENV');
        if ($cAppEnv != 'prod') {
          $mAppVersion = Env('APP_VERSION', 'SNAPSHOT');
          $aTextMessage = [
            ...$aTextMessage,
            '```conf',
            "AppEnv:     $cAppEnv",
            "AppVersion: $mAppVersion",
            '```',
          ];
        } else $aTextMessage[] = '';

        $aTextMessage = [
          ...$aTextMessage,
          'Soy Beanites, mascota de la comunidad de **Furrys de Juarez**.',
          // '',
          'Conmigo puedes consultar información relacionada con tu perfil dentro de la comunidad.' . PHP_EOL,
          'Estos son los comandos disponibles:',
          '**/start**: Reinicia la sesión y muestra este mensaje. Esto **no elimina** tu información.',
          '**/bank**:  Te permite acceder a tu cuenta bancaria. (sistema de puntos)',
          '**/anon**:  Opcion para enviar un mensaje a la administración de forma anónima.',
        ];

        $cTextMessage = implode(PHP_EOL, $aTextMessage);
        $oResult = static::SendMessage(
          $iChatId,
          $cTextMessage,
          [
            'entities' => [
              ['type' => 'bot_command', ...TextOffset('/start', $cTextMessage)],
              ['type' => 'bot_command', ...TextOffset('/bank',  $cTextMessage)],
              ['type' => 'bot_command', ...TextOffset('/anon',  $cTextMessage)],
            ],
          ]
        );

        // $aMessages = range(max(1, $oResult->message_id - 90), $oResult->message_id - 1);

        $aMessages = [];
        $rMessages = TelegramMessage::Read([
          'ChatId' => $oResult->chat->id,
        ]);
        while ($oMessage = $rMessages->fetch(PDO::FETCH_OBJ)) {
          if ($oMessage->MessageId === $oResult->message_id) continue;
          $aMessages[] = $oMessage->MessageId;
        }

        if (count($aMessages) > 0) {
          static::Api('deleteMessages', [
            'chat_id' => $oResult->chat->id,
            'message_ids' => $aMessages,
          ], true);

          TelegramMessage::Delete([
            'ChatId' => $oResult->chat->id,
            'MessageId' => $aMessages,
          ]);
        }
        return;
      case '/bank':
        static::SendMessage($iChatId, 'Ups~ parece que no estas en el grupo de **Furrys de Juarez**.');
        return;
      case '/anon':
        is_dir(CACHE_PATH . '/Telegram') || mkdir(CACHE_PATH . '/Telegram', 0775, true);
        $oSession = ApiSessions::Instance($iChatId);
        $oSession->LastCMD = '/anon';
        static::SendMessage($iChatId, 'Escribe lo que deseas enviar a la administración.');
        return;
      default:
        $oSession = ApiSessions::Instance($iChatId);
        switch ($oSession->LastCMD) {
          case '/anon':
            $aMessage = explode(PHP_EOL, $oMessage->text);
            $aMessage = array_map((fn ($cMessage) => "> $cMessage"), $aMessage);
            $cMessage = implode(PHP_EOL, $aMessage);
            static::SendMessage($iChatId, 'Emitiendo mensaje...');
            static::SendMessage(
              Env('TG_ANON_CHANNEL'),
              implode(PHP_EOL, [
                "Mensaje anonimo:",
                $cMessage,
              ]),
              [
                'message_thread_id' => Env('TG_ANON_TOPIC'),
              ]
            );
        }
        break;
    }
  }

  /**
   * Envía un mensaje a Telegram
   *
   * @param string $iChatId
   * @param string $cText
   * @param array  $aOptions = []
   * @return stdClass
   */
  protected static function SendMessage(string $iChatId, string $cText, array $aOptions = []): stdClass
  {
    if (!isset($aOptions['parse_mode'])) $aOptions['parse_mode'] = 'MarkdownV2';
    if ($aOptions['parse_mode'] === 'MarkdownV2') {
      // '_[]()~`>#+-=|{}.!'
      $cText = preg_replace('/([_\[\]\(\)~#\+\-=|\{\}\.\!])/', '\\\\$1', $cText);
    }

    $oResult = static::Api('sendMessage', [
      'chat_id' => $iChatId,
      'text' => $cText,
      'parse_mode' => $aOptions['parse_mode'] ?? 'MarkdownV2',
      ...$aOptions,
    ]);
    TelegramMessage::Create([
      'ChatId'    => $oResult->result->chat->id,
      'MessageId' => $oResult->result->message_id,
      'UserId'    => $oResult->result->from->id,
      'Username'  => $oResult->result->from->username,
    ]);
    return $oResult->result;
  }

  /**
   * Register a log to Telegram log file
   *
   * @param string $cMessage
   * @return void
   */
  public static function Log(string $cMessage): void
  {
    static $rLogger = fopen(STORAGE_PATH . '/Logs/Telegram.log', 'a+');
    static $uLogger = (time() << 4) + random_int(0, 15);
    if (!$rLogger) return;
    fwrite($rLogger, sprintf(
      '[%s] %012x :: %s' . PHP_EOL,
      date('Y-m-d H:i:s'),
      $uLogger,
      $cMessage
    ));
  }
}
