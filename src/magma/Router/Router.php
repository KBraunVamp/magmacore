<?php

declare(strict_types=1);

namespace Magma\Router;

use Magma\Router\RouterInterface;

class Router implements RouterInterface

{

    /**
     * returns an array of route from our routing table
     * @var array
     */
    protected array $routes = [];

    /**
     * returns an array of route parameters
     * @var array
     */
    protected array $params = [];

    /**
     * Adds a suffix onto the controller name
     * @var string
     */
    protected string $controllerSuffix = 'controller';

}