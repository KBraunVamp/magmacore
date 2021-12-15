<?php

declare(strict_type=1);

namespace Magma\DatabaseConnection;

use PDO;

Interface DatabaseConnectionInterface {

    /**
     * Create a new database connection
     * 
     * @return PDO
     */
    public function open() : PDO;

    /**
     * Close database connection
     */
    public function close() : void;
} 