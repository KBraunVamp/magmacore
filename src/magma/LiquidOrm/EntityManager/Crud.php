<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EntityManager;

// use Magma\Base\Exception\BaseInvalidArgumentException;
// use Magma\Base\Exception\BaseUnexpectedValueException;
use Magma\LiquidOrm\DataMapper\DataMapper;
use Magma\LiquidOrm\QueryBuilder\QueryBuilder;
use Magma\LiquidOrm\EntityManager\CrudInterface;
use Throwable;

class Crud implements CrudInterface
{

    /** @var DataMapper */
    protected DataMapper $dataMapper;

    /** @var QueryBuilder */
    protected QueryBuilder $queryBuilder;

    /** @var string */
    protected string $tableSchema;

    /** @var string */
    protected string $tableSchemaID;

    /** @var array */
    protected array $options;

    /**
     * Main constructor
     *
     * @param DataMapper $dataMapper
     * @param QueryBuilder $queryBuilder
     * @param string $tableSchema
     * @param string $tableSchemaID
     */
    public function __construct(DataMapper $dataMapper, QueryBuilder $queryBuilder, string $tableSchema, string $tableSchemaID, ?array $options = [])
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
        $this->options = $options;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getSchema() : string
    {
        return (string)$this->tableSchema;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getSchemaID() : string
    {
        return (string)$this->tableSchemaID;
    }

    /**
     * @inheritdoc
     *
     * @return integer
     */
    public function lastID() : int
    {
        return $this->dataMapper->getLastId();
    }

    /**
     * @inheritdoc
     *
     * @param array $fields
     * @return boolean
     */
    public function create(array $fields = []) : bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'insert', 'fields' => $fields];
            $query = $this->queryBuilder->buildQuery($args)->insertQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
            if ($this->dataMapper->numRows() ==1) {
                return true;
            }
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    /**
     * @inheritdoc
     *
     * @param array $selectors
     * @param array $conditions
     * @param array $parameters
     * @param array $optional
     * @return array
     */
    public function read(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) : array
    {
        //try{
        $args = ['table' => $this->getSchema(), 'type' => 'select', 'selectors' => $selectors, 'conditions' => $conditions, 'params' => $parameters, 'extras' => $optional];
        $query = $this->queryBuilder->buildQuery($args)->selectQuery();
        $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions, $parameters));
        if ($this->dataMapper->numRows() >= 0) {
            return $this->dataMapper->results();
        } 
        //} catch(Throwable $throwable) {
            //throw $throwable;
        //}
    }

    /**
     * @inheritdoc
     *
     * @param array $fields
     * @param string $primaryKey
     * @return boolean
     */
    public function update(array $fields = [], string $primaryKey) : bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'update', 'fields' => $fields, 'primary_key' => $primaryKey];
            $query = $this->queryBuilder->buildQuery($args)->updateQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
        }catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    /**
     * @inheritdoc
     *
     * @param array $conditions
     * @return boolean
     */
    public function delete(array $conditions = []) : bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'delete', 'conditions' => $conditions];
            $query = $this->queryBuilder->buildQuery($args)->deleteQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
        }catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    /**
     * @inheritdoc
     *
     * @param array $selectors
     * @param array $conditions
     * @return array
     */
    public function search(array $selectors = [], array $conditions = []) : array
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'search', 'selectors' => $selectors, 'conditions' => $conditions];
            $query = $this->queryBuilder->buildQuery($args)->searchQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() >= 0) {
                return $this->dataMapper->results();
            }
        }catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    /**
     * @inheritDoc
     *
     * @param string $sqlQuery
     * @param array|null $conditions
     * @param string $resultType
     * @return void
     */
    public function rawQuery(string $rawQuery, ?array $conditions = []) {
        
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'raw', 'raw' => $rawQuery, 'conditions' => $conditions];
            $query = $this->queryBuilder->buildQuery($args)->rawQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() >= 0) {
                
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    /**
     * @inheritDoc
     *
     * @param array $selectors
     * @param array $conditions
     * @return Object|null
     */
    public function get(array $selectors = [], array $conditions = []) : ?Object
    {
        $args = ['table' => $this->getSchema(), 'type' => 'select', 'selectors' => $selectors, 'conditions' => $conditions];
        $query = $this->queryBuilder->buildQuery($args)->selectQuery();
        $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
        if ($this->dataMapper->numRows() >= 0) {
            return $this->dataMapper->result();
        }
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function aggregate(string $type, ?string $field = 'id', array $conditions = [])
    {
        $args = ['table' => $this->getSchema(), 'primary_key'=>$this->getSchemaID(), 
        'type' => 'select', 'aggregate' => $type, 'aggregate_field' => $field, 
        'conditions' => $conditions];

        $query = $this->queryBuilder->buildQuery($args)->selectQuery();
        $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
        if ($this->dataMapper->numRows() > 0)
            return $this->dataMapper->column();
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function countRecords(array $conditions = [], ?string $field = 'id') : int
    {
        if ($this->getSchemaID() !='') {
            return empty($conditions) ? $this->aggregate('count', $this->getSchemaID()) : $this->aggregate('count', $this->getSchemaID(), $conditions);
        }
    }
}