<?php

namespace App\DB\Models;

use App\DB\Connection;
use Perritu\LeanDB\{LeanDB, Model};

class FrontpageMembers extends Model
{
  public const CONNECTION = Connection::class;
  public const PERMS = LeanDB::PERM_CREATE | LeanDB::PERM_READ | LeanDB::PERM_DELETE;
  public const FIELDS = [
    // key => [tipo, longitud, default, comentario]
    'FrontpageMember' => [LeanDB::ID,                         null, null, 'Id interno'],
    'Name'            => [LeanDB::VARCHAR,                    75,   null, 'Nombre a mostrar'],
    'Picture'         => [LeanDB::VARCHAR,                    255,  null, 'Ruta a la imagen de avatar del perfil'],
    'Social1'         => [LeanDB::VARCHAR,                    255,  null, 'Enlace a red social 1'],
    'Social2'         => [LeanDB::VARCHAR | LeanDB::NULLABLE, 255,  null, 'Enlace a red social 2'],
    'Social3'         => [LeanDB::VARCHAR | LeanDB::NULLABLE, 255,  null, 'Enlace a red social 3'],
    'Social4'         => [LeanDB::VARCHAR | LeanDB::NULLABLE, 255,  null, 'Enlace a red social 4'],
    'Display'         => [LeanDB::UINT | LeanDB::NULLABLE,    1,    1,    'Indicador para mostrar el perfil'],
  ];

  public const SOFT_DELETES = false;
  public const TIMESTAMPS = false;
}
