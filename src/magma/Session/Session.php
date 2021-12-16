<?php

declare(strict_type=1);

namespace Magma\Session;

use Magma\Session\Exception\SessionInvalidArgumentException;
use Magma\Session\Exception\SessionException;
use Magma\Session\SessionInterface;
use Magma\Session\Storage\SessionStorageInterface;

class Session implements SessionInterface{

    protected SessionStorageInterface $storage;

    protected string $sessionName;

    protected const SESSION_PATTERN = '/^[a-zA-Z0-9_\.]{1,64}$/';

    public function __construct(string $sessionName, SessionStorageInterface $storage = null) {

        if ($this->isSessionKeyValid($sessionName) === false) {

            throw new SessionInvalidArgumentException($sessionName . ' is not a valid session name');
        }

        $this->sessionName = $sessionName;
        $this->storage = $storage;
        
    }

    public function set(string $key, $value) : void {

        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->setSession($key, $value);
        } catch (\Throwable $th) {
            throw new SessionException('An exception was thrown in retrieving the key form the session storage' . $th);
        }
    }

    public function setArray(string $key, $value) : void {

        $this->ensureSessionKeyIsValid($key);
        try {
           $this->storage->setArraySession($key, $value); 
        } catch (\Throwable $th) {
           throw new SessionException('An exception was thrown in retrieving the key form the session storage' . $th);
        }
    }

    public function get(string $key, $default = null) {

        try {
            return $this->storage->getSession($key, $default);
        } catch (\Throwable $th) {
            throw new SessionException;
        }
    }

    public function delete(string $key) : bool {

        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->deleteSession($key);
        } catch (\Throwable $th) {
            throw new SessionException;
        }
    }
    
    public function invalidate() : void {

        $this->storage->invalidate();
    }
    
    public function flush(string $key, $value) {

        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->flush($key, $value);
        } catch (\Throwable $th) {
            throw new SessionException;
        }
    }

    public function has(string $key) : bool {

        $this->ensureSessionKeyIsValid($key);
        return $this->storage->hasSession($key);
    }

    protected function isSessionKeyValid(string $key) : bool {

        return (preg_match(self::SESSION_PATTERN, $key) === 1);
    }

    protected function ensureSessionKeyIsValid(string $key) : void {

        if ($this->isSessionKeyValid($key) === false) {
            throw new SessionInvalidArgumentException($key, ' is not a valid session key.');
        }
    }
}