<?php

declare(strict_types=1);

namespace App\Middleware;

use App\View\Helper\FlashMessenger;
use Psr\Container\ContainerInterface;

class SessionMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): SessionMiddleware
    {
        return new SessionMiddleware($container->get('session'), $container->get(FlashMessenger::class));
    }
}
