<?php

declare(strict_type=1);

namespace Magma\GlobalManager;

Interface GlobalManagerInterface {
  
    /**
     * Set the global variables
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value) : void;

    /**
     * Get the value of the set global variable
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key);
}