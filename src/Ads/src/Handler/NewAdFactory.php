<?php

declare(strict_types=1);

namespace Ads\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class NewAdFactory
{
    public function __invoke(ContainerInterface $container): NewAd
    {
        return new NewAd($container->get(TemplateRendererInterface::class));
    }
}
