<?php

declare(strict_types=1);

namespace Ads\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class AdListFactory
{
    public function __invoke(ContainerInterface $container): AdList
    {
        return new AdList($container->get(TemplateRendererInterface::class));
    }
}
