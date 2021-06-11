<?php

declare(strict_types=1);

namespace Authentication\Handler;

use Mezzio\Helper\UrlHelper;
use Psr\Container\ContainerInterface;

class LogoutFactory
{
    public function __invoke(ContainerInterface $container): Logout
    {
        return new Logout($container->get(UrlHelper::class));
    }
}
