<?php

declare(strict_types=1);

namespace Ads\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class AdDetailFactory
{
    public function __invoke(ContainerInterface $container): AdDetail
    {
        return new AdDetail($container->get(TemplateRendererInterface::class));
    }
}
