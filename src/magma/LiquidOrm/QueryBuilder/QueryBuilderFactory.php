<?php

declare(strict_type=1);

namespace Magma\LiquidOrm\QueryBuilder;

use Magma\LiquidOrm\QueryBuilder\Exception\QueryBuilderException;
use Magma\LiquidOrm\QueryBuilder\QueryBuilderInterface;

class QueryBuilderFactory {

    /**
     * Main Constructor Class
     * 
     * @return void
     */
    public function __construct() {

    }

    public function create(string $queryBuilderString) : QueryBuilderInterface {
        $queryBuilderObject = new $queryBuilderString();
        if (!$queryBuilderString instanceof QueryBuilderInterface) {
            throw new QueryBuilderException($queryBuilderString . ' is not as a valid query builder object');
        }
        return new QueryBuilder();
    }
}