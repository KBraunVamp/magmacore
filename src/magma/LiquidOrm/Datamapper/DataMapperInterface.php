<?php

declare(strict_type=1);

namespace Magma\LiquidOrm\DataMapper;

Interface DataMapperInterface {

    /**
     * Prepare the query string
     * 
     * @param string $sqlquery
     * @return self
     */
   public function prepare(string $sqlquery) : self;
   
   /**
    * 
    */
   public function bind($value);

   /**
    * 
    */
    public function bindParameters(array $fields, bool $isSearch = false);

    /**
     * 
     */
    public function numRows() : int;

    /**
     * 
     */
  public function execute() : void;

    /**
     * 
     */
    public function result() : Object;

    /**
     * 
     */
    Public function results() : array;

    /**
     * Returns a database column
     * 
     * @return mixed
     */
    public function column();

    /**
     * Returns the last inserted row ID from database table
     * 
     * @return int
     * @throws Throwable
     */
    public function getLastId() : int;
}    