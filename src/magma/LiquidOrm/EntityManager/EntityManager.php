<?php

declare(strict_type=1);

namespace Magma\LiquidOrm\EntityManager;

use Magma\LiquidOrm\EntityManager\CrudInterface;

class EntityManager implements EntityManagerInterface {

    /**
     * @var CrudInterface
     */
    protected CrudInterface $crud;

    /**
     * Main Constructor Class
     * @return void
     */
    public function __construct(CrudInterface $crud) {
        $this->crud = $crud;
    }

    /**
     * @inheritDoc
     */
    public function getCrud() : object {

        return $this->crud;
    }
}