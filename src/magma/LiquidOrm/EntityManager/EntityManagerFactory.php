<?php

declare(strict_type=1);

namespace Magma\LiquidOrm\EntityManager;

use Magma\LiquidOrm\EntityManager\Exception\CrudException;
use Magma\LiquidOrm\EntityManager\EntityManagerInterface;
use Magma\LiquidOrm\QueryBuilder\QueryBuilderInterface;
use Magma\LiquidOrm\DataMapper\DataMapperInterface;

class EntityManagerFactory {

    protected DataMapperInterface $dataMapper;

    protected QueryBuilderInterface $queryBuilder;

    /**
     * Main Constructor Class
     */
    public function __construct(DataMapperInterface $dataMapper, QueryBuilderInterface $queryBuilder) {
       
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * 
     */
    public function create(string $crudString, string $tableSchema, string $tableSchemaID, array $options = []) : EntityManagerInterface {

        $crudObject = new $crudString($this->dataMapper, $this->queryBuilder, $tableSchema, $tableSchemaID);
        if (!$crudObject instanceof CrudInterface) {
            throw new CrudException($crudString . ' is not a valid crud object.');
        }
        return new EntityManager($crudObject);
    }
}
