<?php

namespace App\ApiSessions;

use Perritu\ApiSessions\ApiSessions as Base;

class ApiSessions extends Base
{
  /**
   * Voids Garbage collection
   */
  protected function ____GarbageCollect(): void {}

  /**
   * Returns an instance of ApiSessions.
   *
   * @param string $cIdentity String to be hashed and used as identifier.
   * @param string|null $cStorageDir Directory to use as storage. Defaults to system temporary directory.
   *
   * @return static
   */
  public static function &Instance(string $cIdentity, ?string $cStorageDir = null): static
  {
    return parent::Instance($cIdentity, $cStorageDir ?? CACHE_PATH . '/Telegram');
  }
}
