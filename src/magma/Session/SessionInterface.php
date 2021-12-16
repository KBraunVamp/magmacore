<?php

declare(strict_type=1);

namespace Magma\Session;

interface SessionInterface {

    public function set(string $key, $value) : void;

    public function setArray(string $key, $value) : void;
    
    public function get(string $key, $default = null);

    public function delete(string $key) : bool;
    
    public function invalidate() : void;
    
    public function flush(string $key, $value);

    public function has(string $key) : bool;

}