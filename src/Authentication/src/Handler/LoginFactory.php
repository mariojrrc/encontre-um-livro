<?php

declare(strict_types=1);

namespace Authentication\Handler;

use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class LoginFactory
{
    public function __invoke(ContainerInterface $container): Login
    {
        return new Login($container->get(TemplateRendererInterface::class), $container->get(UrlHelper::class));
    }
}
