<?php 

declare(strict_types=1);

namespace Magma\LiquidOrm;

use Magma\DatabaseConnection\DatabaseConnection;
use Magma\LiquidOrm\DataMapper\DataMapperEnvironConfiguration;
use Magma\LiquidOrm\DataMapper\DataMapperFactory;
use Magma\LiquidOrm\EntityManager\EntityManagerFactory;
use Magma\LiquidOrm\QueryBuilder\QueryBuilderFactory;
use Magma\LiquidOrm\QueryBuilder\QueryBuilder;

class LiquidOrmManager {

    protected string $tableSchema;

    protected string $tableSchemaID;

    protected array $options;

    protected DataMapperEnvironConfiguration $environmentConfiguration;

    public function __construct(DataMapperEnvironConfiguration $environmentConfiguration, string $tableSchema, string $tableSchemaID, ?array $options = []) {

        $this->environmentConfiguration = $environmentConfiguration;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
        $this->options = $options;
    }

    public function initialize() {
        $dataMapperFactory = new DataMapperFactory();
        $dataMapper = $dataMapperFactory->create(DatabaseConnection::class, DataMapperEnvironConfiguration::class);
        if ($dataMapper) {
            $queryBuilderFactory = new QueryBuilderFactory();
            $queryBuilder = $queryBuilderFactory->create(QueryBuilder::class);
            if ($queryBuilder) {
                $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);
                return $entityManagerFactory->create(Crud::class, $this->tableschema, $this->tableSchemaID, $this->options);
            }
        }
    }
    
}