<?php

namespace App\DB;

use Perritu\LeanDB\Connection as LeanDBConnection;

class Connection extends LeanDBConnection
{
  public static function GetCredentials(): string
  {
    return Env('DB');
  }
}
