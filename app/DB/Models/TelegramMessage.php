<?php

namespace App\DB\Models;

use App\DB\Connection;
use Perritu\LeanDB\{LeanDB, Model};

class TelegramMessage extends Model
{
  public const CONNECTION = Connection::class;
  public const PERMS = LeanDB::PERM_CREATE | LeanDB::PERM_READ | LeanDB::PERM_DELETE;
  public const FIELDS = [
    // Estos dos hacen de llave compuesta.
    'ChatId'    => [LeanDB::INT | LeanDB::PKEY, 10, null, 'ID de chat de Telegram'],
    'MessageId' => [LeanDB::UINT | LeanDB::PKEY, null, null, 'ID del mensaje'],

    // Datos generales del mensaje.
    'UserId'   => [LeanDB::UINT, 10, null, 'ID del usuario de Telegram'],
    'Username' => [LeanDB::VARCHAR, 32, null, 'Username del usuario'],
  ];
}
