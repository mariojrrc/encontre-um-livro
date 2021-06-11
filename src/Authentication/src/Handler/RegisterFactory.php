<?php

declare(strict_types=1);

namespace Authentication\Handler;

use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class RegisterFactory
{
    public function __invoke(ContainerInterface $container): Register
    {
        return new Register($container->get(TemplateRendererInterface::class), $container->get(UrlHelper::class));
    }
}
