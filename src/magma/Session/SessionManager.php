<?php

declare(strict_type=1);

namespace Magma\Session;

use Magma\Session\SessionFactory;

class SessionManager {

    public static function initialize() {

      $factory = new SessionFactory();
      
      return $factory->create('', \Magma\Session\Storage\NativeSessionStorage::class, array());
    }
}