<?php

declare(strict_types=1);

namespace Ads\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class CategoriesFactory
{
    public function __invoke(ContainerInterface $container): Categories
    {
        return new Categories($container->get(TemplateRendererInterface::class));
    }
}
