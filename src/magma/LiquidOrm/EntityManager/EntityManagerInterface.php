<?php

declare(strict_type=1);

namespace Magma\LiquidOrm\EntityManager;

interface EntityManagerInterface {
    public function getCrud() : object; 
}