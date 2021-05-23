<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Container\ContainerInterface;

class NewRelicFactory
{
    public function __invoke(ContainerInterface $container): NewRelicMiddleware
    {
        return new NewRelicMiddleware($container->get('config')['newrelic_app_name']);
    }
}
