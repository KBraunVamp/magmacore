<?php

declare(strict_types=1);

namespace Magma\Flash;

interface FlashInterface {
   
    /**
     * Add a flash message stored with the session
     *
     * @param string $message
     * @param string $type
     * @return void
     */
    public static function add(string $message, string $type = FlashTypes::SUCCESS) : void;

    /**
     * Gets all messages within the session
     *
     * @return void
     */
    public static function get();

}