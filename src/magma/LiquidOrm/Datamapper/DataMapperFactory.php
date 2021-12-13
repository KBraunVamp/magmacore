<?php

declare(strict_type=1);

namespace Magma\LiquidOrm\DataMapper;

use Magma\DatabaseConnection\DatabaseConnectionInterface;

use Magma\LiquidOrm\DataMapper\Exception\DataMapperException;

class DataMapperFactory {

    /**
     * Main Constructor class
     * 
     * @return void
     */
    public function __construct() {

    }

    public function create(string $databaseConnectionString, string $dataMapperEnvironmentConfiguration) : DataMapperInterface {
        $credentials = (new $dataMapperEnvironmentConfiguration())->getDatabaseCredentials();
        $databaseConnectionObject = $databaseConnectionString($credentials);
        if (!$databaseConnectionObject instanceof DatabaseConnectionInterface) {
            throw new DataMapperException($databaseConnectionString . ' is not a valid database connection object');
        }
        return new DataMapper($databaseConnectionObject);
    }                  
}
